<?php
require_once('../models/OperatorList.php');
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user'])) {
    echo json_encode(array("login" => false));
    die();
}
$opList = new OperatorList();
if ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['query'])) {
    $opList->getBySearchQuery($conn, $_GET['query']);
} else {
    $opList->getFromDatabase($conn);
}
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $opData = json_decode(file_get_contents('php://input'), true);
    $opList->addToDatabase($conn, $opData);
} else if ($_SERVER['REQUEST_METHOD']=="PUT") {
    $opData = json_decode(file_get_contents('php://input'), true);
    $opList->updateDatabaseRow($conn, $opData);
} else if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    $opData = json_decode(file_get_contents('php://input'), true);
    $opList->deleteFromDatabaseByID($conn, $opData['id']);
};
echo json_encode($opList->exportAsJSON(), JSON_UNESCAPED_UNICODE);