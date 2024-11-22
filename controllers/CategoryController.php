<?php
require_once('../models/CategoryList.php');
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$catList = new CategoryList();
if ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['query'])) {
    $catList->getBySearchQuery($conn, $_GET['query']);
} else {
    $catList->getFromDatabase($conn);
}
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $catData = json_decode(file_get_contents('php://input'), true);
    $catList->addToDatabase($conn, $catData);
} else if ($_SERVER['REQUEST_METHOD']=="PUT") {
    $catData = json_decode(file_get_contents('php://input'), true);
    $catList->updateDatabaseRow($conn, $catData);
} else if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    $catData = json_decode(file_get_contents('php://input'), true);
    $catList->deleteFromDatabaseByID($conn, $catData['id']);
};
echo json_encode($catList->exportAsJSON(), JSON_UNESCAPED_UNICODE);