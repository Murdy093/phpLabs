<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
};
require_once('../dbconnect.php');
require_once('../models/ExampleList.php');
$exampleList = new ExampleList();
//$exampleList->getFromDatabase($conn);
if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    $exampleList->deleteFromDatabaseByID($conn, $_GET['id']);
    header('Location: ./example-list.php');
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../assets/style.css" rel="stylesheet"/>
    <title>Basic</title>
</head>
<body>
    <div class="container">
        <h2>Система керування контентом</h2>
        <h1>Список прикладів використання</h1>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="operator-list.php">Список операторів</a></li>
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="category-list.php">Список категорій</a></li>
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="example-list.php">Список прикладів</a></li>
        </nav>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="add-operator.php">Додати оператор</a></li>
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="add-category.php">Додати категорію</a></li>
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="add-example.php">Додати приклад</a></li>
        </nav>
        <form action="./example-list.php" method="GET">
            <div class="mb-3">
            <input type="search" name="query" placeholder="Задайте слово" required/>
            <button type="submit" class="btn btn-primary">Пошук</button>
            </div>
            
            <a class="btn btn-success nav-item" style="width:50px; margin-left:10px;" href="example-list.php?sort=2">↓</a>
            <a class="btn btn-success nav-item" style="width:50px; margin-left:510px;" href="example-list.php?sort=3">↓</a>
            
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Приклад</th>
                    <th>Оператор</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sortField = isset($_GET['sort']) ? (int)$_GET['sort'] : 2;
                    if ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['query'])) {
                        $exampleList->getBySearchQuery($conn, $_GET['query']);
                    } else {
                        $exampleList->sortData($conn, $sortField);
                    }
                    echo $exampleList->exportAsTableData(); 
                ?>
            </tbody>
        </table>
        <a class="btn btn-outline-danger" href="logout.php">Вийти</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>