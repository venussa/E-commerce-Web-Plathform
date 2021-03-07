<?php
if(empty(userinfo()->profile_pict) or (userinfo()->profile_pict == "")) {

	if(strtolower(userinfo()->gender) == "perempuan")
	$pict = sourceUrl()."/img/woman.png";
	else
	$pict = sourceUrl()."/img/man.png";
	
}else $pict = sourceUrl()."/usr_pict/".userinfo()->profile_pict;


	$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type != 1 ");
	$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type=1 and status=1 ");
	$saldo = $saldo0['saldo'] + $saldo1['saldo'];
?>
<table width="100%">
	<tr>
		<td style="width: 80px;"><img src="<?php echo $pict?>" style="width:65px;height:65px;border-radius: 100%;border:1px #ddd solid;"></td>
		<td valign="top">
			<p style="font-size:16px;font-weight: 600"><?php echo ucwords(userinfo()->first_name." ".userinfo()->last_name) ?></p>
			<p style="font-size:12px;margin-top:-15px;">
				<img src="<?php echo sourceUrl()?>/media/mark.png" width="13" style="position: relative;top:1px;color:#666">
				<?php echo userinfo()->state?>, <?php echo userinfo()->province?></span>
			</p>
		</td>
	</tr>
</table>

<?php if(wallet_system() == true){ ?>
<div style="border:1px #ccc solid;border-radius: 5px;margin-top:10px;">
	<p style="padding: 10px;padding-top: 2px;"><a style="color:orangered" href="<?php echo HomeUrl()?>/clientarea/riwayat_saldo">Total Saldo di <?php echo setting()->title?></a></p>
	<p style="font-weight: 600;font-size: 25px;padding: 10px;margin-top: -20px;">Rp <?php echo number_format($saldo)?></p>
	<p style="padding: 10px;margin-top: -20px">
		<a href="<?php echo HomeUrl()?>/clientarea/penarikan_saldo"><button class="btn-white" style="width: 100%;border-radius: 5px;">Tarik Saldo</button></a></p>
	<p style="padding: 10px;margin-top: -20px">
		<a href="<?php echo HomeUrl()?>/clientarea/deposit"><button class="btn-white" style="width: 100%;border-radius: 5px;border:1px #fe4c50 solid; color : #fe4c50;background: #fff;">Deposit</button></a></p>
	</p>
</div>
<?php } ?>

<div style="width: 100%;border-top:2px #ddd dashed;padding-top:15px;margin-top: 10px;border-bottom:2px #ddd dashed;padding-bottom: 15px;">
	<table width="100%">
		<tr>
			<td colspan="3">
				<a style="color:#fff;" href="<?php echo HomeUrl()?>/clientarea/alamat_pengiriman">
				<div style="border:1px #fe4c50 solid;border-radius: 5px;padding:10px;text-align: center;background: #fe4c50;font-size:17px;margin-bottom: 3px;">
				Tambah Alamat
				</div>
				</a>
			</td>
		</tr>
		<tr>
			<td>
				<div style="border:1px #ccc solid;border-radius: 5px;padding:5px;text-align: center;">
				<a href="<?php echo HomeUrl()?>/clientarea/pembayaran_tertunda">
					<p><img src="<?php echo sourceUrl()?>/media/pending.png" style="width: 40px;"></p>
					<p style="color:#434343;margin-top:-8px;">Tertunda</p>
				</a>
				</div>
			</td>

			<td>
				<div style="border:1px #ccc solid;border-radius: 5px;padding:5px;text-align: center;">
				<a href="<?php echo HomeUrl()?>/clientarea/komplain_pembelian">
					<p><img src="<?php echo sourceUrl()?>/media/complain-icon.png" style="width: 40px;"></p>
					<p style="color:#434343;margin-top:-8px;">Komplein</p>
				</a>
				</div>
			</td>

			<td>
				<div style="border:1px #ccc solid;border-radius: 5px;padding:5px;text-align: center;">
				<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi">
					<p><img src="<?php echo sourceUrl()?>/media/tf.png" style="width: 40px;"></p>
					<p style="color:#434343;margin-top:-8px;">Transaksi</p>
				</a>
				</div>
			</td>
			
		</tr>

		<?php if(userinfo()->level > 0){ ?>
		<tr>
			<td colspan="3">
				<a style="color:#fff;" href="<?php echo HomeUrl()?>/clientarea/produk_saya">
				<div style="border:1px #ccc solid;border-radius: 5px;padding:10px;text-align: center;background: #f5f5f5;font-size:17px;margin-bottom: 3px;color:#434343;margin-top:5px;">
					Tambah Produk
				</div>
				</a>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>

<div style="margin-top:20px;background: #f5f5f5;border:1px #ddd solid;padding: 15px;padding-top:0px;border-radius: 5px;">

		<p style="font-weight: 600;margin-top: 15px;">Nama Lengkap</p>
		<p style="margin-top: -10px;color:#666"><?php echo ucwords(userinfo()->first_name." ".userinfo()->last_name)?></p>

		<p style="font-weight: 600;margin-top: 15px;">Alamat</p>
		<p style="margin-top: -10px;color:#666"><?php echo userinfo()->address?></p>

		<p style="font-weight: 600;margin-top: 15px;">Kecamatan</p>
		<p style="margin-top: -10px;color:#666"><?php echo userinfo()->district?></p>

		<p style="font-weight: 600;margin-top: 15px;">Kabupaten / Kota</p>
		<p style="margin-top: -10px;color:#666"><?php echo userinfo()->state?></p>

		<p style="font-weight: 600;margin-top: 15px;">Provinsi</p>
		<p style="margin-top: -10px;color:#666"><?php echo userinfo()->province?></p>

		<p style="font-weight: 600;margin-top: 15px;">Kode Pos</p>
		<p style="margin-top: -10px;color:#666"><?php echo userinfo()->zip_code?></p>

		<p style="font-weight: 600;margin-top: 15px;">E-mail</p>
		<p style="margin-top: -10px;color:#666"><?php echo userinfo()->email?></p>

		<p style="font-weight: 600;margin-top: 15px;">Nomor Telephone</p>
		<p style="margin-top: -10px;color:#666"><?php echo userinfo()->phone_number?></p>

	</div>


<a style="color:#434343;" href="<?php echo HomeUrl()?>/clientarea/pengaturan_profile">
<div style="border:1px #ccc solid;border-radius: 5px;padding:10px;text-align: center;background: #fff;font-size:17px;margin-top:10px;">
Rubah Profile
</div>
</a>

<a style="color:#fff;" href="<?php echo HomeUrl()?>/adminpanel/logout">
<div style="border:1px #fe4c50 solid;border-radius: 5px;padding:10px;text-align: center;background: #fe4c50;font-size:17px;margin-top:10px;">
Keluar
</div>
</a>

