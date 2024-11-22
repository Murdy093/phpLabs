<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../OperatorsList.php');
header('Content-Type: text/xml; charset=utf-8');
$row = false;
$oplist = new OperatorsList();
if (($handle = fopen("../data/operators.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $oplist->add(array('operator_name'=>$data[0], 'description'=>$data[1], 'category'=>$data[2], 'example'=>$data[3]));
        } else
        $row = true;
    }
    fclose($handle);
    echo $oplist->exportAsXML();
}
