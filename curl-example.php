<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://localhost/lab4/api/categories-json.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$outCategory = curl_exec($ch);

curl_close($ch); 

$data = json_decode($outCategory, true);

echo '<b>Приклади:</b><br>';
$data = json_decode($outCategory, true);
foreach ($data as $item) {
    echo '<b>'.$item['id'].'</b>. '.$item['name'].'</br>';
}

?>

