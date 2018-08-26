<?php

if (!class_exists('AffinitasTrackingSDK')) {
	include('AffinitasTrackingSDK.php');
}
$atrk = new AffinitasTrackingSDK();
$cidServicePixelUrl = $atrk->cid();

include('DeviceDetection.class.php');

$gender = (isset($_REQUEST['gender']) && in_array($_REQUEST['gender'], array('MALE', 'FEMALE', 'm', 'f'))) ? $_REQUEST['gender'] : '';
$searchedGender = (isset($_REQUEST['searchedGender']) && in_array($_REQUEST['searchedGender'], array('MALE', 'FEMALE', 'm', 'f'))) ? $_REQUEST['searchedGender'] : '';
$email = isset($_REQUEST['email']) ? htmlspecialchars($_REQUEST['email']) : '';
$voucher = isset($_REQUEST['v']) ? htmlspecialchars($_REQUEST['v']) : (isset($_REQUEST['voucher']) ? htmlspecialchars($_REQUEST['voucher']) : '');
$legal = isset($_REQUEST['legal']) ? htmlspecialchars($_REQUEST['legal']) : '';

$ed_cid = isset($_REQUEST['ed_cid']) ? htmlspecialchars($_REQUEST['ed_cid']) : (isset($_REQUEST['cid']) ? htmlspecialchars($_REQUEST['cid']) : (isset($_REQUEST['CID']) ? htmlspecialchars($_REQUEST['CID']) : ''));
$atpr = !empty($ed_cid) ? true : false;

$ga = "<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function()
{ (i[r].q=i[r].q||[]).push(arguments)}
,i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-101771355-1', 'auto',
{'allowLinker': true}
);
ga('require', 'linker');
ga('linker:autoLink', ['www.attractiveworld.com'] );
ga('set', 'anonymizeIp', true);
ga('send', 'pageview');</script>";

$pagenum = isset($_REQUEST['pageNumber']) ? htmlspecialchars($_REQUEST['pageNumber']) : '';
$backLink = !empty($pagenum) ? '../'.$pagenum .'/' : '';

$_ref = isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER['HTTP_REFERER']) : '';

if (!empty($voucher) && !empty($backLink)) {
	$backLink .= '?v='.$voucher;
}

$useMbox = !isset($_GET['sel']);

$country 			= 'en-nz';
$path 				= 'https://www.attractiveworld.com/';
$action 			= $path.'signup/create';
$mobilePath			= 'https://im.attractiveworld.com/';
$mobileAction		= $action;
$tabletAction		= $action;
$loginLink 			= $path.$country;

$normalize			= '<link media="all" type="text/css" rel="stylesheet" href="//static.edarling.net/global/css/normalize.css" />';
$errorcss			= '<link media="all" type="text/css" rel="stylesheet" href="../../inc/css/error.css" />';
$mbox 				= '<script src="https://static.edarling.net/global/js/mbox.js"></script>';

$meta 				= '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Attractive World</title>
	<meta name="description" content="Attractive World is a NZ dating site for dynamic singles. Selective entry means our community is home to active, interesting Kiwis: join them here!"/>
	<meta name="robots" content="noindex, nofollow, noodp" />
	<link rel="canonical" href="https://www.attractiveworld.com/en-nz/" />';

$favicon			= '<link rel="shortcut icon" href="../../inc/img/favicon.ico" type="image/x-icon" />';

$formHidden = '<input type="hidden" name="subscribers[locale]" value="en_NZ">
							<input type="hidden" name="subscribers[code_campaign]" value="'.$ed_cid.'">
							<input type="hidden" name="subscribers[user_device]" value="'.DeviceDetection::getDevice().'">
							<input type="hidden" name="subscribers[page_url]" value="">
							<input type="hidden" name="subscribers[sponsoring_code]" value="">
							<input type="hidden" name="form_type" value="SubscribersMobileStep0ShortForm">';

$footerPixel = '<img width="1" height="1" border="0" src="https://www.attractiveworld.com/signup/clearsession" style="display:none;"/>';

include('messages.php');

$cookiebarCss = '<link media="all" type="text/css" rel="stylesheet" href="../../inc/css/cookiebar.css" />';
$cookiebar = '<script>
    window.cookieconsent_options = {
        message: "'.$cookie_message.'",
        dismiss: "'.$cookie_option_1.'",
        learnMore: "'.$cookie_option_2.'",
        link: "'.$path.$country.'/cookies",
        theme: false,
        domain: window.location.host.split('.').reverse().slice(0, 2).reverse().join('.')
    };
		</script>
		<script async src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>';

?>
