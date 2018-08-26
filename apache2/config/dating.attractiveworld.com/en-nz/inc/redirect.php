<?php
	include_once('../inc/redirect.conf.php');

	$location = '';
	$entrypoint = explode("/", $_SERVER['PHP_SELF']);
  $urlSegment = ($_SERVER['SERVER_NAME'] === 'localhost') ? 5 : 2;
	$ep = str_split($entrypoint[$urlSegment], 4);

	switch( $ep[0] ){
    case 'br5a':
      $location = $domain.$redirect['desktop']['br'];
      break;

    case 'ge7n':
      $location = $domain.$redirect['desktop']['gen'];
      break;

    case 'di2s':
      $location = $domain.$redirect['desktop']['dis'];
      break;

    case 'cop2':
      $location = $domain.$redirect['desktop']['cop'];
      break;

    case 'af1f':
      $location = $domain.$redirect['desktop']['aff'];
      break;

    case 'af2f':
      $location = $domain.$redirect['desktop']['aff2'];
      break;

    case 'fb6m':
      $location = $domain.$redirect['desktop']['fbm'];
      break;

    case 'fb6f':
      $location = $domain.$redirect['desktop']['fbf'];
      break;

    case 'co8n':
      $location = $domain.$redirect['desktop']['con'];
      break;

    case 'mbco':
      $location = $domain.$redirect['mobile']['cop'];
      break;

    case 'mbaf':
      $location = $domain.$redirect['mobile']['aff'];
      break;

    case 'mbdi':
      $location = $domain.$redirect['mobile']['dis'];
      break;

    case 'mbse':
      $location = $domain.$redirect['mobile']['sem'];
      break;

    case 'tbaf':
      $location = $domain.$redirect['tablet']['aff'];
      break;

    case 'tbdi':
      $location = $domain.$redirect['tablet']['dis'];
      break;

    case 'tbse':
      $location = $domain.$redirect['tablet']['sem'];
      break;

    default:
    	// echo $ep[0];
	}

	header("HTTP/1.1 301 Moved Permanently");
  if (!empty($_SERVER['QUERY_STRING'])) {
    header('Location: '.$location.'&'.$_SERVER['QUERY_STRING']);
    exit();
  } else {
    header('Location: '.$location);
    exit();
  }

?>