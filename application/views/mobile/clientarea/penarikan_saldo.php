<?php
	
	$query = $this->db()->query("SELECT * FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type='1' and status='0' ");
	
	if($query->rowCount() > 0){
		echo "<script>alert('Permintaan penarikan masih dalam proses. Mohon Tunggu, Terimakasih.');
		window.history.back();</script>";
		exit;

	}

?>
<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Penarikan Saldo</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Minimum penarikan saldo sebesar Rp 50.000 dan biaya transaksi akan dibebankan kepada customer. Masukkan informasi rekening anda dengan benar. Dana akan di transfer ke rekening sesuai data yang anda input.</i></p>
<form method="POST" action="<?php echo HomeUrl()?>/clientarea/refund" enctype="multipart/form-data">
<table width="100%" style="">
	
	<tr>
		<td class="tr" style="width: 200px;" valign="top">
			<p class="t1">Informasi Rekening</p>
			<p class="t2">* Saldo akan di transfer sesuai data rekening ini</p>
		<div class="tr">
		

		<?php 
			$query = $this->db()->query("SELECT * FROM db_user_bank WHERE user_id='".userinfo()->user_id."' ");
			if($query->rowCount() > 0){?>

			<span class="select-rekening">
			<select class="form-input" name="bank_info" style="width: 100%">
				<?php
				while($show = $query->fetch()){ ?>
				<option value="<?php echo $show['id']?>"><?php echo $show['bank_name']?> / <?php echo $show['rekening_number']?> / <?php echo $show['card_name']?></option>
				<?php }?>
			</select>
			<p style="margin-top:5px;"><a href="javascript:void(0)" onClick="show_add_rek(1)" style="color:orangered;font-size: 13px;">Tambah Rekening</a></p>
			</span>

			<div class="add-rekening" style="background: #f9f9f9;padding: 10px;display: none;">
			<p class="t1">Nama Bank</p>
			<input type="text" class="form-input" style="width: 93%">
			<p class="t1">Nomor Rekening</p>
			<input type="text" class="form-input" style="width: 93%">
			<p class="t1">Nama Pada Rekening</p>
			<input type="text" class="form-input" style="width: 93%">
			<p style="margin-top:5px;"><a href="javascript:void(0)" onClick="show_add_rek(0)" style="color:orangered;font-size: 13px;">Batal Tambah Rekening</a></p>
			</div>

			<?php }else{ ?>

			<div class="add-rekening" style="background: #f9f9f9;padding: 10px;">
			<p class="t1">Nama Bank</p>
			<input type="text" name="bank_name" class="form-input" required="" style="width: 93%">
			<p class="t1">Nomor Rekening</p>
			<input type="text" name="rekening_number" class="form-input" required="" style="width: 93%">
			<p class="t1">Nama Pada Rekening</p>
			<input type="text" name="card_name" class="form-input" required="" style="width: 93%">
			</div>
			<?php } ?>


	</div>
	</tr>
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Besar Penarikan</p>
			<p class="t2">* Minimum dana yang dapat di tarik ialah sebesar Rp 50.000</p>
		
		<input type="text" name="saldo" style="width:93%" class="form-input" required></td>
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