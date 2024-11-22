<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('./CategoryList.php');
require_once('./ExamplesList.php');
require_once('./OperatorsList.php');
// $row=0;





// Додаємо елементи з файлу в змінну для прикладів
/*$exList=new ExamplesList();
if (($handle = fopen("./data/examples.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if($row>0){
            $exList->add(array('example_text'=>$data[0]));
        }
        $row++;
    }
    fclose($handle);
    $exList->display();
}*/
// Записуємо данні з елементу в файл
/*$data = array('id'=>2,'example_text'=>'виводить шось на екран <3');
$exList->update($data);
$fp = fopen('./data/examples.csv', 'w');
foreach ($exList->exportAsArray() as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);*/



// Додаємо елементи з файлу в змінну для категорій
/*$catList=new CategoryList();
if (($handle = fopen("./data/category.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if($row>0){
            $catList->add(array('name'=>$data[0]));
        }
        $row++;
    }
    fclose($handle);
    $catList->display();
}*/
// Записуємо данні з елементу в файл
/*$data = array('id'=>2,'name'=>'Input');
$catList->update($data);
$fp = fopen('./data/category.csv', 'w');
foreach ($catList->exportAsArray() as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);*/









// Додаємо елементи з файлу в змінну для операторів
/*$opList=new OperatorsList();
if (($handle = fopen("./data/operators.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if($row>0){
            $opList->add(array('operator_name'=>$data[0],'description'=>$data[1],'category'=>$data[2],'example'=>$data[3]));
        }
        $row++;
    }
    fclose($handle);
    $opList->display();
}*/
// Записуємо данні з елементу в файл
/*$data = array('id'=>1,'operator_name'=>'print', 'description'=>'виводить щось на екран', 'category'=>'Output', 'example'=>'print "Hello Wolrd!"');
$opList->update($data);
$fp = fopen('./data/operators.csv', 'w');
foreach ($opList->exportAsArray() as $fields) {
    fputcsv($fp, $fields);
}
fclose($fp);*/




// Перевірка чи працює
$data = array('id'=>1,'operator_name'=>'print', 'description'=>'виводить щось на екран', 'category'=>'Output', 'example'=>'print "Hello Wolrd!"');
$data1 = array('id'=>2,'operator_name'=>'let', 'description'=>'присвоює дані змінній', 'category'=>'Присвоєння', 'example'=>'let x = 1');
$data2 = array('id'=>2,'operator_name'=>'Let', 'description'=>'присвоює дані змінній', 'category'=>'Присвоєння', 'example'=>'let y = -5');
$Oplist = new OperatorsList();
$Oplist->add($data);
$Oplist->add($data1);
$Oplist->display();
$Oplist->update($data2);
$Oplist->delete(1);
$Oplist->display();
?>