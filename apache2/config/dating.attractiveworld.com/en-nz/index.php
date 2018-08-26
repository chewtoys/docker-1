<?php /*TITLE: Redirect to Runway*/ ?>
<?php
	$domain = 'https://www.attractiveworld.com/en-nz/';

	if ($_SERVER['SERVER_NAME'] === 'localhost'){
		echo '<pre>';print_r('Redirect to '.$domain);echo '</pre>';
		die();
	}

	if (!empty($_SERVER['QUERY_STRING'])) {
		header('location:'.$domain.'?'.utf8_decode($_SERVER['QUERY_STRING']));
	} else {
		header('location:'.$domain);
	}
?>