<?php

class Log404{
	public static function logCall($country){
		$ip = self::getRealIP();
		$useragent = (isset($_SERVER['HTTP_USER_AGENT'])) ? htmlspecialchars($_SERVER['HTTP_USER_AGENT']) : '';
		$page = (isset($_SERVER['HTTP_REFERER'])) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '';
		$current = (isset($_SERVER['REQUEST_URI'])) ? htmlspecialchars($_SERVER['REQUEST_URI']) : '';
		$ref = (isset($_GET['ref'])) ? htmlspecialchars($_GET['ref']) : 'noHTACCESS';
		$date = date('Y-m-d H:i:s');

		// TrakkMonitor ausschließen
		// Direktaufrufe ausschließen
		if (strpos($useragent, 'PhantomJS') === false && $page !== '' && !strpos($page, $current)) {
			try{
				if ($_SERVER['SERVER_NAME'] === 'localhost'){
					$mysqli = new mysqli('localhost', 'trakken', 'eDa2010Trakk', 'lpdb');
				}else{
					$mysqli = new mysqli('partner-db', 'trakken', 'eDa2010Trakk', 'lpdb');
				}		
				if ($mysqli->connect_errno && $_SERVER['SERVER_NAME'] === 'localhost') {
					echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}

				$stmt = $mysqli->prepare("INSERT INTO error_tracker (country, createdate, ipaddress, referer, comes_from) VALUES (?, ?, ?, ?, ?)");
				$stmt->bind_param("sssss", $country, $date, $ip, $page, $ref);
				$res = $stmt->execute();

				$stmt->close();
				$mysqli->close();

			} catch (Exception $e){
				// DB nicht ansprechbar
			}
		}
	}
	private static function getRealIP(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}	

?>