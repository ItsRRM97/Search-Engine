<?php

$pdo = new PDO('mysql:host=127.0.0.1;dbname=Search','root','');

$search = $_GET['q'];
echo "<pre>";

$results = $pdo->query("SELECT * FROM `index`");
print_r($results->fetchAll());
