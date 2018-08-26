<?php /* TITLE: Content Page */?>
<?php
include('../../inc/header.inc.php');

$csv = 'http://media.edarling.de/creatives/attractiveworld/NZ/Content/lpdef.csv';
include('./cache.php');
$mod = '1';
if (isset($_GET['mod']) && !empty($_GET['mod'])){
	$mod = htmlspecialchars($_GET['mod']);
}
$headImg = getHeadlineAndImage($mod, $csv);
$headline = (!empty($headImg[1])) ? $headImg[1] : '';
$dynamicText = (!empty($headImg[2])) ? $headImg[2] : '';

$other_articles = getOtherArticles($mod, $csv);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<?php
	echo $meta;
	echo $favicon;
	echo $normalize;
	?>

	<?php echo $errorcss; ?>
	<?php echo $cookiebarCss; ?>
	<link media="all" type="text/css" rel="stylesheet" href="css/style.css" />
	<?php echo $ga; ?>
	<?php echo $atrk->pixel(AffinitasTrackingSDK::SITE_ONEPAGE, AffinitasTrackingSDK::POSITION_HEAD); ?>
</head>
<body>
	<?php echo $atrk->pixel(AffinitasTrackingSDK::SITE_ONEPAGE, AffinitasTrackingSDK::POSITION_TOP_OF_BODY); ?>
	<header class="header">
		<div class="container">
			<a class="logo"></a>
			<div class="login">
				<span><?php echo $text_member; ?></span>
				<a href="<?php echo $loginLink; ?>" class="login-btn"><?php echo $text_login; ?></a>
			</div>
		</div>
	</header>

	<main class="main">
		<div class="container">
			<div class="row">
				<article class="article">
					<div class="content">
						<h1><?php echo $headline; ?></h1>
						<?php echo $dynamicText; ?>
					</div>
					<div class="cta-wrapper">
						<a href="<?php echo $loginLink; ?>" class="cta"><?php echo $text_submit; ?></a>
					</div>
					<div class="usp">
						<ul>
							<li class="usp-1">100% manually<br/>verified profiles</li>
							<li class="usp-2">100% profiles<br/>with pictures</li>
							<li class="usp-3">NZ's first exclusive<br/>dating platform</li>
							<li class="usp-4">53% Females<br/>47% Males</li>
						</ul>
					</div>
				</article>
				<aside class="sidebar">
					<div class="form">
						<form action="<?php echo $action; ?>" method="post" name="signup_form" id="signup-form">
							<input type="hidden" name="subscribers[locale]" value="fr-be">
							<input type="hidden" name="subscribers[code_campaign]" value="">
							<input type="hidden" name="subscribers[user_device]" value="">
							<input type="hidden" name="subscribers[page_url]" value="">
							<input type="hidden" name="subscribers[sponsoring_code]" value="">
							<div class="row">
								<div class="col-left">
									<label for="gender"><?php echo $text_i_am; ?></label>
								</div>
								<div class="col-right">
									<div class="row">
										<div class="col-66">
											<select name="subscribers[search]" id="gender">
												<option value="null" disabled="disabled" <?php echo ($gender === '')?'selected="selected"':''; ?>><?php echo $text_gender_placeholder; ?></option>
												<option value="0" <?php echo ($gender === 'm')?'selected="selected"':''; ?>><?php echo $text_gender_m; ?></option>
												<option value="1" <?php echo ($gender === 'f')?'selected="selected"':''; ?>><?php echo $text_gender_f; ?></option>
											</select>
										</div>
									</div>
								</div>
								<div class="ed-error gender-error"><?php echo $gender_error; ?></div>
							</div>
							<div class="row">
								<div class="col-left">
									<label for="birthday"><?php echo $text_birthday; ?></label>
								</div>
								<div class="col-right">
									<div class="row">
										<div class="col-33">
											<select name="subscribers[birthday][day]" id="birthday">
												<option value="null" disabled="disabled" selected="selected"><?php echo $text_birthday_placeholder; ?></option>
												<?php echo $options_birthday; ?>
											</select>
										</div>
										<div class="col-33">
											<select name="subscribers[birthday][month]" id="birthmonth">
												<option value="null" disabled="disabled" selected="selected"><?php echo $text_birthmonth_placeholder; ?></option>
												<?php echo $options_birthmonth; ?>
											</select>
										</div>
										<div class="col-33">
											<select name="subscribers[birthday][year]" id="birthyear">
												<option value="null" disabled="disabled" selected="selected"><?php echo $text_birthyear_placeholder; ?></option>
												<?php echo $options_birthyear; ?>
											</select>
										</div>
									</div>
								</div>
								<div class="ed-error birthday-error"><?php echo $birthday_error; ?></div>
								<div class="ed-error age-error"><?php echo $age_error; ?></div>
							</div>
							<div class="row">
								<div class="col-left">
									<label for="email"><?php echo $text_email; ?></label>
								</div>
								<div class="col-right">
									<input type="email" name="subscribers[email]" id="email" value="<?php echo $email; ?>" placeholder="<?php echo $email_placeholder; ?>" />
								</div>
								<div class="ed-error email-error"><?php echo $email_error; ?></div>
							</div>
							<div class="row">
								<div class="col-checkbox">
									<div>
										<input type="checkbox" name="subscribers[optin]" id="terms">
										<label for="terms"><?php echo $text_legal; ?></label>
									</div>
								</div>
								<div class="ed-error legal-error"><?php echo $legal_error; ?></div>
							</div>
							<div class="row">
								<button type="submit" class="cta"><?php echo $text_submit; ?></button>
							</div>
						</form>
					</div>

					<div class="other-article">
					<?php
						if (count($other_articles) > 0) {
							echo '<h2>You might also be interested in...</h2>';
							$max = (count($other_articles) >= 3) ? 3 : count($other_articles);
							for ($i=0; $i < $max; $i++) {
								$article = $other_articles[$i];
								$article_name = $article[3];
								if(strlen($article_name) >= 49 ){
									$article_name = substr($article_name, 0, 45);
									$article_name .= "..";
								}

								echo '<a href="./?mod=' . $article[0] .'" title="'. $article[3] .'"><div class="img" style="background-image: url('. $article[4] .');"></div><p>'. $article_name .'</p></a>';
							}
						}
					 ?>
					</div>
				</aside>
			</div>
		</div>
	</main>

	<footer class="footer">
		<div class="container">
			<?php echo $footer; ?>
		</div>
	</footer>

	<?php echo $cookiebar; ?>

	<?php echo $footerPixel; ?>

	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<?php echo $atrk->pixel(AffinitasTrackingSDK::SITE_ONEPAGE, AffinitasTrackingSDK::POSITION_BOTTOM_OF_BODY); ?>
</body>
</html>
