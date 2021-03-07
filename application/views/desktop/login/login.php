<!DOCTYPE html>
<html>
<head>
	<title>Login - <?php echo setting()->title?></title>

	<link rel="stylesheet" href="<?php echo HomeUrl() ?>/css/login.css" />
	<link rel="shortcut icon" href="<?php echo setting()->icon?>">

</head>
<body>

	<p class="title">Sign In</p>

	<div class="box-login">

	<form method="POST" action="<?php echo HomeUrl()?>/login/auth">
		<input type="text" class="form-input" name="username" autocomplete="off" placeholder="Username">

		<input type="password" class="form-input" name="password" autocomplete="off" placeholder="Password">

		<div class="line-space"></div>

		<img src="<?php echo create_captcha()->captcha_image_url?>" style="width: 100%;height:50px;margin-top:10px;margin-bottom:20px;border-radius: 5px;">

		<input type="text" class="form-input" name="chaptcha" autocomplete="off" placeholder="Masukkan Chaptcha ">

		<button class="btn-green" style="cursor: pointer;">Sign In</button>
		<p class="forgot-title" style="cursor:pointer;" onClick="window.location='<?php echo HomeUrl()?>/login/forgot_password';">Forgot Password ?</p>

	</form>
	</div>

	<p class="bottom-title">Don't have an account? <b style="cursor:pointer;" onClick="window.location='<?php echo HomeUrl()?>/login/register';">Create one now</b></p>

	<script src="<?php echo HomeUrl() ?>/js/jquery-3.4.1.min.js"></script>
	<script>

		function resize(){

			$(".bg-login").css({

					"height" : $(window).height()+"px"

			});

		}

		$(function(){

			resize();

			$(window).resize(function(){

				resize();

			});

		});

	</script>

</body>
</html>