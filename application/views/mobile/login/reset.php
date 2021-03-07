<?php

$query = $this->db()->query("select * from db_reset_pass where email='".decrypt(splice(3))."' and status='0' ");

if($query->rowCount() == 0) {

	header("location:".HomeUrl()."/login");
	exit;

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Reset - <?php echo setting()->title?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo HomeUrl() ?>/css/login.css" />
	<link rel="shortcut icon" href="<?php echo setting()->icon?>">

</head>
<body>

	<p class="title">Reset Password</p>

	<div class="box-login">
	<div style="text-align: center;padding: 10px;margin-bottom: 10px;">
		<a href="<?php echo HomeUrl()?>"><img src="<?php echo setting()->logo?>" style="width:60%;"></a>
	</div>
	<form method="POST" action="<?php echo HomeUrl()?>/login/auth_reset/<?php echo splice(3)?>">
		<input type="password" class="form-input" name="password" autocomplete="off" placeholder="New Password">
		<input type="password" class="form-input" name="repassword" autocomplete="off" placeholder="Re-type New Password">

		<div class="line-space"></div>

		<img src="<?php echo create_captcha()->captcha_image_url?>" style="width: 100%;height:70px;margin-top:10px;margin-bottom:20px;border-radius: 5px;">

		<input type="text" class="form-input" name="chaptcha" autocomplete="off" placeholder="Masukkan Chaptcha ">

		<button class="btn-green" style="cursor: pointer;">Reset Password</button>

	</form>
	</div>

	<p class="bottom-title">Remember your password? <b style="cursor:pointer;" onClick="window.location='<?php echo HomeUrl()?>/login/register';">Login</b></p>

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