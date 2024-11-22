<?php
require_once('../app/CategoryList.php');
$catList=new CategoryList();
session_start();
if(!isset($_SESSION['user'])){
  echo json_encode(array("login"=>false));
  die();
}    
$catList->readFromFile();
if($_SERVER['REQUEST_METHOD']=="POST"){
    $catData=json_decode(file_get_contents('php://input'), TRUE);
    $catList->add($catData);
    $catList->saveToFile();
} else if($_SERVER['REQUEST_METHOD']=="PUT"){
    $catData=json_decode(file_get_contents('php://input'), TRUE);
    $catList->update($catData);
    $catList->saveToFile();
} else if($_SERVER['REQUEST_METHOD']=="DELETE"){
    $catData=json_decode(file_get_contents('php://input'), TRUE);
    $catList->delete($catData['id']);
    $catList->saveToFile();
}
echo $catList->exportAsJSON();