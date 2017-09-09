<?php

$start = "http://localhost/Search-Engine/test.html"; 
//contains various types of links our webcrawler will encounter

//crawler function
function follow_links($url)  {
	
	$doc = new DOMDocument();
	$doc->loadHTML(file_get_contents($url));

	$linklist = $doc->getElementsByTagName("a");

	foreach ($linklist as $link) {
		echo $link->getAttribute("href")."<br>";
	}

}

follow_links($start);