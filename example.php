<?php
require_once('class.ArraySortUtil.php');

// declare test data
$assetData[] = array("id" => 1, "category"=>"Hardware", "subcategory"=>"Personal Computer", "supplier" => "DELL", "particular"=>"Vostro 1320", "purchase_price"=>2300, "other_charges"=>500);
$assetData[] = array("id" => 2, "category"=>"Hardware", "subcategory"=>"Personal Computer", "supplier" => "DELL", "particular"=>"Vostro 1420", "purchase_price"=>2500, "other_charges"=>0);
$assetData[] = array("id" => 3, "category"=>"Hardware", "subcategory"=>"Laptop", "supplier" => "DELL", "particular"=>"Vostro 1520", "purchase_price"=>4500, "other_charges"=>100);
$assetData[] = array("id" => 4, "category"=>"Hardware", "subcategory"=>"Laptop", "supplier" => "Acer", "particular"=>"Apire One", "purchase_price"=>2500, "other_charges"=>200);
$assetData[] = array("id" => 5, "category"=>"Furniture", "subcategory"=>"Table", "supplier" => "CHEN", "particular"=>"Manager Table", "purchase_price"=>1000, "other_charges"=>0);
$assetData[] = array("id" => 6, "category"=>"Furniture", "subcategory"=>"Table", "supplier" => "CHEN", "particular"=>"Staff Table", "purchase_price"=>500, "other_charges"=>0);
$assetData[] = array("id" => 7, "category"=>"Furniture", "subcategory"=>"Chair", "supplier" => "CHEN", "particular"=>"Staff Chair", "purchase_price"=>500, "other_charges"=>0);

$sorted = ArraySortUtil::multisort($assetData, array(
        array("field"=>"category"),
        array("field"=>"subcategory", "order" => true)  // desc
    ));

echo "<h1>multisort:result</h1>";
echo "<pre>";
  print_r($sorted);
echo "</pre>";


$sorted = ArraySortUtil::uasort($assetData, array(
        array("field"=>"category"),
        array("field"=>"subcategory", "order" => true)  // desc
    ));

echo "<h1>uasort:result</h1>";
echo "<pre>";
  print_r($sorted);
echo "</pre>";