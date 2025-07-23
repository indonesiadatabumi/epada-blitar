<!DOCTYPE html>
<html lang="en">

<head>
	<title>Sistem Informasi Pajak Daerah</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="shortcut icon" href="<?= $this->config->item('img_path'); ?>logo_lutim.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" href="<?= $this->config->item('css_path'); ?>bootstrap/bootstrap.min.css" type="text/css" media="all" />
	<!--===============================================================================================-->
	<link rel="stylesheet" href="<?= $this->config->item('css_path'); ?>font-awesome.min.css" rel="stylesheet">


	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>util.css">
	<link rel="stylesheet" type="text/css" href="<?= $this->config->item('css_path'); ?>login-style.css">

	<link rel="stylesheet" href="<?= $this->config->item('css_path'); ?>preloader-style2.css">

	<!--===============================================================================================-->
</head>

<body>

	<div id="pagePreloader" class="loader-wrap" style="display:none">
		<div class="loader">
			<span class="loader-item"></span>
			<span class="loader-item"></span>
			<span class="loader-item"></span>
			<span class="loader-item"></span>
			<span class="loader-item"></span>
			<span class="loader-item"></span>
			<span class="loader-item"></span>
			<span class="loader-item"></span>
			<span class="loader-item"></span>
			<span class="loader-item"></span>
		</div>
	</div>

	<div id="motherContainer" class="limiter">

		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" id="login-form" method="POST" action="<?= base_url(); ?>login/login_auth">
					<input type="hidden" id="base_url" value="<?= base_url(); ?>" />
					<span class="login100-form-title p-b-34">
						Account Login
					</span>

					<div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user name">
						<input id="first-name" class="input100" type="text" name="username" placeholder="User name">
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" id="login-btn">
							Sign in
						</button>
					</div>

					<div class="w-full text-center p-t-27 p-b-239">
						<span class="txt1">
							Forgot
						</span>

						<a href="#" class="txt2">
							User name / password?
						</a>

						<div id="login-notification" style="margin-top:10px;display:none">
							<div class="alert alert-danger">
								Username atau password anda salah !
							</div>
						</div>

					</div>


					<div class="w-full text-center">

					</div>
				</form>

				<div class="login100-more" style="background-image: url('<?= $this->config->item('img_path'); ?>login_bg.png');"></div>
			</div>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script type="text/javascript" src="<?= $this->config->item('vendor_path'); ?>jquery/jquery-3.2.1.min.js"></script>

	<!--===============================================================================================-->
	<script src="<?= $this->config->item('js_path'); ?>login.js"></script>

	<script type="text/javascript">
		(function($) {
			$(document).ready(function() {

				var $login_form = $('#login-form'),
					$btnLogin = $('#login-btn'),
					$notification = $('#login-notification'),
					$loadImg = "<?php echo "<img src='" . $this->config->item('img_path') . "ajax-loaders/ajax-loader-1.gif'/>"; ?>";

				$login_form.submit(function() {
					$.ajax({
						type: 'POST',
						url: $login_form.attr('action'),
						data: $login_form.serialize(),
						dataType: 'json',
						beforeSend: function() {
							$btnLogin.html($loadImg + "please wait...");
						},
						success: function(data) {

							$btnLogin.html("Log in");

							msg = '';

							if (data.status == 'success') {

								msg = "Akun anda dikenali, kami sementara mengarahkan anda ke Halaman Dasboard " + $loadImg;

								$notification.html("<div class='alert alert-success' style='font-size:0.8em'>" + msg + "</div>");
								$notification.show();
								setTimeout(function() {
									window.location.assign($('#base_url').val() + 'front');
								}, 3000);


							} else {

								switch (data.status) {
									case 'failed1':
										msg = 'Maaf, Username atau Password tidak dikenali!';
										break;
									case 'failed2':
										msg = 'Akun anda tidak aktif, silahkan hubungi Administrator Sistem';
										break;
									case 'failed3':
										msg = 'Sistem sedang dikunci untuk sementara!';
										break;
								}

								$notification.html("<div class='alert alert-danger' style='font-size:0.8em'>" + msg + "</div>");
								$notification.show();
								setTimeout(function() {
									$notification.hide();
								}, 3000);

							}
						},
						error: function(xhr, resp, text) {
							console.log(xhr, resp, text);
						}
					});
					return false;
				});

			});

		})(jQuery);
	</script>
</body>

</html>