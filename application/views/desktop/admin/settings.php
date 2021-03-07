
<?php

$query = $this->db()->query("SELECT * FROM db_settings");
while($show = $query->fetch()){

	$build[$show['name']] = $show['conf'];

}

$setting = json_decode(json_encode($build));

if(empty($setting->icon)) $setting->icon = sourceUrl()."/img/img-icon.png";
else $setting->icon = sourceUrl()."/image/".$setting->icon;


if(empty($setting->logo)) $setting->logo = sourceUrl()."/img/img1.png";
else $setting->logo = sourceUrl()."/image/".$setting->logo;


if(empty($setting->thumbnail)) $setting->thumbnail = sourceUrl()."/img/img2.png";
else $setting->thumbnail = sourceUrl()."/image/".$setting->thumbnail;

?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman untuk melakukan setting dasar website seperti mengubah judul, deskripsi dan juga gambar pendukung. Pengaturan ini akan berpengaruh pada peningkatan Search Engine Optimation</p>

<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/save_setting" enctype="multipart/form-data">
	<table width="100%">
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Site Title</p>
				<p class="t2">* Judul Website</p>
			</td>
			<td><input type="text" name="title" class="form-input" required value="<?php echo $setting->title?>"></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Tagline</p>
				<p class="t2">* Tagline yang di tampilkan</p>
			</td>
			<td><input type="text" name="tagline" class="form-input" required value="<?php echo $setting->tagline?>"></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Description</p>
				<p class="t2">* Deksripsi dari website (Max 160 Character)</p>
			</td>
			<td><textarea type="text" name="description" class="form-input" required style="font-size:13px;"><?php echo $setting->description?></textarea></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;" valign="top">
				<p class="t1">Shop Address</p>
				<p class="t2">* Alamat toko / alamat asal pengiriman</p>
			</td>
			<td>
				<div style="background: #f5f5f5;border:1px #ddd solid;padding: 5px;margin-bottom: 10px;">
				<textarea type="text" name="address" class="form-input" required style="font-size:13px;"><?php echo $setting->address?></textarea>

				<select name="province" class="form-input" style="width: 99.5%;margin-top:10px">
				<?php 

					foreach(provinsi() as $key => $value){

						if($value == $setting->province)
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(provinsi() as $key => $value){

						if($value !== $setting->province)
						echo "<option value='$key'>$value</option>";

						else $kode = $key;

					}

				?>
			</select>

			<select name="state" class="form-input" style="width: 99.5%;margin-top:10px">
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value == $setting->state)
						echo "<option value='$key'>$value</option>";

					}

				?>
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value !== $setting->state)
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>
			
			<select name="district" class="form-input" style="width: 99.5%;margin-top:10px">

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value == $setting->district)
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value !== $setting->district)
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>
			
			<input type="text" name="zip_code" class="form-input" required value="<?php echo $kode?>" readonly="" style="background: #f5f5f5;margin-top:10px">
		</div>

			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Contact Service Number</p>
				<p class="t2">* Nomor yang dapat dihubungi</p>
			</td>
			<td><input type="text" name="contact" class="form-input" required value="<?php echo $setting->contact?>"></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Company Email</p>
				<p class="t2">* Email resmi perusahaan</p>
			</td>
			<td><input type="text" name="email" class="form-input" required value="<?php echo $setting->email?>"></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Facebook</p>
				<p class="t2">* Url fanspage dan sosial media anda (optional)</p>
			</td>
			<td><input type="text" name="facebook" class="form-input" required value="<?php echo $setting->facebook?>"></td>
		</tr>
		
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Twitter</p>
				<p class="t2">* Url Offcial Account Dari sosial media anda (optional)</p>
			</td>
			<td><input type="text" name="twitter" class="form-input" required value="<?php echo $setting->twitter?>"></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Instagram</p>
				<p class="t2">* Url Offcial Account Dari sosial media anda (optional)</p>
			</td>
			<td><input type="text" name="instagram" class="form-input" required value="<?php echo $setting->instagram?>"></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Site Icon</p>
				<p class="t2">* Icon website anda</p>
			</td>
			<td>
				<img src="<?php echo $setting->icon?>" style="width: 50px;height:50px;border:1px #ddd solid;background: #fff;" id="img-icon" onClick="click_upload('input-icon')">
				<p style="font-size: 13px;color:#666;">Gunakan ukuran kurang lebih 150 x 150</p>
				<input type="file" id="input-icon" name="icon" style="display: none;">
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Site Logo</p>
				<p class="t2">* Logo Website anda</p>
			</td>
			<td>
				<div style="border:1px #ddd solid;background: #fff;width: 250px;height:80px;vertical-align: middle;text-align: center;">
					<img src="<?php echo $setting->logo?>" style="width: 100%;height:80px;" id="img-logo" onClick="click_upload('input-logo')">
				</div>

				<p style="font-size: 13px;color:#666;">Gunakan ukuran kurang lebih 150 * 60 (Landscape)</p>
				<input type="file" id="input-logo" name="logo" style="display: none;">
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;" valign="top">
				<p class="t1">Site Thumbnail</p>
				<p class="t2">* Poster dari website anda</p>
			</td>
			<td>
				<div style="border:1px #ddd solid;background: #fff;width: 350px;height:200px;vertical-align: middle;text-align: center;">
					<img src="<?php echo $setting->thumbnail?>" style="width: 100%;height:200px" id="img-thumbnail" onClick="click_upload('input-thumbnail')">
				</div>
				<p style="font-size: 13px;color:#666;">Gunakan ukuran kurang lebih 1395 x 800 (Landscape)</p>
				<input type="file" id="input-thumbnail" name="thumbnail" style="display: none;">
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;" valign="top">
				<p class="t1">Maintenance Status</p>
				<p class="t2">* Mengalihkan website kepada mode maintenance</p>
			</td>
			<td>
				<select name="status" class="form-input" style="width: 99.5%;margin-top:10px">
					<?php if($setting->status == 1){ ?>
					<option value="1">Active</option>
					<option value="0">Nonactive</option>
				<?php }else{ ?>
					<option value="0">Nonactive</option>
					<option value="1">Active</option>
				<?php } ?>
				</select>
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">API Raja Ongkir</p>
				<p class="t2">* API untuk mendapatkan akses informasi mengenai perhitungan harga ongkos kirim melalui jasa ekpedisi</p>
			</td>
			<td><input type="text" name="api" class="form-input" required value="<?php echo $setting->api?>"></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Mail Server Access</p>
				<p class="t2">* Informasi Autentikasi Akun Mail Server</p>
			</td>
			<td>
			<div style="background: #f5f5f5;border:1px #ddd solid;padding: 5px;margin-bottom: 10px;">
				<p style="font-size: 14px;font-family: Segoe UI Bold">SMTP Hostname</p>
				<input type="text" name="smtp_host" class="form-input" required value="<?php echo $setting->smtp_host?>">
				<p style="font-size: 14px;font-family: Segoe UI Bold">SMTP Port</p>
				<input type="text" name="smtp_port" class="form-input" required value="<?php echo $setting->smtp_port?>">
				<p style="font-size: 14px;font-family: Segoe UI Bold">SMTP Username</p>
				<input type="text" name="smtp_user" class="form-input" required value="<?php echo $setting->smtp_user?>">
				<p style="font-size: 14px;font-family: Segoe UI Bold">SMTP Password</p>
				<input type="text" name="smtp_pass" class="form-input" required value="<?php echo $setting->smtp_pass?>">
			</div>
			</td>
		</tr>


		<tr>
			<td></td>
			<td style="border-top:1px #ddd solid;">
				<p><button class="btn-white" type="submit" style="width: 150px;cursor: pointer;">Save Setting</button></p></td>
		</tr>

	</table>
</form>