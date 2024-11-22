<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
};
require_once('../dbconnect.php');
require_once('../models/OperatorList.php');
$opList = new OperatorList();
if (isset($_GET['action']) && $_GET['action'] == 'delete'){
    $opList->deleteFromDatabaseByID($conn, $_GET['id']);
    header('Location: ./operator-list.php');
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
        <h1>Список операторів</h1>
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
        <form action="./operator-list.php" method="GET">
            <div class="mb-3">
            <input type="search" name="query" placeholder="Задайте слово" required/>
            <button type="submit" class="btn btn-primary">Пошук</button>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Назва</th>
                    <th>Опис</th>
                    <th>Категорія</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($_SERVER['REQUEST_METHOD']=="GET" && isset($_GET['query'])) {
                        $opList->getBySearchQuery($conn, $_GET['query']);
                    } else {
                        $opList->getFromDatabase($conn);
                    }
                    echo $opList->exportAsTableData(); 
                ?>
            </tbody>
        </table>
        <a class="btn btn-outline-danger" href="logout.php">Вийти</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>