<?php /* TITLE: Kachel - Updated*/?>
<?php
	include('../../inc/header.inc.php');
 ?>
<!doctype html>
<html>
<head>
	<?php
		echo $meta;
		echo $favicon;
	 ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<?php echo $errorcss; ?>
	<link media="all" type="text/css" rel="stylesheet" href="css/style.css" />
	<?php echo $ga; ?>
	<?php echo $atrk->pixel(AffinitasTrackingSDK::SITE_ONEPAGE, AffinitasTrackingSDK::POSITION_HEAD); ?>
</head>
<body>
	<?php echo $atrk->pixel(AffinitasTrackingSDK::SITE_ONEPAGE, AffinitasTrackingSDK::POSITION_TOP_OF_BODY); ?>
	<header class="header">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-5">
					<a href="" class="logo"></a>
				</div>
				<div class="col-sm-7 hidden-xs login-link">
					<p><?php echo $text_member; ?></p>
					<a href="<?php echo $loginLink; ?>" class="member-login-btn"><?php echo $text_login; ?></a>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="row">
			<div class="formular col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<div class="row form-header">
					<div class="col-xs-12">
						<h3>What are you waiting for?</h3>
						<p>The only dating site where you decide who gets in.</p>
					</div>
				</div>
				<form id="form_register" method="post" action="<?php echo $action; ?>" name="form_register" novalidate>
					<?php echo $formHidden; ?>
					<div class="row gender-row">
						<div class="col-xs-12 col-sm-2 col-sm-offset-2">
							<legend><?php echo $text_i_am; ?></legend>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="row">
								<div class="col-xs-6">
									<label for="gender_is_f">
										<input type="radio" value="1" id="gender_is_f" name="subscribers[search]" data-validate="true" <?php echo ($gender === 'f')?'checked="checked"':''; ?> />
										<div><?php echo $text_gender_f; ?></div>
									</label>
								</div>
								<div class="col-xs-6">
									<label for="gender_is_m">
										<input type="radio" value="0" id="gender_is_m" name="subscribers[search]" data-validate="true" <?php echo ($gender === 'm')?'checked="checked"':''; ?> />
										<div><?php echo $text_gender_m; ?></div>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 ed-error gender-error"><?php echo $gender_error; ?></div>
					</div>
					<div class="row birthday-row">
						<div class="col-xs-12 col-sm-2 col-sm-offset-2">
							<label for=""><?php echo $text_birthday; ?></label>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="row">
								<div class="col-xs-4">
									<select name="subscribers[birthday][day]" class="birthday-option birthday-day" id="day_select">
										<option value="null" id="day_first" selected disabled><?php echo $text_birthday_placeholder; ?></option>
										<?php
											echo $options_birthday;
										 ?>
									</select>
								</div>
								<div class="col-xs-4">
									<select name="subscribers[birthday][month]" class="birthday-option birthday-month" id="month_select">
										<option value="null" selected disabled><?php echo $text_birthmonth_placeholder; ?></option>
										<?php
											echo $options_birthmonth;
										 ?>
									</select>
								</div>
								<div class="col-xs-4">
									<select name="subscribers[birthday][year]" class="birthday-option birthday-year" id="year_select">
										<option value="null" selected disabled><?php echo $text_birthyear_placeholder; ?></option>
										<?php
											echo $options_birthyear;
										 ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 ed-error birthday-error"><?php echo $birthday_error; ?></div>
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 ed-error age-error"><?php echo $age_error; ?></div>
					</div>
					<div class="row email-row">
						<div class="col-xs-12 col-sm-2 col-sm-offset-2">
							<label for="emailaddy"><?php echo $text_email_2; ?></label>
						</div>
						<div class="col-xs-12 col-sm-6">
							<input type="email" name="subscribers[email]" placeholder="<?php echo $email_placeholder_2; ?>" class="" id="emailaddy" value="<?php echo $email; ?>" />
						</div>
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 ed-error email-error"><?php echo $email_error; ?></div>
					</div>
					<div class="row terms-row">
						<div class="col-xs-12 col-sm-8 col-sm-offset-2">
							<input type="checkbox" name="subscribers[optin]" id="terms" />
							<label for="terms"><?php echo $text_legal; ?></label>
						</div>
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 ed-error legal-error"><?php echo $legal_error; ?></div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-sm-offset-3">
							<button id="btn_submit" type="submit" class="registerButton" value=""><?php echo $text_submit; ?></button>
						</div>
					</div>
				</form>

				<div class="row visible-xs">
					<div class="col-xs-12 login-link">
						<p><?php echo $text_member; ?></p>
						<a href="<?php echo $loginLink; ?>" class="member-login-btn"><?php echo $text_login; ?></a>
					</div>
				</div>

				<div class="visible-xs footer">
					<?php echo $mobile_footer; ?>
				</div>
			</div>
		</div>
	</div>

	<footer class="footer">
		<div class="visible-sm visible-md visible-lg main-footer footer">
			<?php echo $footer; ?>
		</div>
	</footer>

	<?php echo $footerPixel; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<?php echo $atrk->pixel(AffinitasTrackingSDK::SITE_ONEPAGE, AffinitasTrackingSDK::POSITION_BOTTOM_OF_BODY); ?>
</body>
</html>
