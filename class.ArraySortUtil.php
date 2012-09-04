<?php
/**
 * ArraySortUtil is a array sort utility, you can extends the sorting engine.
 *
 * @version 0.1
 * @author coderkk Cudnik <coderkk@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @package utility.sort
 */
 
class ArraySortUtil
{
    static function uasort($unsort, $fields)
    {
        if ( !is_array($unsort) || sizeof($unsort) <= 0 ) return $unsort;
        $sorted = uasortEngine::uasort($unsort, $fields);
        return $sorted;
    }
    static function multisort($unsort, $fields)
    {
        if ( !is_array($unsort) || sizeof($unsort) <= 0 ) return $unsort;
        $sorted = multisortEngine::multisort($unsort, $fields);
        return $sorted;
    }
}

class multisortEngine
{
    static function multisort($unsort, $fields)
    {
        $sorted = $unsort;
        if (is_array($unsort))
        {
            $loadFields = array();
            foreach($fields as $sortfield)
            {
                $loadFields["field"][] = array(
                                "name" => $sortfield["field"],
                                "order" => $sortfield["order"],
                                "nature" => $sortfield["nature"],
                                "caseSensitve" => $sortfield["caseSensitve"]
                );
                $loadFields["data"][$field["field"]] = array();
            }
            // Obtain a list of columns
            foreach ($sorted as $key => $row) {
                foreach($loadFields["field"] as $field) {
                    $value = $row[$field["name"]];
                    $loadFields["data"][$field["name"]][$key] = $value;
                }
            }
            $parameters = array();
            foreach($loadFields["field"] as $sortfield) {
                $array_data = $loadFields["data"][$sortfield["name"]];
                $caseSensitve = ( $sortfield["caseSensitve"] == null ) ? $sortfield["caseSensitve"] : false;
                if (!$caseSensitve) $array_data = array_map('strtolower', $array_data);
                $parameters[] = $array_data;
                if ( $sortfield["order"] != null ) $parameters[] = ( $sortfield["order"] ) ? SORT_DESC : SORT_ASC;
                if ( $sortfield["nature"] != null ) $parameters[] = ( $sortfield["nature"] ) ? SORT_REGULAR : SORT_STRING;
            }
            $parameters[] = &$sorted;
            call_user_func_array("array_multisort", $parameters);
        }
        return $sorted;
    }
}

class uasortEngine
{
    static private $caseSensitve = false;
    static private $sortfields = array();
    static private $sortorder = true;
    static private $nature = false;

    static private function uasort_callback(&$a, &$b)
    {
        foreach(self::$sortfields as $sortfield)
        {
            $_field = $sortfield["field"];
            $_order = isset($sortfield["order"]) ? $sortfield["order"] : self::$sortorder;
            $_caseSensitve = isset($sortfield["caseSensitve"]) ? $sortfield["caseSensitve"] : self::$caseSensitve;
            $_nature = isset($sortfield["nature"]) ? $sortfield["nature"] : self::$nature;
            if ($_field != "")
            {
                $retval  = 0;
                if ($_nature)
                {
                    if ($_caseSensitve)
                    {
                        $compare = strnatcmp($a[$_field], $b[$_field]);
                    }
                    else
                    {
                        $compare = strnatcasecmp($a[$_field], $b[$_field]);
                    }
                }
                else
                {
                    if ($_caseSensitve)
                    {
                        $compare = strcmp($a[$_field], $b[$_field]);
                    }
                    else
                    {
                        $compare = strcasecmp($a[$_field], $b[$_field]);
                    }
                }
                if ($compare !== 0 && !$_order) $compare = ($compare > 0) ? -1 : 1;
            }
            if ($compare !== 0) break;
        }
        return $compare;
    }
    static function uasort($unsort, $fields)
    {
        self::$sortfields = $fields;
        $sorted = $unsort;
        uasort($sorted, array('uasortEngine', 'uasort_callback'));
        return $sorted;
    }
}