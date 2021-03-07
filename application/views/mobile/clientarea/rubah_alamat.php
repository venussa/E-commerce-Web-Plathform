<?php 
$query = $this->db()->query("SELECT * FROM db_destination_address WHERE user_id='".userinfo()->user_id."'  and id='".$this->get("id")."' ");
$show = $query->fetch();
?>
<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Rubah Alamat</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Masukan alamat yang benar dan tepat untuk mempermudah dalam proses pengiriman barang pesanan anda "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/clientarea/rubahalamat?id=<?php echo $show['id']?>" enctype="multipart/form-data">
<table width="100%" style="">
	
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Nama Penerima</p>
			<p class="t2">* Nama penerima sesuai alamat yang anda masukkan</p>
		
		<input type="text" name="nama_penerima" class="form-input" required value="<?php echo $show['nama_penerima']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Alamat</p>
			<p class="t2">* Masukkan alamat lengkap</p>
		
		<input type="text" name="address" class="form-input" required value="<?php echo $show['address']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Provinsi</p>
		

			<select name="province" class="form-input" style="width: 99.5%">
				<?php 

					foreach(provinsi() as $key => $value){

						if($value == $show['province'])
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(provinsi() as $key => $value){

						if($value !== $show['province'])
						echo "<option value='$key'>$value</option>";

						else $kode = $key;

					}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Kabupaten / Kota</p>
		

			<select name="state" class="form-input" style="width: 99.5%">
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value == $show['state'])
						echo "<option value='$key'>$value</option>";

					}

				?>
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value !== $show['state'])
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Kecamatan</p>
		

			<select name="district" class="form-input" style="width: 99.5%">

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value == $show['district'])
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value !== $show['district'])
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>
		</td>
	</tr>


	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Kode Pos</p>
		
		<input type="text" name="zip_code" class="form-input" required value="<?php echo $kode?>" readonly="" style="background: #f5f5f5"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Label</p>
		

			<input type="text" name="label" class="form-input" required value="<?php echo $show['label']?>">
			<span style="color:#666;font-size:12px;">Contoh : Rumah, Apatement, Kantor, Kos, Dll</span>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Nomor Telephone</p>
			<p class="t2">* Nomor telepon yang dapat di hubungi</p>
		
		<input type="text" name="phone_number" class="form-input" required value="<?php echo $show['phone_number']?>"></td>
	</tr>

	<tr>
		<td>
			
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white rebuild" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;background: #fe4c50;border:1px #fe4c50 solid;border-radius: 5px;width:100%">Simpan Alamat</button>
		</td>
	</tr>

</table>

</form>