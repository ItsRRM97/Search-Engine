<?php

$start = "http://localhost/Search-Engine/test.html"; 
//contains various types of links our webcrawler will encounter

$already_crawled = array(); //array

function get_details($url) {

}

//crawler function
function follow_links($url)  {

	global $already_crawled;

	$options = array('http'=>array('method'=>"GET", 'headers'=>"User-Agent: Bot/0.1\n")); //creates custom headers

	$context = stream_context_create($options);
	
	$doc = new DOMDocument();
	$doc->loadHTML(file_get_contents($url, false, $context));

	$linklist = $doc->getElementsByTagName("a");

	foreach ($linklist as $link) {
		$l = $link->getAttribute("href");

		if(substr($l, 0, 1) == "/" && substr($l, 0, 2) != "//") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"].$l; 
		}
		else if(substr($l, 0, 2) == "//") {
			$l = parse_url($url)["scheme"].":".$l; 
		}
		else if(substr($l, 0, 2) == "./") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"].dirname(parse_url($url)["path"]).substr($l, 1); 
		} 
		else if (substr($l, 0, 1) == "#") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"].parse_url($url)["path"].$l;
		}
		else if (substr($l, 0, 3) == "../") {
			$l = parse_url($url)["scheme"]."://".parse_url($url)["host"]."/".$l;
		}
		else if (substr($l, 0, 11) == "javascript:") {
			continue;
		}
		else if (substr($l, 0, 5) != "https" && substr($l, 0, 4) != "http") {
			 $l = parse_url($url)["scheme"]."://".parse_url($url)["host"]."/".$l;
		}

		if(!in_array($l, $already_crawled)) {
			$already_crawled[] = $l;
			//echo get_details($l); 
			echo $l."<br>";

		}

	}

}

follow_links($start);

print_r($already_crawled);