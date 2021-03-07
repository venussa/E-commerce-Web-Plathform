<?php
	
	$query = $this->db()->query("SELECT * FROM db_deposit_request WHERE user_id='".userinfo()->user_id."' and type='3' and status='0' ");
	
	if($query->rowCount() > 0){

		echo "<script>alert('Permintaan depositnya masih dalam proses. Mohon Tunggu, Terimakasih.');
		window.history.back();</script>";
		exit;

	}

?>
<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Deposit</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Minimum deposit saldo sebesar Rp 10.000. Masukkan informasi rekening yang anda gunakan untuk transfer dengan benar guna mempercepat proses verifikasi.</i></p>
<form method="POST" action="<?php echo HomeUrl()?>/clientarea/deposit_saldo" enctype="multipart/form-data">
<table width="100%" style="">
	
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nama Pada Rekening</p>
		
		<input type="text" name="card_name" class="form-input" style="width: 93%" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nama Bank</p>
			<p class="t2">* Nama bank yang anda gunakan</p>
		
		<input type="text" name="bank_name" class="form-input" style="width: 93%" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nomor Rekening</p>
		
		<input type="text" name="rekening_number" class="form-input" style="width: 93%" required></td>
	</tr>
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Besar Dana</p>
			<p class="t2">* Minimum saldo deposit sebesar Rp 10.000</p>
		
		<input type="text" name="saldo" class="form-input" style="width: 93%" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Lampiran</p>
			<p class="t2">* Foto Bukti transfer</p>
		

			
			<?php $pict = sourceUrl()."/img/img-upload.png"; ?>

			<img src="<?php echo $pict?>" style="width: 75px;height:75px;cursor: pointer;" id="img-icon" onClick="click_upload('input-icon')">
				<input type="file" id="input-icon" name="picture" style="display: none;" required="">
		</td>
	</tr>
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kode Verifikasi</p>
			<p class="t2">* Kode keamanan yang dikirim ke email yang terdaftar pada akun anda.</p>

			<input type="text" name="code" class="form-input" required style="width: 52%">
			<button style="width: 40%;padding: 10px;border-radius: 0px;" class="btn-white" type="button" onClick="verif_refund()">Dapatkan Kode</button>
		</td>
	</tr>
	<tr>
		<td>

			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white rebuild" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Ajukan Permintaan</button>
		</td>
	</tr>

	

</table>

</form>
<br>
<br>
<br>