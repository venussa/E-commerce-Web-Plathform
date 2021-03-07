<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Masukan alamat yang benar dan tepat untuk mempermudah dalam proses pengiriman barang pesanan anda "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/clientarea/tambahalamat" enctype="multipart/form-data">
<table width="100%" style="">
	
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nama Penerima</p>
			<p class="t2">* Nama penerima sesuai alamat yang anda masukkan</p>
		</td>
		<td><input type="text" name="nama_penerima" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Alamat</p>
			<p class="t2">* Masukkan alamat lengkap</p>
		</td>
		<td><input type="text" name="address" class="form-input" required></td>
	</tr>

	
	

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Provinsi</p>
		</td>
		<td>
			<select name="province" class="form-input" style="width: 99.5%">
				<?php 

					foreach(provinsi() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kabupaten / Kota</p>
		</td>
		<td>
			<select name="state" class="form-input" style="width: 99.5%">
				<?php 

					foreach(kabupaten() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kecamatan</p>
		</td>
		<td>
			<select name="district" class="form-input" style="width: 99.5%">
				<?php 

					foreach(kecamatan() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>
		</td>
	</tr>


	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kode Pos</p>
		</td>
		<td><input type="text" name="zip_code" class="form-input" required value="<?php echo kodepos("k1","Mendoyo")?>" readonly="" style="background: #f5f5f5"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Label</p>
		</td>
		<td>
			<input type="text" name="label" class="form-input" required>
			<span style="color:#666;font-size:12px;">Contoh : Rumah, Apatement, Kantor, Kos, Dll</span>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nomor Telephone</p>
			<p class="t2">* Nomor telepon yang dapat di hubungi</p>
		</td>
		<td><input type="text" name="phone_number" class="form-input" required></td>
	</tr>

	<tr>
		<td></td>
		<td>
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white rebuild" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Simpan Alamat</button>
		</td>
	</tr>

</table>

</form>