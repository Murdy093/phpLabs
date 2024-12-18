<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
};
require_once('../dbconnect.php');
require_once('../models/ExampleList.php');
require_once('../models/OperatorList.php');
$exampleList = new ExampleList();
$exampleList->getFromDatabase($conn);
$opList = new OperatorList();
$opList->getFromDatabase($conn);
$idContent = '';
$codeContent = '';
$commContent = null;
if (isset($_GET['id'])) {
    $temp = $exampleList->getItemById($_GET['id']);
    $idContent = $temp['id'];
    $codeContent = $temp['example_text'];
    $commContent = $temp['operator'];
}
if (isset($_POST['example_text'])) {
    $dataTrueCatch = false;
    if ($_POST['id'] == '') {
        $dataTrueCatch = $exampleList->addToDatabase($conn, array('example_text'=>$_POST['example_text'], 
                        'operator_id'=>$_POST['operator_id']));
    } else {
        $dataTrueCatch = $exampleList->updateDatabaseRow($conn, array('id'=>$_POST['id'], 
                        'example_text'=>$_POST['example_text'],
                        'operator_id'=>$_POST['operator_id']));
    }
    if ($dataTrueCatch) {
        header('Location: ./example-list.php');
    } else {
        echo '<script>alert("Приклад з такими даними вже існує! Змініть дані")</script>';
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
        <h1>Додати приклад</h1>
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
                <p><input class="form-input" value="<?php echo $codeContent;?>" name="example_text" type="text" placeholder="Вміст прикладу" required/></p>
                <p>Виберіть оператор: <select name="operator_id" required>
                    <?php echo $opList->exportAsDropdownItems($commContent); ?>
                </select></p>
                <p><button class="btn btn-outline-success" type="submit">Додати</button></p>
            </form>
        </div>
        <a class="btn btn-outline-danger" href="logout.php">Вийти</a>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>