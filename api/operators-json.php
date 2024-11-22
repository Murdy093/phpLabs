<?php
require_once('../app/OperatorsList.php');
$opList=new OperatorsList();
session_start();
if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}    
$opList->readFromFile();
if($_SERVER['REQUEST_METHOD']=="POST"){
    $opData=json_decode(file_get_contents('php://input'), TRUE);
    $opList->add($opData);
    $opList->saveToFile();
} else if($_SERVER['REQUEST_METHOD']=="PUT"){
    $opData=json_decode(file_get_contents('php://input'), TRUE);
    $opList->update($opData);
    $opList->saveToFile();
} else if($_SERVER['REQUEST_METHOD']=="DELETE"){
    $opData=json_decode(file_get_contents('php://input'), TRUE);
    $opList->delete($opData['id']);
    $opList->saveToFile();
}
echo $opList->exportAsJSON();