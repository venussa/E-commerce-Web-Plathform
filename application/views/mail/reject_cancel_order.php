<div style="width: 600px;border:1px #ddd solid;padding:10px;border-radius: 5px">
	<p><img src="<?php echo setting()->logo?>" width="120"></p>
	<h3 style="font-family: Arial">Pemberitahuan</h3>
	<p style="color:#666;font-family: Arial;font-size: 13px;">Hi <b><?php echo ucwords($user['first_name']." ".$user['last_name'])?></b>. Mohon maaf, pengajuan pembatalan <b><?php echo $order['invoice_id']?> "<?php echo $product['title']?>"</b> tidak dapat kami proses. Karena barang pesanan sudah kami teruskan ke jasa pengiriman.</p>

	<a target="_blank" href="<?php echo HomeUrl()."/clientarea/detail_pesanan"?>?id=<?php echo $this->get("id")?>" style="cursor:pointer;"><button style="background: #fe4c50;border:1px #fe4c50 solid;color:#fff;padding:10px;font-family: Arial;border-radius: 5px;cursor: pointer;">Lihat Status Pesanan</button></a>

	
	<p style="color:#666;font-size: 13px;border-top:1px #ddd solid;padding-top:15px;font-family: Arial">Email dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini. Jika butuh bantuan, gunakan halaman <a style="text-decoration: none;color:#fe4c50;font-family: Arial" href="<?php echo HomeUrl()?>/hubungi-kami">Hubungi Kami.</a></p>
</div>