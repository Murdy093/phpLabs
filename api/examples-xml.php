<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('../ExamplesList.php');
header('Content-Type: text/xml; charset=utf-8');
$row = false;
$exlist = new ExamplesList();
if (($handle = fopen("../data/examples.csv", "r")) !== false) {
    while (($data = fgetcsv($handle,1000,",")) !== false) {
        if ($row) {
            $exlist->add(array('example_text'=>$data[0]));
        } else
        $row = true;
    }
    fclose($handle);
    echo $exlist->exportAsXML();
}
