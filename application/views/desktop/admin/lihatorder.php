<?php
$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");	
$show = $query->fetch();

if($query->rowCount() == 0){

	header("location:".HomeUrl()."/adminpanel/orders");
	exit;
}


$product = $this->db()->query("SELECT * FROm db_product WHERE product_id='".$show['product_id']."' ");
$product = $product->fetch();

$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."' ");
$user = $user->fetch();

$shipping_data = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."' ");
$shipping_data = $shipping_data->fetch();

$total_price = $show['total_order'] * $show['price'];
$total_cost = $total_price + $shipping_data['price'];
$pay_method = $total_cost;
$total_cost = number_format($total_cost);
$total_price = number_format($total_price);

$shipping = $this->db()->query("SELECT * FROM db_destination_address WHERE id='".$show['destination']."'");
$shipping = $shipping->fetch();

$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$show['pay_with']."' ");
$bank = $bank->fetch();

$log_order = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$show['sorting_id']."' ORDER BY type ASC");

$log_order = $log_order->fetch();

$cancel_order = $this->db()->query("SELECT * FROM db_cancel_order WHERE order_id='".$this->get("id")."' ");
$show_cancel_order = $cancel_order->fetch();

$check_complain = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$show['sorting_id']."' and type='5' ORDER BY type ASC");


$delivery_service = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."'");
$delivery_service = $delivery_service->fetch();


if($show['handle_by'] > 0){

	$handle = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['handle_by']."' ");
	$handle = $handle->fetch();

}

if(empty($show['resi_number'])) $show['resi_number'] = " Belum tersedia";


$order_pendings = $this->db()->query("SELECT * FROM db_order_pending WHERE order_id='".$show['sorting_id']."' ");
$order_pending_show = $order_pendings->fetch();
$order_pending = $order_pendings->rowCount();

$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE user_id='".$user['id']."' and invoice_id='".$show['invoice_id']."' ");
$wallet = $wallet->fetch();
$wallet['saldo'] = $wallet['saldo'] - $wallet['saldo'] - $wallet['saldo'];


?>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px;font-style: italic;">"Halaman ini untuk mengetahui detail dari order yang masuk. Anda dapat memverifikasi order juga pada halaman ini"</p>

<div class="big-panel-box" style="margin-top:20px;">
<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/verifikasi_order?id=<?php echo $show['sorting_id']?>" enctype="multipart/form-data">
	<table width="100%" style="">

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Date Order</p>
				<p class="t2">* Tanggal Order</p>
			</td>
			<td>
				<p style="font-family: 'Segoe UI Regular';"><?php echo date("d/m/Y H:i",$log_order['time'])?></p>

			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Customer</p>
				<p class="t2">* Informasi Mengenai pembeli</p>
			</td>
			<td>
				<p style="font-family: 'Segoe UI Bold';"><?php echo ucwords($user['first_name']." ".$user['last_name'])?> <span style="color:#09f;font-size:13px;margin-left:6px;cursor: pointer;" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user['username']?>';">(@<?php echo $user['username']?>)</span></p>Email : </span><a href="mailto:<?php echo $user['email']?>" style="color:#09f"><?php echo $user['email']?></a></p>

			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Invoice</p>
				<p class="t2">* Nomor Id Pembayaran</p>
			</td>
			<td><p>#<?php echo $show["invoice_id"]?></p></td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Product</p>
				<p class="t2">* Informasi Mengenai Produk</p>
			</td>
			<td>
				<p style="font-family: 'Segoe UI Bold';color:#09f;cursor:pointer;" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/product?q=<?php echo $product['product_id']?>';"><?php echo $product['title']?></p>
				<p style="font-size:11px;"><span style="font-family: 'Segoe UI Bold';">Product Id : </span><?php echo $product['product_id']?></p>
				<p style="font-size:11px;color: orangered"><span style="font-family: 'Segoe UI Bold';color:#000">Price : </span>Rp <?php echo number_format($show['price'])?></p>

			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Shipping Address</p>
				<p class="t2">* Alamat Pengiriman</p>
			</td>
			<td>
				<p style="font-family: 'Segoe UI Bold';">
					<?php echo $show['address']?>,
					<?php echo $show['district']?>,
					<?php echo $show['state']?>,
					<?php echo $show['province']?>,
					<?php echo $show['zip_code']?>

						
					</p>
				<p style="font-size:11px;"><span style="font-family: 'Segoe UI Bold';">recipient's name : </span><?php echo $show['nama_penerima']?></p>
				<p style="font-size:11px;"><span style="font-family: 'Segoe UI Bold';">Phone Number : </span><?php echo $show['phone_number']?></p>

			</td>
		</tr>

		<?php if(!empty(strip_tags($show['note_order']))){?>
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Catatan Pembeli</p>
				<p class="t2">* catatan khusus dari pembeli</p>
			</td>
			<td>
				<?php echo strip_tags($show['note_order'])?>
			</td>
		</tr>
		<?php } ?>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Jasa Pengiriman</p>
				<p class="t2">* Jasa yang digunakan untuk mengirim barang</p>
			</td>
			<td>
				<img src="<?php echo sourceUrl()."/img/".$delivery_service['code'].".png"?>" style="width: 50px;position: absolute;">
				<p style="font-family: 'Segoe UI Bold';margin-left:60px;margin-top:0px;"><?php echo $delivery_service['company_name']?></p>
				<p style="margin-left: 60px;color:#666;font-size:12px;margin-top:-5px;">Nama Paket : <?php echo $delivery_service['service_description']." (".$delivery_service['service_name']." )"?></p>
				<p style="margin-left: 60px;color:#666;font-size:12px;margin-top:-9px;">Nomor Resi : <span style="color: #09f"><?php echo $show['resi_number']?></span></p>
				<p style="margin-left: 60px;color:#666;font-size:12px;margin-top:-9px;">Lama Kirim : <?php echo($delivery_service['time'] - 2)?> - <?php echo $delivery_service['time']?> Hari</p>
			</td>
		</tr>

		<?php if(($wallet['saldo'] > 0) and ($show['wallet'] == 1) and ($wallet['saldo'] >= $pay_method)) { ?>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Metode Pembayaran</p>
				<p class="t2">* Meotde pembayaran yang di gunakan</p>
			</td>
			<td >
				<p><span style="font-family: 'Segoe UI Bold';font-size:13px;color:#000;">Bayar penuh dengan saldo Dompet Digital</span><br>
					<span style="font-family: 'Segoe UI Regular';font-size:13px;color:#000;">ID Transaksi : <?php echo $wallet['tf_id']?></span>
				</p>
			</td>
		</tr>

		<?php }elseif(($wallet['saldo'] > 0) and ($show['wallet'] == 1) and ($wallet['saldo'] < $pay_method)){?>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Metode Pembayaran</p>
				<p class="t2">* Meotde pembayaran yang di gunakan</p>
			</td>
			<td >
				<p><span style="font-family: 'Segoe UI Bold';font-size:13px;color:#000;">Bayar sebagian dengan saldo Dompet Digital</span><br>
					<span style="font-family: 'Segoe UI Regular';font-size:13px;color:#000;">ID Transaksi : <?php echo $wallet['tf_id']?></span><br>
					<span style="font-family: 'Segoe UI Regular';font-size:13px;color:orangered;">Rp <?php echo number_format(($wallet['saldo']))?></span><br>
					Sisa yang belum dibayar : <span style="font-family: 'Segoe UI Regular';font-size:13px;color:orangered;">Rp <?php echo number_format(($pay_method - $wallet['saldo']))?></span>
				</p>
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Bank Transfer</p>
				<p class="t2">* Transfer ke rekening</p>
			</td>
			<td onclick="window.location='<?php echo HomeUrl()?>/adminpanel/bank?q=<?php echo explode(" ",$bank['bank_name'])[1]?>';">
				<img src="<?php echo sourceUrl()?>/bank/<?php echo $bank['icon']?>" style="width:80px;height:40px;border:1px #ddd solid;border-radius: 6px;padding: 2px;">
				<p style="font-family: 'Segoe UI Bold';color:#09f;cursor: pointer;"><?php echo $bank['bank_name']?> <span style="font-family: 'Segoe UI Bold';font-size:13px;color:#666;">(<?php echo $bank['bank_name']?>)</span></p>
			</td>
		</tr>
		<?php  }else{ ?>

			<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Bank Transfer</p>
				<p class="t2">* Transfer ke rekening</p>
			</td>
			<td onclick="window.location='<?php echo HomeUrl()?>/adminpanel/bank?q=<?php echo explode(" ",$bank['bank_name'])[1]?>';">
				<img src="<?php echo sourceUrl()?>/bank/<?php echo $bank['icon']?>" style="width:80px;height:40px;border:1px #ddd solid;border-radius: 6px;padding: 2px;">
				<p style="font-family: 'Segoe UI Bold';color:#09f;cursor: pointer;"><?php echo $bank['bank_name']?> <span style="font-family: 'Segoe UI Bold';font-size:13px;color:#666;">(<?php echo $bank['bank_name']?>)</span></p>
			</td>
		</tr>

			<?php } ?>
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Total Cost</p>
				<p class="t2">* Total biaya yang harus di bayar</p>
			</td>
			<td>
				<div style="background: #f5f5f5;border-radius: 3px;border:1px #ddd solid;">
					<p style="font-size:11px;border-bottom:1px #ddd solid;padding:10px;"><span style="font-family: 'Segoe UI Bold';">Total Order : </span><?php echo $show['total_order']?></p>
					<p style="font-size:11px;border-bottom:1px #ddd solid;padding:10px;"><span style="font-family: 'Segoe UI Bold';">Product Price : </span>Rp <?php echo number_format($show['price'])?></p>
					<p style="font-size:11px;border-bottom:1px #ddd solid;padding:10px;"><span style="font-family: 'Segoe UI Bold';">Total Price : </span>Rp <?php echo $total_price?></p>
					<p style="font-size:11px;border-bottom:1px #ddd solid;padding:10px;"><span style="font-family: 'Segoe UI Bold';">Shipping Cost : </span>
						<?php if(($product['transaction_scheme'] > 0) and ($order_pending == 0)) {
						echo "Belum Ada";
						}else{ ?>
						Rp <?php echo number_format($shipping_data['price'])?>

						<?php } ?>
					</p>
					<p style="font-size:11px;padding:10px;color:orangered;"><span style="font-family: 'Segoe UI Bold';">Total Cost : </span>
						<?php if(($product['transaction_scheme'] > 0) and ($order_pending == 0)) {
						echo "Belum Ada";
						}else{ ?>

						Rp <?php echo $total_cost?>
						<?php } ?>

					</p>
				</div>
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Order Status</p>
				<p class="t2">* Status Order Saat ini</p>
			</td>
			<td>

			<?php

			$log_order = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$show['sorting_id']."' ORDER BY type ASC");

			$sum = 1;
			while($show_log = $log_order->fetch()){ 

				$order_type = $this->db()->query("SELECT * FROM db_order_type WHERE type='".$show_log['type']."' ");
				$order_type = $order_type->fetch();

				if($order_type['type'] == 1) $show_prov = true;
				if($order_type['type'] == 2) $show_verif = true;
				if($order_type['type'] == 3) $show_item_send = true;
				if($order_type['type'] == 4) $show_item_receive = true;
				if($order_type['type'] == 5) $complain = true;
				if($order_type['type'] == 6) $resolve = true;
				if($order_type['type'] == 7) $refund = true;


				?>

				<p style="font-family: 'Segoe UI Regular';margin-bottom: 50px;">

				<button class="circle-progres-big" style="border: 2px <?php echo $order_type['color']?> solid;color:<?php echo $order_type['color']?>;"><b><?php echo $order_type['type']?></b></button>


				<?php
				if($sum < $log_order->rowCount()) { ?>
				<button class="vertical-line"></button>
			<?php } ?>

					<span style="font-family: 'Segoe UI Bold';margin-left:60px;">[<?php echo date("d/m/Y H:i",$show_log['time'])?>] </span> <?php echo $order_type['msg']?>
			
				</p>

			<?php $sum++;} ?>

			

			</td>
		</tr>

		<?php if(
			($product['transaction_scheme'] > 0) and 
			($order_pending == 0) and 
			(
				($cancel_order->rowCount() < 1) or 
				(
					(isset($show_cancel_order['status']) and $show_cancel_order['status'] > 1)
				)
			) and 
			$show['status'] < 9) { ?>
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Shipping Cost</p>
				<p class="t2">* Harga ongkos kirim barang</p>
			</td>
			<td>
				<input type="text" class="form-input" name="price">
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Weight</p>
				<p class="t2">* Berat barang setelah melakukan pengukuran ( Gram )</p>
			</td>
			<td>
				<input type="text" class="form-input" name="weight">
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;"></td>
			<td>
				<div style="margin-top:0px;margin-bottom: 10px;">
					<label class="cb-container"> Konfirmasi data yang anda input sudah benar
					  <input type="checkbox" name="verifikasi" value="set_price" required="">
					  <span class="checkmark"></span>
					</label>
				</div>
				<button class="btn-white">Verifikasi</button>
			</td>
		</tr>
		<?php } ?>

		<?php if(($product['transaction_scheme'] > 0) and ($order_pending > 0)) { ?>

			<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Shipping Cost</p>
				<p class="t2">* Harga ongkos kirim barang</p>
			</td>
			<td>
				<input type="text" class="form-input" disabled="" value="Rp <?php echo number_format($order_pending_show['price'])?>">
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Weight</p>
				<p class="t2">* Berat barang setelah melakukan pengukuran ( Gram )</p>
			</td>
			<td>
				<input type="text" class="form-input" disabled value="<?php echo number_format($order_pending_show['weight'])?> Gr">
			</td>
		</tr>

		<?php } ?>

		<?php if(($show['status'] >= 5) and ($show['status'] < 9) and ($check_complain->rowCount() > 0)){ ?>
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Complaine Message</p>
				<p class="t2">* Komplain yang di ajukan customer</p>
			</td>
			<td>
				
				<p style="background: #f9f9f9;border:1px orangered solid;border-radius: 4px;padding:5px;"><?php echo $show['note_complain']?></p>
				
				<?php if(($show['handle_by'] > 0) and ($show['status'] == 5)) { ?>
				<?php if($show['handle_by'] == userinfo()->user_id){ ?>

				<p style="color:#666;font-style: italic;">Komplain di tangani oleh <a style="font-family: 'Segoe UI Bold';color:#09f" href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $handle['username']?>"><?php echo ucwords($handle['first_name']." ".$handle['last_name'])?></a> ( Anda )</p>
				<p><a href="<?php echo HomeUrl()?>/adminpanel/message?chat_to=<?php echo $user['username']?>&action=complain&id=<?php echo $show['sorting_id']?>#<?php echo $user['username']?>"><button class="btn-white" type="button">Lihat Aktivitas</button></a></p>

				<?php }else{?>

				<p style="color:#666;font-style: italic;">Komplain di tangani oleh <a style="font-family: 'Segoe UI Bold';color:#09f" href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $handle['username']?>"><?php echo ucwords($handle['first_name']." ".$handle['last_name'])?></a></p>
				<p><a href="<?php echo HomeUrl()?>/adminpanel/message?chat_to=<?php echo $user['username']?>&action=complain&id=<?php echo $show['sorting_id']?>#<?php echo $user['username']?>"><button class="btn-white" type="button">Lihat Aktivitas</button></a></p>

				<?php }}elseif(($show['status'] == 5) and ($show['handle_by'] <= 0)){ 
				?>

				<p><a href="<?php echo HomeUrl()?>/adminpanel/message?chat_to=<?php echo $user['username']?>&action=complain&id=<?php echo $show['sorting_id']?>#<?php echo $user['username']?>"><button class="btn-white" type="button">Tangani Komplain</button></a></p>	
				
				<?php }elseif(($show['status'] > 5) and ($show['handle_by'] > 0)){ ?>

				<p style="color:#666;font-style: italic;">Komplain di tangani oleh <a style="font-family: 'Segoe UI Bold';color:#09f" href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $handle['username']?>"><?php echo ucwords($handle['first_name']." ".$handle['last_name'])?></a></p>
				<p style="color:green;font-style: italic;font-family: 'Segoe UI Bold';">Komplain Selesai</p>

				<p><a href="<?php echo HomeUrl()?>/adminpanel/message?chat_to=<?php echo $user['username']?>&action=complain&id=<?php echo $show['sorting_id']?>#<?php echo $user['username']?>"><button class="btn-white" type="button">Lihat Riwayat</button></a></p>

				<?php } ?>
			</td>
		</tr>

		<?php } ?>

		<?php if(isset($show_prov)){ ?>

			<?php if((($show['wallet'] == 1) and ($wallet['saldo'] < $pay_method)) or ($show['wallet'] == 0)) { ?>
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Proof of payment</p>
				<p class="t2">* Bukti Pembayaran Customer</p>
			</td>
			<td>
				<p style="font-family: 'Segoe UI Regular';"><span style="font-family: 'Segoe UI Bold';">Bank Name : </span><?php echo $show['your_bank_name']?></p>
				<p style="font-family: 'Segoe UI Regular';"><span style="font-family: 'Segoe UI Bold';">Rekening Number : </span><?php echo $show['your_rekening_number']?></p>
				<p style="font-family: 'Segoe UI Regular';"><span style="font-family: 'Segoe UI Bold';">A/N : </span><?php echo  $show['your_atas_nama']?></p>
				
				<?php $url = (sourceUrl()."/transfer/".$show['screenshot']);
				?>
				<a href="<?php echo HomeUrl()?><?php echo $url?>" onClick="MyWindow=window.open('<?php echo $url?>','MyWindow','width=1000,height=1000'); return false;"><img src="<?php echo $url?>" width="200"></a>
			</td>
		</tr>
	<?php } ?>

		

			<?php if((isset($show_prov)) and (!isset($show_verif)) and (($cancel_order->rowCount() == 0) or ($show_cancel_order['status'] == 2)) ) { ?> 

				<tr>
					<td class="tr" style="width: 200px;">
						<p class="t1">Verifikasi Pembayaran</p>
						<p class="t2">* Memastikan bahwa dana telah diterima</p>
					</td>
					<td>
						<div style="margin-top:30px;">

							<label class="cb-container"> check jika dana sudah masuk ke rekening
							  <input type="checkbox" name="verifikasi" value="pembayaran" required>
							  <span class="checkmark"></span>
							</label>

						</div>
					</td>
				</tr>

				<tr>
					<td class="tr" style="width: 200px;"></td>
					<td><button class="btn-white">Verifikasi</button></td>
				</tr>

			<?php }

			if(isset($show_verif)){ ?>

				<tr>
					<td class="tr" style="width: 200px;">
						<p class="t1">Verifikasi Pembayaran</p>
						<p class="t2">* Konfirmasi bahwa dana telah diterima</p>
					</td>
					<td>
						<div style="margin-top:30px;">
							<label class="cb-container"> Pembayaran terverifikasi
							  <input type="checkbox" checked disabled>
							  <span class="checkmark"></span>
							</label>
						</div>
						

					</td>
				</tr>

			<?php } ?>

			<?php if((isset($show_verif)) and (!isset($show_item_send)) and (($cancel_order->rowCount() == 0) or ($show_cancel_order['status'] == 2)) ) { ?>

				<tr>
					<td class="tr" style="width: 200px;">
						<p class="t1">Konfirmasi Pengiriman</p>
						<p class="t2">* Konfirmasi barang telah dikirim</p>
					</td>
					<td>
						<div style="margin-top:30px;">

							<label class="cb-container"> Check jika barang sudah dikirim
							  <input type="checkbox" name="verifikasi" value="pengiriman" required>
							  <span class="checkmark"></span>
							</label>

						</div>

						<p style="padding-top:10px;border-top:2px #ddd dashed;font-family: 'Segoe UI Bold';">Nomor Resi Jasa Expedisi</p>
						
						<textarea class="form-input" name="no_resi"></textarea>

					</td>
				</tr>

				<tr>
					<td class="tr" style="width: 200px;"></td>
					<td><button class="btn-white">Verifikasi</button></td>
				</tr>

			<?php }

			if(isset($show_item_send)){ ?>

				<tr>
					<td class="tr" style="width: 200px;">
						<p class="t1">Konfirmasi Pengiriman</p>
						<p class="t2">* Konfirmasi barang telah dikirim</p>
					</td>
					<td>
						<div style="margin-top:30px;">
							<label class="cb-container"> Barang sudah dikirim menggunakan jasa pengiriman
							  <input type="checkbox" checked disabled>
							  <span class="checkmark"></span>
							</label>
						</div>

					</td>
					</tr>

			<?php } ?>

			<?php if((isset($show_item_send)) and (!isset($show_item_receive)) ) { ?>

				<tr>
					<td class="tr" style="width: 200px;">
						<p class="t1">Konfirmasi Barang Diterima</p>
						<p class="t2">* Konfirmasi barang jika sudah sampai tujuan</p>
					</td>
					<td>

						<div style="margin-top:30px;">

							<label class="cb-container"> Check jika barang sudah diterima
							  <input type="checkbox" name="verifikasi" value="barang_sampai" required>
							  <span class="checkmark"></span>
							</label>
					</div>

					</td>
				</tr>

				<tr>
					<td class="tr" style="width: 200px;"></td>
					<td><button class="btn-white">Verifikasi</button></td>
				</tr>

			<?php } ?>


			<?php if(isset($show_item_receive)) { ?>

				<tr>
					<td class="tr" style="width: 200px;">
						<p class="t1">Konfirmasi Barang Diterima</p>
						<p class="t2">* Konfirmasi barang jika sudah sampai tujuan</p>
					</td>
					<td>

						<div style="margin-top:30px;">
							<label class="cb-container"> Barang sudah diterima
							  <input type="checkbox" checked disabled>
							  <span class="checkmark"></span>
							</label>
						</div>

					</td>
				</tr>

			<?php } ?>



			<?php if((isset($complain)) and ((isset($resolve)) or (isset($refund)) )){ ?>

					<tr>
					<td class="tr" style="width: 200px;">
						<p class="t1">Complain</p>
						<p class="t2">* Konfirmasi solusi complain yang di sepakati</p>
					</td>
					<td>
						<div style="margin-top:30px;">

							<label class="cb-container"> Resolve
							  <input type="checkbox" <?php if(isset($resolve)) echo "checked";?> disabled>
							  <span class="checkmark"></span>
							</label>
						
						</div>

						<div style="margin-top:30px;">
							<label class="cb-container"> Refund
							  <input type="checkbox" <?php if(isset($refund)) echo "checked";?> disabled>
							  <span class="checkmark"></span>
							</label>
						</div>

						<p style="padding-top:10px;border-top:2px #ddd dashed;font-family: 'Segoe UI Bold';">Catatan <span style="color:#666;font-size:11px;"> ( * Catatan hasil negosiasi dengan customer )</span></p>
						<textarea disabled class="form-input"><?php echo $show['note_deal_complain']?></textarea>

					</td>
					</tr>

			<?php } ?>


			


		<?php } ?>

		<?php if(($cancel_order->rowCount() > 0) and ($show_cancel_order['status'] == 0)){ ?>
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Cancel Order</p>
				<p class="t2">* Persetujuan Pengajuan Pembatalan</p>
			</td>
			<td>
				<div style="margin-top:30px;">
					<label class="cb-container"> Terima Pembatalan
					  <input type="checkbox" name="verifikasi" value="terima" class="cbx">
					  <span class="checkmark"></span>
					</label>
				</div>

				<div style="margin-top:30px;">
					<label class="cb-container"> Tolak Pembatalan
					  <input type="checkbox" name="verifikasi" value="tolak" class="cbx" checked="">
					  <span class="checkmark"></span>
					</label>
				</div>

				<p style="padding-top:10px;border-top:2px #ddd dashed;font-family: 'Segoe UI Bold';">Alasan Pembatalan</p>
				<textarea disabled class="form-input"><?php echo $show_cancel_order['note']?></textarea>
			</td>
		</tr>

		<tr>
			<td class="tr" style="width: 200px;"></td>
			<td><button class="btn-white">Verifikasi</button></td>
		</tr>
		<?php } ?>

			<?php if(($cancel_order->rowCount() > 0) and ($show_cancel_order['status'] > 0)){ ?>
		<tr>
			<td class="tr" style="width: 200px;">
				<p class="t1">Cancel Order</p>
				<p class="t2">* Persetujuan Pengajuan Pembatalan</p>
			</td>
			<td>

				<div style="margin-top:30px;">

					<label class="cb-container"> Terima Pembatalan
					  <input type="checkbox" disabled="" <?php echo $show_cancel_order['status'] == 1 ? "checked":""; ?>>
					  <span class="checkmark"></span>
					</label>

				</div>

				<div style="margin-top:30px;">

					<label class="cb-container"> Tolak Pembatalan
					  <input type="checkbox" disabled="" <?php echo $show_cancel_order['status'] == 2 ? "checked":""; ?>>
					  <span class="checkmark"></span>
					</label>

				</div>

				<p style="padding-top:10px;border-top:2px #ddd dashed;font-family: 'Segoe UI Bold';">Alasan Pembatalan</p>
				<textarea disabled class="form-input"><?php echo $show_cancel_order['note']?></textarea>
			</td>
		</tr>
		<?php } ?>

	</table>
</form>
</div>