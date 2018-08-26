var ed_validator = function(){
	var $gender;
	var $birthday_day;
  var $birthday_month;
  var $birthday_year;
	var $email;
  var $legal;

  var validateGender = function(){
  	var valid = true;
		if ($gender.val() !== null) {
			$('.gender-error').parents('.row').first().removeClass('show-error');
		} else {
			$('.gender-error').parents('.row').first().addClass('show-error');
			valid = false;
		}
		return valid;
  };
  var validateBirthday = function() {
  	var valid = true;
  	if($birthday_day.val() !== null && $birthday_month.val() !== null && $birthday_year.val() !== null){
			$('.birthday-error').parents('.row').first().removeClass('show-birthday-error');
    }else{
      $('.birthday-error').parents('.row').first().addClass('show-birthday-error');
      valid = false;
    }
    return valid;
  };
  var validateAge = function() {
  	var valid = true;
  	var today = new Date();
  	var oldenough = false;
  	
  	if ($birthday_year.val() < (-18 + today.getFullYear())) {
  		oldenough = true;
  	} else if($birthday_year.val() == (-18 + today.getFullYear()) && $birthday_month.val() < (1 + today.getMonth())){
  		oldenough = true;
  	} else if($birthday_year.val() == (-18 + today.getFullYear()) && $birthday_month.val() == (1 + today.getMonth()) && $birthday_day.val() < today.getDate()){
  		oldenough = true;
  	}
  	if(oldenough){
			$('.age-error').parents('.row').first().removeClass('show-age-error');
    }else{
      $('.age-error').parents('.row').first().addClass('show-age-error');
      valid = false;
    }
    return valid;
  };
  var validateEmail = function() {
  	var emailCheck = function(str) {
			var reg = new RegExp('^([a-zA-Z0-9\\-\\.\\_]+)' +
					'(\\@)([a-zA-Z0-9\\-\\.]+)' +
					'(\\.)([a-zA-Z]{2,4})$');
			return str.length && reg.test(str);
		};
  	var valid = true;
  	if (!emailCheck($email.val())) {
			$('.email-error').parents('.row').first().addClass('show-error');
			valid = false;
		} else {
			$('.email-error').parents('.row').first().removeClass('show-error');
		}
    return valid;
  };
  var validateLegal = function() {
  	var valid = true;
  	if(!$legal.is(':checked')){
      $('.legal-error').parents('.row').first().addClass('show-error');
      valid = false;
    }else{
      $('.legal-error').parents('.row').first().removeClass('show-error');
    }
    return valid;
  };

	var validateForm = function(){
		var valid = true;
		
		valid = (validateGender())? valid : false;
		valid = (validateBirthday() && validateAge())? valid : false;
		valid = (validateEmail())? valid : false;
		valid = (validateLegal())? valid : false;
		
		return valid;
	};
	var addLiveValidation = function(){
		$gender.on('change', function(){
			if ($gender.parents('show-error')) {
				return validateGender();
			}
		});
		$birthday_day.on('change', function(){
			if ($birthday_day.parents('.show-error, .show-birthday-error, .show-age-error').length) {
				return (validateBirthday() && validateAge());
			}
		});
		$birthday_month.on('change', function(){
			if ($birthday_month.parents('.show-error, .show-birthday-error, .show-age-error').length) {
				return (validateBirthday() && validateAge());
			}
		});
		$birthday_year.on('change', function(){
			if ($birthday_year.parents('.show-error, .show-birthday-error, .show-age-error').length) {
				return (validateBirthday() && validateAge());
			}
		});
		$email.on('keyup', function(){
			if ($email.parents('.show-error').length) {
				return validateEmail();
			}
		});
		$legal.on('change', function(){
			if ($legal.parents('.show-error').length) {
				return validateLegal();
			}
		});
	};
	return {
		init: function(){
			var $form = $('#signup-form');
			$gender = $form.find('[name="subscribers[search]"]');
			$birthday_day = $form.find('[name="subscribers[birthday][day]"]');
		  $birthday_month = $form.find('[name="subscribers[birthday][month]"]');
		  $birthday_year = $form.find('[name="subscribers[birthday][year]"]');
			$email = $form.find('[name="subscribers[email]"]');
		  $legal = $form.find('[name="subscribers[optin]"]');
			
			$form.on('submit', function(){
				return validateForm();
			});
			addLiveValidation($form);
		}
	};
}();


jQuery(document).ready(function($) {
	ed_validator.init();
});
