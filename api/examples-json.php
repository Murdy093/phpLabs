<?php
require_once('../app/ExamplesList.php');
$exList=new ExamplesList();
session_start();
if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}    
$exList->readFromFile();
if($_SERVER['REQUEST_METHOD']=="POST"){
    $exData=json_decode(file_get_contents('php://input'), TRUE);
    $exList->add($exData);
    $exList->saveToFile();
} else if($_SERVER['REQUEST_METHOD']=="PUT"){
    $exData=json_decode(file_get_contents('php://input'), TRUE);
    $exList->update($exData);
    $exList->saveToFile();
} else if($_SERVER['REQUEST_METHOD']=="DELETE"){
    $exData=json_decode(file_get_contents('php://input'), TRUE);
    $exList->delete($exData['id']);
    $exList->saveToFile();
}
echo $exList->exportAsJSON();