<div style="width: 600px;border:1px #ddd solid;padding:10px;border-radius: 5px">
	<p><img src="<?php echo setting()->logo?>" width="120"></p>
	<h3 style="font-family: Arial">Pemberitahuan</h3>
	<p style="color:#666;font-family: Arial;font-size: 13px;">Hi <b><?php echo ucwords($this->user()['first_name']." ".$this->user()['last_name'])?></b>. Pihak okoifish ingin memulai diskusi prihal komplain atas produk <b>"<?php echo $product['title']?>"</b> debgan nomor invoice <b><?php echo $order['invoice_id']?></b> yang anda ajukan.</p>

	<a target="_blank" href="<?php echo HomeUrl()."/clientarea/detail_komplein"?>?id=<?php echo $order['sorting_id']?>" style="cursor:pointer;"><button style="background: #fe4c50;border:1px #fe4c50 solid;color:#fff;padding:10px;font-family: Arial;border-radius: 5px;cursor: pointer;">Buka halaman diskusi</button></a>

	
	<p style="color:#666;font-size: 13px;border-top:1px #ddd solid;padding-top:15px;font-family: Arial">Email dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini. Jika butuh bantuan, gunakan halaman <a style="text-decoration: none;color:#fe4c50;font-family: Arial" href="<?php echo HomeUrl()?>/hubungi-kami">Hubungi Kami.</a></p>
</div>