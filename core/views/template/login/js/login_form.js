$(document).ready(function (e) {

	$('.loginform-password-showbtn').on('click', function () {
		if ($('.loginform-password-input').is('[type=password]')) {
			$('.loginform-password-input').attr('type', 'text');
			$(this).children('svg').removeClass('fa-eye-slash').addClass('fa-eye');
		} else {
			$('.loginform-password-input').attr('type', 'password')
			$(this).children('svg').removeClass('fa-eye').addClass('fa-eye-slash');
		}
	})

});