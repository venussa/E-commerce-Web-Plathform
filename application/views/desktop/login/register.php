<!DOCTYPE html>
<html>
<head>
	<title>Register - <?php echo setting()->title?></title>

	<link rel="stylesheet" href="<?php echo HomeUrl() ?>/css/login.css" />
	<link rel="shortcut icon" href="<?php echo setting()->icon?>">

</head>
<body>

	<p class="title">Register User</p>

	<div class="box-login-1" style="padding: 0px;">
	<div class="box-login" style="width: 100%;float: left;">

	<form method="POST" action="<?php echo HomeUrl()?>/login/auth_register?type=1">

		<div style="width: 49%;float:left">
			<p class="input-title">Nama Depan</p>
			<input type="text" class="form-input" name="first_name" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;">

			<p class="input-title">Nama Belakang</p>
			<input type="text" class="form-input" name="last_name" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;">

			<p class="input-title">Jenis Kelamin</p>
			<select type="text" class="form-input" name="gender" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width:97%;">
				<option>Laki - laki</option>
				<option>Perempuan</option>
			</select>


			<p class="input-title">Email</p>
			<input id="email" type="text" class="form-input" name="email" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width: 65%">
			<span style="float: right;border:1px #3a6da1 solid;color:#fff;background: #3a6da1;border-radius: 3px;padding: 5px;font-size:12px;margin-right: 10px;cursor:pointer" onClick="return send_code(this)">Kirim Kode</span>

			<p class="input-title">Kode Verifikasi</p>
			<input type="text" class="form-input" name="verifikasi" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;" onKeyup="return verif(this)">

			<p class="input-title">Nomor Telephone</p>
			<input type="text" class="form-input" name="phone_number" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;">

		</div>

		<div style="width: 49%;float:left;margin-left:10px;">
			<p class="input-title">Alamat Lengkap</p>
			<textarea type="text" class="form-input" name="address" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;min-height:96.5px;max-height:96.5px;"></textarea>

			<p class="input-title" style="margin-top: 5px;">Provinsi</p>
			<select name="province" class="form-input" style="padding: 5px;font-size:13px;width: 98%">
				<?php 

					foreach(provinsi() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>


			<p class="input-title">Kabupaten / Kota</p>
			<select name="state" class="form-input" style="padding: 5px;font-size:13px;width: 98%">
				<?php 

					foreach(kabupaten() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>

			<p class="input-title">Kecamatan</p>
			<select name="district" class="form-input" style="padding: 5px;font-size:13px;width: 98%">
				<?php 

					foreach(kecamatan() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>

			<p class="input-title">Kode Pos</p>
			<input type="text" class="form-input" name="zip_code" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;background: #f5f5f5" value="<?php echo kodepos("k1","Mendoyo")?>" readonly="">
		</div>

		<div style="width: 95%;float:left;margin-left:0px;margin-top:20px;border:1px #ddd solid;padding: 10px;background: #f5f5f5">
			
			<div style="width: 31%;float: left;">
				<p class="input-title">Username</p>
				<input id="username" onKeyup="return check_char(this)" type="text" class="form-input" name="username" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;">

				<div style="margin-top:-10px;">
				<span id="alert-username" style="color:#ff0000;font-size: 10px;display: none;">Kurang Dari 8 Karakter</span>
				</div>

			</div>


			<div style="width: 31%;float: left;margin-left:16px;">
				<p class="input-title">Password</p>
				<input id="password" onKeyup="return check_char(this)" type="password" class="form-input" name="password" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;">
				<div style="margin-top:-10px;">
					<span id="alert-password" style="color:#ff0000;font-size: 10px;display: none;">Kurang Dari 8 Karakter</span>
				</div>
			</div>

			<div style="width: 31%;float: left;margin-left:16px;">
				<p class="input-title">Ulangi Password</p>
				<input id="repassword" onKeyup="return check_char(this)" type="password" class="form-input" name="repassword" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;">
				<div style="margin-top:-10px;">
				<span id="alert-repassword" style="color:#ff0000;font-size: 10px;display: none;">Kurang Dari 8 Karakter</span>
				</div>
			</div>

		</div>

		<div style="width: 100%;float:left;font-size:14px;margin-top:10px;">
			
			<label class="cb-container"> Anda bersedia menyetujui peraturan yang kami tetapkan?
			  <input type="checkbox" required="">
			  <span class="checkmark"></span>
			</label>

	 
			<div style="border-top:1px #ddd dashed;margin-top:10px;padding-top:10px;">


				<img src="<?php echo create_captcha()->captcha_image_url?>" style="width: 10%;position:absolute;margin-top:0px;height:42.5px;border-radius: 5px;float: left;">

		<input type="text" class="form-input" name="chaptcha" autocomplete="off" placeholder="Masukkan Chaptcha " style="width: 50%;margin-left:24%">

			<button class="btn-green" type="submit" style="cursor:pointer;width: 20%;margin: auto;">Kirim</button>
			</div>
		</div>

	</form>
	</div>

	<div style="float: left;width: 100%;margin-top:10px;">
		<p class="bottom-title" style="">Already have account? <b style="cursor:pointer;" onClick="window.location='<?php echo HomeUrl()?>/login';">Login</b></p>
	</div>
	</div>

	

	<script src="<?php echo HomeUrl() ?>/js/jquery-3.4.1.min.js"></script>
	<script>

		var base_url = "<?php echo HomeUrl()?>";

		function check_char(obj){

			var text = $(obj).val().length;

			switch($(obj).attr("id")){

				case "username":

					if(text < 6){
						
						$("#username").css({"border" : "1px #ff0000 solid"});
						$("#alert-username").show();
						$("#alert-username").html("Minimal 8 Karakter");

					}else if(text > 12){

						$("#username").css({"border" : "1px #ff0000 solid"});
						$("#alert-username").show();
						$("#alert-username").html("Maksimal 12 Karakter");

					}else{

						$("#username").css({"border" : ""});
						$("#alert-username").hide();
						$("#alert-username").html("");

					}

				break;

				case "password":

					if(text < 6){
						
						$("#password").css({"border" : "1px #ff0000 solid"});
						$("#alert-password").show();
						$("#alert-password").html("Minimal 8 Karakter");

					}else if(text > 12){

						$("#password").css({"border" : "1px #ff0000 solid"});
						$("#alert-password").show();
						$("#alert-password").html("Maksimal 12 Karakter");

					}else{

						$("#password").css({"border" : ""});
						$("#alert-password").hide();
						$("#alert-password").html("");

					}

				break;

				case "repassword":

					if(text < 6){
						
						$("#repassword").css({"border" : "1px #ff0000 solid"});
						$("#alert-repassword").show();
						$("#alert-repassword").html("Minimal 8 Karakter");

					}else if(text > 12){

						$("#repassword").css({"border" : "1px #ff0000 solid"});
						$("#alert-repassword").show();
						$("#alert-repassword").html("Maksimal 12 Karakter");

					}else{

						if($("#repassword").val() !== $("#password").val()){
							$("#password").css({
								"border" : "1px #ff0000 solid",
								"background" : "#ebc2b9"
							});
							
							$("#repassword").css({
								"border" : "1px #ff0000 solid",
								"background" : "#ebc2b9"
							});
							
							$("#alert-repassword").hide();
							$("#alert-repassword").html("");

							

						}else{
							$("#password").css({
								"border" : "1px #53a65e solid",
								"background" : "#a2dbaa"
							});

							$("#repassword").css({
								"border" : "1px #53a65e solid",
								"background" : "#a2dbaa"
							});

							$("#alert-repassword").hide();
							$("#alert-repassword").html("");

							
						}
						
					}

				break;

			}

			

		}

		function verif(obj){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/login/auth_register?type=0",
				data: {
					verifikasi : $(obj).val()
				},
				success : function(event){

					if(event.indexOf("<true/>") !== -1){

						$(obj).css({
								"border" : "1px #53a65e solid",
								"background" : "#a2dbaa"
						});

					}else{

						$(obj).css({
								"border" : "1px #ff0000 solid",
								"background" : "#ebc2b9"
						});

					}
							
				}

			});

		}


		function send_code(a){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/login/send_code",
				data: {
					email : $("#email").val()
				},
				beforeSend : function(){

					$(a).html("Mengirim..");

				},
				success : function(){
					alert("Silahkan Cek Email Anda");
					$(a).html("Kirim Kode");
				}

			});

		}

		function resize(){

			$(".bg-login").css({

					"height" : $(window).height()+"px"

			});

		}

		$(function(){

			$("input, select, textarea").attr("required","true");

			resize();

			$(window).resize(function(){

				resize();

			});

			$("[name='district']").change(function(){

				$("[name='zip_code']").val($(this).val());

			});

			$("[name='province']").change(function(){

				$.ajax({

					type : "post",
					url : base_url+"/clientarea/get_region",
					data : {

						region  : 'kabupaten',
						kode 	: $(this).val(),

					},
					success: function(event){

						var result = event.split("|");

						$("[name='state']").html(result[0]);
						$("[name='district']").html(result[1]);
						$("[name='zip_code']").val(result[2]);

					}

				});

			});

			$("[name='state']").change(function(){

				$.ajax({

					type : "post",
					url : base_url+"/clientarea/get_region",
					data : {

						region  : 'kecamatan',
						kode 	: $(this).val(),

					},
					success: function(event){

						var result = event.split("|");
						$("[name='district']").html(result[0]);
						$("[name='zip_code']").val(result[1]);

					}

				});

			});

			$("button").click(function(){

				$("option").removeAttr("value");
				

			});

		});

	</script>

</body>
</html>