<?php

$pdo = new PDO('mysql:host=127.0.0.1;dbname=Search','root','');

$search = $_GET['q'];
$searche = explode(" ", $search);

$x = 0;
$construct = "";
$params = array();
foreach ($searche as $term) {
	$x++;
	if ($x == 1) {

		$construct .= "title LIKE CONCAT('%',:search$x,'%') OR description LIKE CONCAT('%',:search$x,'%') OR keywords LIKE CONCAT('%',:search$x,'%')";

	} else {

		$construct .= " AND title LIKE CONCAT('%',:search$x,'%') OR description LIKE CONCAT('%',:search$x,'%') OR keywords LIKE CONCAT('%',:search$x,'%')";

	}
	$params[":search$x"] = $term;
}

$results = $pdo->prepare("SELECT * FROM `index` WHERE $construct");
$results->execute($params);

if ($results->rowCount() == 0) {
	echo "No Results found! <hr>";
} else {
	echo $results->rowCount()." results found! <hr>";
}

foreach ($results->fetchAll() as $result) {
	echo $result["title"]."<br>";
	if ($result["description"] == "") {
		echo "No Description Available"."<br>";
	} else {
	echo $result["description"]."<br>";
		}
	echo $result["url"]."<br>";
	echo "<hr>";

}
