<style>
	.form-input{
	padding: 10px;
	width: 93%;
	border:1px #ddd solid;
	border-radius: 5px;
	margin-bottom:10px;
	font-size:17px;
}

.form-input:focus{
	border:1px #cdfadf solid;
}
</style>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>"Halaman untuk mengubah informasi akun anda"</i></p>


<form method="POST" action="<?php echo HomeUrl()?>/clientarea/change_profile" enctype="multipart/form-data">

		<div style="width: 49%;float:left">
			<p class="input-title">Nama Depan</p>
			<input type="text" class="form-input" name="first_name" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;" value="<?php echo userinfo()->first_name?>">

			<p class="input-title">Nama Belakang</p>
			<input type="text" class="form-input" name="last_name" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;" value="<?php echo userinfo()->last_name?>">

			<p class="input-title">Jenis Kelamin</p>
			<select type="text" class="form-input" name="gender" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width:97%;">
				<option>Laki - laki</option>
				<option>Perempuan</option>
			</select>

			<p class="input-title">Email</p>
			<input  type="text" class="form-input" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;background: #ccc;" value="<?php echo userinfo()->email?>" readonly>
			<span style="color:#09f;font-size: 12px;cursor: pointer;" onClick="change_email()">Ganti Email</span>


			<p class="input-title">Username</p>
			<input type="text" class="form-input" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;background: #ccc;" value="<?php echo userinfo()->username?>" readonly>
			<span style="color:#09f;font-size: 12px;cursor: pointer;" onClick="change_password()">Ganti Password</span>

	

			<p class="input-title">Nomor Telephone</p>
			<input type="text" class="form-input" name="phone_number" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;" value="<?php echo userinfo()->phone_number?>">

		</div>

		<div style="width: 49%;float:left;margin-left:10px;">
			<p class="input-title">Alamat Lengkap</p>
			<textarea type="text" class="form-input" name="address" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;min-height:96.5px;max-height:96.5px;"><?php echo userinfo()->address?></textarea>

			<p class="input-title" style="margin-top: 5px;">Provinsi</p>
			<select name="province" class="form-input" style="padding: 5px;font-size:13px;width: 98%">
				<?php 

					foreach(provinsi() as $key => $value){

						if($value == userinfo()->province)
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(provinsi() as $key => $value){

						if($value !== userinfo()->province)
						echo "<option value='$key'>$value</option>";

						else $kode = $key;

					}

				?>
			</select>


			<p class="input-title">Kabupaten / Kota</p>
			<select name="state" class="form-input" style="padding: 5px;font-size:13px;width: 98%">
				
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value == userinfo()->state)
						echo "<option value='$key'>$value</option>";

					}

				?>
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value !== userinfo()->state)
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>

			<p class="input-title">Kecamatan</p>
			<select name="district" class="form-input" style="padding: 5px;font-size:13px;width: 98%">
				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value == userinfo()->district)
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value !== userinfo()->district)
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>

			<p class="input-title">Kode Pos</p>
			<input type="text" class="form-input" name="zip_code" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;background: #f5f5f5" value="<?php echo $kode?>" readonly="">

			<p class="input-title">Foto Profile</p>

			<?php 

			if(empty(userinfo()->profile_pict)) $pict = sourceUrl()."/img/img-upload.png";
			else $pict = sourceUrl()."/usr_pict/".userinfo()->profile_pict; 

			?>

			<img src="<?php echo $pict?>" style="width: 75px;height:75px;cursor: pointer;" id="img-icon" onClick="click_upload('input-icon')">
				<input type="file" id="input-icon" name="profile_pict" style="display: none;">
		</div>
	

		<div style="width: 97%;float:left;font-size:14px;margin-top:10px;background: #f5f5f5;padding: 10px;border:1px #ddd solid;border-radius: 5px;">
			
			<label class="cb-container"> Apakah anda yakin data yang di input sudah benar?
			  <input type="checkbox" id="checkbox-data" required="">
			  <span class="checkmark"></span>
			</label>
			
			<div style="border-top:1px #ddd dashed;margin-top:10px;padding-top:10px;">

			<button id="submit-profile-data" class="btn-white" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;padding:6px;border-radius: 4px;">Save Changes</button>
			</div>
		</div>




		<div id="modal-email" style="width: 100%;background: rgba(0, 0, 0, 0.5);position: fixed;z-index: 999;left: 0px;top:0px;height: 2000px;display: none;">
		
			<div style="background: #fff;border:1px #ddd solid;padding: 15px;width: 35%;margin: auto;margin-top: 100px;border-radius: 5px;">

				<h2 style="border-bottom: 1px #ddd solid;padding-bottom: 10px;margin-top:-5px;border-left:5px #3a6da1">Ganti Email 

					<img src="<?php echo sourceUrl()?>/img/times.png" style="float:right;width: 10px;cursor:pointer;margin-top: 5px;" onClick="change_email()">
				</h2>
				
				<span id="change-email">
					<p class="input-title">Email Baru</p>
					<input id="email" type="text" class="form-input" name="email" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width: 98%">

					<p class="input-title">Ulangi Email Baru</p>
					<input id="email" type="text" class="form-input" name="remail" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width: 98%">
		
					
					<p class="input-title">Kode Verifikasi </p>
					<input type="text" class="form-input" name="verifikasi" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width: 78%;margin-right: 12px;" onKeyup="return verif(this)">
					<span style="border:1px #3a6da1 solid;color:#fff;background: #3a6da1;border-radius: 3px;padding: 5px;font-size:12px;cursor:pointer" onClick="return send_code(this)">Kirim Kode</span>
					
					

					<div style="width: 100%;margin-top:20px;border-top:2px #ddd dashed;padding-top: 10px;">
						<button class="btn-white" type="button" style="cursor:pointer;padding: 5px;border-radius:5px;font-size: 15px;" onClick="check_data()">Save Changes</button>
					</div>


				</span>

		</div>

	</div>


	<div id="modal-password" style="width: 100%;background: rgba(0, 0, 0, 0.5);position: fixed;z-index: 999;left: 0px;top:0px;height: 2000px;display: none;">
	
		<div style="background: #fff;border:1px #ddd solid;padding: 15px;width: 35%;margin: auto;margin-top: 100px;border-radius: 5px;">

			<h2 style="border-bottom: 1px #ddd solid;padding-bottom: 10px;margin-top:-5px;border-left:5px #3a6da1">Ganti Password

				<img src="<?php echo sourceUrl()?>/img/times.png" style="float:right;width: 10px;cursor:pointer;margin-top: 5px;" onClick="change_password()">
			</h2>
			
			<span id="change-password">
				

				<p class="input-title">Password Lama</p>
				<input id="username" onKeyup="return check_char(this)" type="password" class="form-input" name="oldpassword" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width: 98%">

				<div style="margin-top:-10px;">
				<span id="alert-username" style="color:#ff0000;font-size: 10px;display: none;">Kurang Dari 8 Karakter</span>
				</div>

				<p class="input-title">Password Baru</p>
				<input id="password" onKeyup="return check_char(this)" type="password" class="form-input" name="newpassword" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width: 98%">
				<div style="margin-top:-10px;">
					<span id="alert-password" style="color:#ff0000;font-size: 10px;display: none;">Kurang Dari 8 Karakter</span>
				</div>

				<p class="input-title">Ulangi Password</p>
				<input id="repassword" onKeyup="return check_char(this)" type="password" class="form-input" name="renewpassword" autocomplete="off" placeholder="" style="padding: 5px;font-size:13px;width: 98%">
				<div style="margin-top:-10px;">
				<span id="alert-repassword" style="color:#ff0000;font-size: 10px;display: none;">Kurang Dari 8 Karakter</span>
				</div>
				
				

				<div style="width: 100%;margin-top:20px;border-top:2px #ddd dashed;padding-top: 10px;">
					<button class="btn-white" type="button" style="cursor:pointer;padding: 5px;border-radius:5px;font-size: 15px;" onClick="check_data()">Save Changes</button>
				</div>


			</span>

		</div>

	</div>

	</form>
