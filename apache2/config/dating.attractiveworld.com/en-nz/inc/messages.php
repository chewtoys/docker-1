<?php
//-----Allgemeine Texte-----//

$footer = '<footer class="footerNavi">
						<ul>
							<img src="'. htmlspecialchars($cidServicePixelUrl) .'" width="1" height="1" alt="" style="position: absolute; visibility: hidden;"/>
							<li><a href="'.$path.$country.'/aw/terms">terms</a></li>
							<li><a href="'.$path.$country.'/aw/imprint">imprint</a></li>
							<li><a href="'.$path.$country.'/aw/privacy">privacy</a></li>
						</ul>
					</footer>';

$mobile_footer = '<footer class="footerNavi">
						<ul>
							<img src="'. htmlspecialchars($cidServicePixelUrl) .'" width="1" height="1" alt="" style="position: absolute; visibility: hidden;"/>
							<li><a href="'.$path.$country.'/aw/terms">terms</a></li>
							<li><a href="'.$path.$country.'/aw/imprint">imprint</a></li>
							<li><a href="'.$path.$country.'/aw/privacy">privacy</a></li>
						</ul>
					</footer>';


//Placeholder
$email_placeholder = 'Your E-mail Address';
$email_placeholder_2 = 'Your Email-adress';
$text_gender_placeholder = 'Gender';
$text_birthday_placeholder = 'Day';
$text_birthmonth_placeholder = 'Month';
$text_birthyear_placeholder = 'Year';

//Form Inputs
$text_i_am = 'I am:';
$text_gender_f = 'a woman';
$text_gender_m = 'a man';
$text_birthday = 'Birthday:';
$text_email = 'E-Mail:';
$text_email_2 = 'Email:';
$text_legal = 'I accept the <a href="'.$path.$country.'/aw/terms">Terms and Conditions</a> &amp; <a href="'.$path.$country.'/aw/privacy">Privacy Policy</a>';
$text_submit = 'Apply today';
$text_member = 'Already a member?';
$text_login = "Log In";

//Cookies
$cookie_message = 'This website uses cookies to ensure you get the best experience on our website';
$cookie_option_1 = 'Got it!';
$cookie_option_2 = 'Would you like to know more?';

//Error Messages
$general_error = 'Please fill in all fields';
$email_error = 'This e-mail address is invalid';
$gender_error = 'Please select your gender';
$legal_error = 'Please accept our Terms and Conditions to validate your registration';
$birthday_error = 'You did not enter your date of birth';
$age_error = 'Attractive World is for adults only';

//mbox
// $create_mbox = "<div id="dynamicElement"></div><script type="text/javascript">mboxDefine("dynamicElement","aw_gender");</script>";

//Birthday Options
function generateOptions($min,$max){
	$value = '';
	foreach (range($min,$max) as $x) {
		$value .= '<option value="'.$x.'">'.$x.'</option>';
	}
	return $value;
}
$options_birthday = generateOptions(1,31);
$options_birthmonth = generateOptions(1,12);
$options_birthyear = generateOptions(date('Y')-18,1917);
?>
