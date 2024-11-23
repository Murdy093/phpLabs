<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
};
require_once('../dbconnect.php');
require_once('../models/CategoryList.php');
$catList = new CategoryList();
$catList->getFromDatabase($conn);
$idContent = '';
$nameContent = '';
if (isset($_GET['id'])) {
    $temp = $catList->getItemById($_GET['id']);
    $idContent = $temp['id'];
    $nameContent = $temp['name'];
}
if (isset($_POST['name'])) {
    $dataTrueCatch = false;
    if ($_POST['id'] == '') {
        $dataTrueCatch = $catList->addToDatabase($conn, array('name'=>$_POST['name']));
    } else {
        $dataTrueCatch = $catList->updateDatabaseRow($conn, array('id'=>$_POST['id'], 'name'=>$_POST['name']));
    }
    if ($dataTrueCatch) {
        header('Location: ./category-list.php');
    } else {
        echo '<script>alert("Категорія з такими даними вже існує! Змініть дані")</script>';
    }
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
        <h1>Додати категорію</h1>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-outline-dark nav-item" href="operator-list.php">Список операторів</a></li>
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="category-list.php">Список категорій</a></li>
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="example-list.php">Список прикладів</a></li>
        </nav>
        <nav class="navbar-nav d-flex flex-row">
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="add-operator.php">Додати оператор</a></li>
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="add-category.php">Додати категорію</a></li>
            <li class="nav-item"><a class="btn btn-secondary nav-item" href="add-example.php">Додати приклад</a></li>
        </nav>
        <div class="mt-4">
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $idContent;?>"/>
                <p><input class="form-input" value="<?php echo $nameContent;?>" name="name" type="text" placeholder="Назва категорії" required/></p>
                <p><button class="btn btn-outline-success" type="submit">Додати</button></p>
            </form>
        </div>
        <a class="btn btn-outline-danger" href="logout.php">Вийти</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>