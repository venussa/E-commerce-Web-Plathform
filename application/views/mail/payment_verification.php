<div style="width: 600px;border:1px #ddd solid;padding:10px;border-radius: 5px">
	<p><img src="<?php echo setting()->logo?>" width="120"></p>
	<h3 style="font-family: Arial">Pembayaran anda sudah kami verifiaksi</h3>
	<p style="color:#666;font-family: Arial;font-size: 13px;">Terimakasih sudah melakukan pembayaran menggunakan metode pembayaran 
	<?php if(!isset($res_wallet)){ echo "<b>Transfer ".$bank['bank_name']."</b>"; }else{ echo "<b>Saldo Dompet Digital</b>";} ?>
	berhasil.
</p>

	<table width="100%" style="background: #f5f5f5;padding: 10px;">
		<tr>
			<td valign="top" style="width: 300px;"><p style="font-weight: 600">Total Pembayaran</p>
				<?php if(isset($new_total)){ ?>
				<p style="font-size: 14px;color:#666">Rp <?php echo number_format($new_total)?></p>
				<?php }else{ ?>
				<p style="font-size: 14px;color:#666">Rp <?php echo number_format($total)?></p>
				<?php } ?>
			</td>
			<td valign="top"><p style="font-weight: 600">Nomor Invoice</p>
				<p style="font-size: 14px;color:#666"><?php echo $invoice?></p>
			</td>
			
		</tr>
		<tr>
			<td valign="top"><p style="font-weight: 600">Metode Pembayaran</p>

				<?php if(!isset($res_wallet)){ ?>
				<p><img src="<?php echo sourceurl()?>/bank/<?php echo $bank['icon']?>" width="70" height="30"></p>
				<p style="font-size: 14px;color:#666">Transfer <?php echo $bank['bank_name']?></p>
				<p style="font-size: 12px;color:#666">

					<?php if($this->post("wallet") == 1) echo "ID Transaksi : "; else echo "No. Rek : "; ?><?php echo $bank['bank_info']?> (<?php echo $bank['atas_nama']?>)<br>Code Bank : <b><?php echo $bank['code_bank']?></b></p>
				<?php }else{ ?>

				<p style="font-size: 14px;color:#666">Pembayaran Penuh Dengan Saldo Dompet Digital</p>
				<?php } ?>
			</td>
			<td valign="top"><p style="font-weight: 600">Waktu Pembayaran</p>
				<p style="font-size: 14px;color:#666"><?php echo date("d M Y, H:i")?> WIB</p>
			</td>
		</tr>
		<tr>
			<td valign="top"><p style="font-weight: 600">Produk Yang Dibeli</p>
				<p style="font-size: 14px;padding-right:10px;color:#666"><a href="<?php echo $url?>" target="_blank" style="text-decoration:none;color:orangered"><?php echo $product['title']?></a></p>
			</td>
		</tr>
	</table>

		<h3 style="font-family: Arial">Rincian Pesanan</h3>
	<table width="100%" style="background: #f5f5f5;padding: 10px;">
		<tr>
			<td valign="top" style="width: 300px;"><p style="font-weight: 600">Nama Barang</p>
			</td>
			<td valign="top"><p style="font-weight: 600">Jumlah</p>
			</td>
			<td valign="top"><p style="font-weight: 600">Harga</p>
			</td>
		</tr>
		<tr>
			<td valign="top" style="border-top:1px #ddd solid;border-bottom:1px #ddd solid;"><p style="font-size: 14px;padding-right:10px;color:#666"><a href="<?php echo $url?>" target="_blank" style="text-decoration:none;color:orangered"><?php echo $product['title']?></a></p></td>
			<td valign="top" style="border-top:1px #ddd solid;border-bottom:1px #ddd solid;"><p><?php echo $order['total_order']?></p></td>
			<td valign="top" style="border-top:1px #ddd solid;border-bottom:1px #ddd solid;"><p>Rp <?php echo number_format($order['price'])?></p></td>
		</tr>
		<tr>
			<td valign="top"></td>
			<td valign="top" style="color:#434343;">Total Harga Produk</td>
			<td valign="top" style="color:#434343;">Rp <?php echo number_format(($order['price']*$order['total_order']))?></td>
		</tr>
		<tr>
			<td valign="top"></td>
			<td valign="top" style="color:#434343;">Ongkos Kirim</td>
			<td valign="top" style="color:#434343;">Rp <?php echo number_format($shipp['price'])?></td>
		</tr>
		<tr>
			<td valign="top"></td>
			<td valign="top" style="color:#000;font-weight: 600">Total Pembayaran</td>
			<td valign="top" style="color:orangered;">Rp <?php echo number_format($total)?></td>
		</tr>
	</table>

	<h3 style="font-family: Arial">Tujuan Kirim</h3>
	<div style="padding:10px;background: #f5f5f5">
		<p style="font-weight: 600;color:#434343"><?php echo $order['nama_penerima']?></p>
		<p style="font-size: 13px;color:#666;"><?php echo $order['address']?><br>
			<?php echo $order['district'].", ".$order['state'].", ".$order['zip_code']?><br>
			<?php echo $order['province']?><br>
			Telp: <?php echo $order['phone_number']?> </p>
	</div>
	<br>
	<br>
	<a target="_blank" href="<?php echo HomeUrl()."/clientarea/detail_pesanan"?>?id=<?php echo $this->get("id")?>" style="cursor:pointer;"><button style="background: #fe4c50;border:1px #fe4c50 solid;color:#fff;padding:10px;font-family: Arial;border-radius: 5px;cursor: pointer;">Cek Status Pesanan</button></a>
	<p style="color:#666;font-size: 13px;border-top:1px #ddd solid;padding-top:15px;font-family: Arial">Email dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini. Jika butuh bantuan, gunakan halaman <a style="text-decoration: none;color:#fe4c50;font-family: Arial" href="<?php echo HomeUrl()?>/hubungi-kami">Hubungi Kami.</a></p>
</div>