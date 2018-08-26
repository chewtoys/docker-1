<?php

function getHeadlineAndImage($index, $csv) {
	if( !file_exists('cache/csv.cache') || (date('U') - date('U', filemtime('cache/csv.cache'))) / 60 > 10 ){
		cacheData($csv);
	}
	$arrData = getCachedData($csv);
	foreach ($arrData as $entry) {
		$line = explode(';', $entry);
		if (strlen($line[0]) > 3) {
			$line[0] = substr($line[0], 3);
		}
		if (strcmp($line[0], $index) == 0) {
			return $line;
		}
	}
	return array('', '', '', '');
}

function getOtherArticles($index, $csv) {
	if( !file_exists('cache/csv.cache') || (date('U') - date('U', filemtime('cache/csv.cache'))) / 60 > 10 ){
		cacheData($csv);
	}
	$arrData = getCachedData($csv);
	$retArray = array();
	foreach($arrData as $entry) {
		$line = explode(';', $entry);		
		//Skip header line and same mod parameter
		if (!strcmp($line[0], $index) == 0 && !strcmp($line[0], "mod Parameter") == 0 && !empty($line[1])) {
			//check if values exist
			if(isset($line[3]) && isset($line[4])) {
				array_push($retArray, $line);
			}
			else {
				array_push($retArray, array($line[0], '', '', 'Alter ist Trumpf: Singles über 50 sind klar im Vorteil!', 'img/other_article.jpg'));
			}
		}
	}
	return $retArray;
}

function getCSV($csv) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $csv);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$fp = curl_exec($ch);
	curl_close($ch);
	//convert to UTF-8
	$fp = iconv("Windows-1252","UTF-8",$fp);
	$line = preg_split("/\n/", $fp);
	return $line;
}

function cacheData($csv) {
	$csv = getCSV($csv);
	if( !file_exists('cache') ){
		mkdir("cache", 0777);
	}
	return file_put_contents('cache/csv.cache', serialize($csv));
}

function getCachedData($csv) {
	if(!file_exists('cache/csv.cache')){
		$result = getCSV($csv);
	}else{
		$result = unserialize(file_get_contents('cache/csv.cache'));
	}
	return $result;
}

function url_exists($url) {
	$exists = true;
	$file_headers = @get_headers($url);
	$InvalidHeaders = array('404', '403', '500');
	foreach($InvalidHeaders as $HeaderVal){
		if(strstr($file_headers[0], $HeaderVal)){
			$exists = false;
			break;
		}
	}
	return $exists;
}

?>