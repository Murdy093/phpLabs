<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../CategoryList.php');
header('Content-Type: text/xml; charset=utf-8');
$row = false;
$catlist = new CategoryList();
if (($handle = fopen("../data/category.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $catlist->add(array('name'=>$data[0]));
        } else
        $row = true;
    }
    fclose($handle);
    echo $catlist->exportAsXML();
}