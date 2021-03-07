<?php

$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."'  and user_id='".userinfo()->user_id."' ");
$show  = $query->fetch();

if($query->rowCount() == 0){

	header("location:".HomeUrl()."/clientarea/daftar_transaksi");
	exit;
}

$product = $this->db()->query("SELECT * FROm db_product WHERE product_id='".$show['product_id']."' ");
$product = $product->fetch();

$picture = json_decode($product['picture']);

$shipping_data = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."' ");
$shipping_data = $shipping_data->fetch();

$destination = $this->db()->query("SELECT * FROM db_destination_address WHERE id='".$show['destination']."'");
$destination = $destination->fetch();

$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$show['pay_with']."' ");
$bank = $bank->fetch();

$cancel_order = $this->db()->query("SELECT * FROM db_cancel_order WHERE order_id='".$this->get("id")."'");
$show_cancel_order = $cancel_order->fetch();

if(!isset($show_cancel_order['status'])) $show_cancel_order['status'] = null;

$total_price = $show['total_order'] * $show['price'];
$total_cost = $total_price + $shipping_data['price'];
$pay_method = $total_cost;
$total_cost = number_format($total_cost);
$total_price = number_format($total_price);

$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$product['category']."' ");

$category = $category->fetch();

if(empty($show['resi_number'])) $show['resi_number'] = " Belum Tersedia";


if(empty($show['note_order'])) $show['note_order'] = "Tidak ada catatan";

if(($show['status'] == 0)) $status = "Menunggu Pembayaran";
elseif(($show['status'] == 1)) $status = "Menunggu Konfirmasi";
elseif(($show['status'] == 2)) $status = "Pesanan Diproses";
elseif(($show['status'] == 3)) $status = "Pesanan Telah Dikirim";
elseif(($show['status'] == 4)) $status = "Pesanan Telah Tiba";
elseif(($show['status'] == 5)) $status = "Melakukan Komplain";
elseif(($show['status'] == 8)) $status = "Pesanan Selesai";
elseif(($show['status'] == 9)) $status = "Pesanan Dibatalkan";

$order_pending = $this->db()->query("SELECT * FROM db_order_pending WHERE order_id='".$this->get("id")."'  and user_id='".userinfo()->user_id."' ");
$order_pending = $order_pending->rowCount();

$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE invoice_id='".$show['invoice_id']."' ");
$wallet = $wallet->fetch();
$wallet['saldo'] = $wallet['saldo'] - $wallet['saldo'] - $wallet['saldo'];

?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Periksan detail dari pesanan</i></p>

<table width="100%">
	<tr>
		<td valign="top">
			<p style="font-size: 13px;color:#666;">Nomor Invoice</p>
			<p style="font-family: 'Segoe UI Bold';margin-top:-10px;color:#434343">#<?php echo $show['invoice_id']?></p>

			<p style="font-size: 13px;color:#666;">Status</p>
			<p style="font-family: 'Segoe UI Bold';margin-top:-10px;color:#434343"><?php echo $status?></p>


			<p style="font-size: 13px;color:#666;">Tanggal Pembelian</p>
			<p style="font-family: 'Segoe UI Bold';margin-top:-10px;color:#434343"><?php echo date("d M Y H:i",$show['start_time'])?> WIB</p>
		</td>


		<td valign="top" style="width: 450px;">
			
			<p style="font-family: 'Segoe UI Regular';font-size: 13px;float: left;width: 70px;margin-right:10px">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:60px;height:60px;border:1px #ddd solid;border-radius: 5px;margin-top:10px;">
					</p>

					<p style="font-family: 'Segoe UI Regular';font-size: 13px;float: left;">
						<p style="font-size:16px;margin-top:25px;"><a style="color:#09f;font-family: 'Segoe UI Bold';" href="<?php echo HomeUrl()."/".url_title($category['title'],"-",true)?>/<?php echo url_title($product['title'],"-",true)?>?id=<?php echo $product['sorting_id']?>"><?php echo $product['title']?></a></p>
						<p style="color:orangered;margin-top:-10px;font-size: 13px;">Rp <?php echo number_format($show['price'])?><span style="color:#666;font-size:12px;margin-left:5px;">x <?php echo $show['total_order']?> Product ( <?php echo number_format($product['weight'])?> Gr )</span></p>
						
					</p>

					<p style="float: left;width: 100%">
						<span style="font-size: 13px;color:#666">Catatan Untuk Penjual</span>
					</p>

					<p style="font-size: 14px;float: left;width: 90%;margin-top:-5px;border-radius: 5px;"><i><?php echo $show['note_order']?></i></p>

					

		</td>

		<td valign="top" style="width: 150px;">
			<p style="font-family: 'Segoe UI Regular';font-size: 13px; margin-top:30px;">
				Total Belanja
			</p>
			<p style="font-family: 'Segoe UI Bold';font-size: 13px;margin-top:-5px;color:orangered">
				Rp <?php echo $total_price ?>
			</p>

			<p style="font-family: 'Segoe UI Regular';font-size: 13px;margin-top: 35px;">
				<a href="<?php echo HomeUrl()?>/clientarea/add_to_cart?id=<?php echo $product['sorting_id']?>"><button class="btn-white" style="width: 130px;border-radius: 5px;">Beli Lagi</button></a><br>

				<?php if($show['status'] <= 1){ ?>

					<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>

					<a href="<?php echo HomeUrl()?>/clientarea/konfirmasi_pembayaran?id=<?php echo $show['sorting_id']?>"><button class="btn-filter" style="width: 100%;font-size:14px;width:130px;margin-top:20px;font-family: 'Segoe UI Bold';cursor: pointer;background: orangered;color:#fff;border:1px orangered solid;">Bayar</button></a><br>

				<?php }} ?>

				<?php if((($show['status'] == 0) or ($show['status'] == 2)) and ($cancel_order->rowCount() == 0) and ($show_cancel_order['status'] < 1) ) { ?>
				<a href="<?php echo HomeUrl()?>/clientarea/batalkan_pesanan?id=<?php echo $show['sorting_id']?>"><button class="btn-filter" style="width: 100%;font-size:14px;width:130px;margin-top:20px;font-family: 'Segoe UI Bold';cursor: pointer;">Batalkan Pesanan</button></a><br>
				<?php } ?>


				<?php if(($show['status'] >= 3) and ($show['status'] < 8)) { ?>
				<a href="<?php echo HomeUrl()?>/clientarea/komplain_produk?id=<?php echo $show['sorting_id']?>"><button class="btn-white" style="width: 100%;background: orangered;border:1px orangered solid;border-radius: 5px;margin-top:20px;font-size:14px;width:130px">Komplain</button>
				</a>

				<br>
				<?php if(($show['status'] != 5)){ ?>
				<a onClick="return confirm('apakah anda yakin ?')" href="<?php echo HomeUrl()?>/clientarea/complete_order?id=<?php echo $show['sorting_id']?>"><button class="btn-white" style="width: 100%;border-radius: 5px;margin-top:20px;font-size:14px;width:130px;background: #15CD72;border:1px #15CD72 solid;">Selesai</button></a>
				<?php }
				} ?>

				
			</p>



		</td>
	</tr>
</table>

<?php if(($show['status'] < 3) and ($cancel_order->rowCount() > 0) and ($show['rec_cancel'] == 1)) { ?>
<div style="width: 97%;border:1px #ddd solid;background:#edeab4;border-radius: 3px;padding:10px;">
Pembatalan sedang kami proses maksimal dalam 1 x 24 Jam
</div>
<?php }elseif(($show_cancel_order['status'] == 2) and ($show['status'] < 3)){ ?>
<div style="width: 97%;border:1px #ddd solid;background:#f5d2ba;border-radius: 3px;padding:10px;">
	Pembatalan yang anda ajukan kami tolak karena alasan tertentu
</div>
<?php } ?>

<?php if(!empty($show['note_deal_complain'])){ ?>
<div style="width: 97%;border:1px #ddd solid;background:#f5d2ba;border-radius: 3px;padding:10px;">
	<span style="font-family: 'Segoe UI Bold';">Catatan Komplain : </span> <?php echo $show['note_deal_complain']?>
</div>
<?php } ?>

<p style="font-family: 'Segoe UI Bold';border-top:1px #ddd solid;padding: 10px;padding-left:0px;font-size: 14px;color:#434343">
	<img src="<?php echo sourceUrl()?>/media/ship.png" width="30" style="position: relative;top:10px;margin-right:10px;"> Informasi Pengiriman</p>
<table width="100%" style="margin-top: -10px;">
	<tr>

		<td>
			<img src="<?php echo sourceUrl()?>/img/<?php echo $shipping_data['code']?>.png" style="position: absolute;width: 60px;height:60px;border:1px #ddd solid;margin-top:17px;">
			<p style="margin-left: 80px;font-family: 'Segoe UI Bold';font-size: 14px;color:#434343">
				<?php echo $shipping_data['company_name']?> - <?php echo $shipping_data['service_name']?>
			</p>
			<p style="margin-left: 80px;font-family: 'Segoe UI Regular';font-size: 14px;color:#434343;margin-top:-5px;">
				No. Resi : <span style="color:#09f"><?php echo $show['resi_number']?></span>
			</p>
			<p style="font-family: 'Segoe UI Regular';font-size: 13px;margin-top: 35px;">
				Dikirim Kepada <span style="font-family: 'Segoe UI Bold';"><?php echo $show['nama_penerima']?></span></p>
			<p style="font-family: 'Segoe UI Regular';font-size: 13px;margin-top: -5px;">
			<?php echo $show['address']?>, <?php echo $show['district']?>
			, <?php echo $show['state']?>, <?php echo $show['zip_code']?>
			</p>

			<p style="font-family: 'Segoe UI Regular';font-size: 13px;margin-top: -5px;">
			<?php echo $show['province']?></p>

			<p style="font-family: 'Segoe UI Regular';font-size: 13px;margin-top: -5px;">
			Telp : <?php echo $show['phone_number']?></p>
		</td>
		<td valign="top">
			<p style="font-family: 'Segoe UI Regular';font-size: 13px;">
				Biaya Pengiriman
			</p>
			<p style="font-family: 'Segoe UI Bold';font-size: 13px;margin-top:-5px;color:orangered">


				<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo number_format($shipping_data['price'])?>
					<?php } else{ ?>
						Belum Ada
					<?php }?>
				
			</p>
		</td>
	</tr>
</table>

<p style="font-family: 'Segoe UI Bold';border-top:1px #ddd solid;padding: 10px;padding-left:0px;font-size: 14px;color:#434343">
	<img src="<?php echo sourceUrl()?>/media/pending.png" width="25" style="position: relative;top:6px;margin-right:10px;"> Pembayaran</p>
<table width="100%" style="margin-top: -10px;">
	<tr>
		<td valign="top" style="color:#666;font-size: 13px;">Total Harga Barang ( <?php echo $show['total_order']?> Barang )</td>
		<td valign="top" style="color:#434343;font-family: 'Segoe UI Bold';font-size: 13px;">Rp <?php echo $total_price ?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#666;font-size: 13px;">Total Ongkos Kirim ( <?php echo number_format($show['total_order'] * $product['weight'])?> Gr )</td>
		<td valign="top" style="color:#434343;font-family: 'Segoe UI Bold';font-size: 13px;">

			<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo number_format($shipping_data['price'])?>
					<?php } else{ ?>
						Belum Ada
					<?php }?>
				

			</td>
	</tr>
	<tr>
		<td valign="top" style="color:#666;font-size: 13px;padding-bottom:10px;">Total Pembayaran</td>
		<td valign="top" style="color:orangered;font-family: 'Segoe UI Bold';font-size: 13px;padding-bottom:10px;">
			
				<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo $total_cost ?>
					<?php } else{ ?>
						Belum Ada
					<?php }?>
			</td>
	</tr>
	<tr>
		<td valign="top" style="color:#666;font-size: 13px;border-top:1px #ddd solid;padding: 10px;padding-left:0px">Metode pembayaran</td>
		<td valign="top" style="border-top:1px #ddd solid;padding: 10px;padding-left:0px">

			<?php if(($show['wallet'] == 1) and ($wallet['saldo'] >= $pay_method)) { ?>

				<p style="font-size: 13px;font-family: 'Segoe UI Bold';color:#434343;margin-top: 5px;">Pembayaran Penuh Dengan Saldo Dompet Digital</p>

			<?php }elseif(($show['wallet'] == 1) and ($wallet['saldo'] < $pay_method)) { ?>

				<p style="font-size: 13px;font-family: 'Segoe UI Bold';color:#434343;margin-top: 5px;">Sebagian Dibayar Dengan Saldo Dompet Digital <span style="color:orangered;font-family: 'Segoe UI Bold'">Rp <?php echo number_format(($wallet['saldo']))?></span></p>

				<div style="background: #f5f5f5;padding: 5px;border:1px #ddd solid;border-radius: 5px;margin-top:10px;">
				<img src="<?php echo sourceUrl()?>/bank/<?php echo $bank['icon']?>" style="width: 75px;height:50px;border-radius:5px;border:1px #ddd solid;position: absolute;margin-top:7px;background: #fff;">
				<p style="margin-left:89px;font-size: 13px;font-family: 'Segoe UI Bold';color:#434343;margin-top: 5px;">Transfer <?php echo $bank['bank_name']?></p>
				<p style="margin-left:89px;margin-top:-10px;font-size: 13px;color:#434343">No. Rekening : 
					
					<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
					<?php echo $bank['bank_info']; } else echo "Belum Tersedia";?>
						
					</p>
				<p style="margin-left:89px;margin-top:-10px;font-size: 13px;color:#434343">Atas Nama : 
					<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
					<?php echo $bank['atas_nama']; }else echo "Belum Tersedia";?>
						
					</p>
				</div>

			<?php }else{ ?>
			<div style="background: #f5f5f5;padding: 5px;border:1px #ddd solid;border-radius: 5px;">
				<img src="<?php echo sourceUrl()?>/bank/<?php echo $bank['icon']?>" style="width: 75px;height:50px;border-radius:5px;border:1px #ddd solid;position: absolute;margin-top:7px;background: #fff;">
			<p style="margin-left:89px;font-size: 13px;font-family: 'Segoe UI Bold';color:#434343;margin-top: 5px;">Transfer <?php echo $bank['bank_name']?></p>
			<p style="margin-left:89px;margin-top:-10px;font-size: 13px;color:#434343">No. Rekening : 
				
				<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
				<?php echo $bank['bank_info']; } else echo "Belum Tersedia";?>
					
				</p>
			<p style="margin-left:89px;margin-top:-10px;font-size: 13px;color:#434343">Atas Nama : 
				<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
				<?php echo $bank['atas_nama']; }else echo "Belum Tersedia";?>
					
				</p>
			</div>
		<?php } ?>
		</td>
	</tr>
</table>






<p style="font-family: 'Segoe UI Bold';border-top:1px #ddd solid;padding: 10px;padding-left:0px;font-size: 14px;color:#434343">
	<img src="<?php echo sourceUrl()?>/media/cart.png" width="25" style="position: relative;top:6px;margin-right:10px;"> Status Pemesanan</p>

<div style="padding: 10px;">

	<?php

			$log_order = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$show['sorting_id']."' ORDER BY type ASC");

			$sum = 1;
			while($show_log = $log_order->fetch()){ 

				$order_type = $this->db()->query("SELECT * FROM db_order_type WHERE type='".$show_log['type']."' ");
				$order_type = $order_type->fetch();

				if($order_type['type'] == 0) {

					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Melakukan checkout barang</p>
							<p style='color:#666;font-size:13px;margin-top:-10px;'>Menunggu konfirmasi pembayaran</p>";

				}

				elseif($order_type['type'] == 1) {

					$show_prov = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Melakukan konfirmasi pembayaran</p>
							<p style='color:#666;font-size:13px;margin-top:-10px;'>Menunggu  verifikasi pembayaran</p>";

				}

				elseif($order_type['type'] == 2) {

					$show_verif = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Pembayaran sudah diverifikasi</p>
							<p style='color:#666;font-size:13px;margin-top:-10px;'>Pesanan akan segera di proses untuk dilakukan pengiriman</p>";

				}

				elseif($order_type['type'] == 3) {

					$show_item_send = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Pesanan Di proses ke jasa pengiriman</p>
							<p style='color:#666;font-size:13px;margin-top:-10px;'>Pesanan sudah diteruskan ke jasa pengiriman</p>";

				}

				elseif($order_type['type'] == 4) {

					$show_item_receive = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Pesanan tiba di tempat tujuan</p>";

				}

				elseif($order_type['type'] == 5) {

					$complain = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Anda mengajukan complain pembelian</p>";

				}

				elseif($order_type['type'] == 6) {

					$resolve = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Pesanan Resolve</p>
							<p style='color:#666;font-size:13px;margin-top:-10px;'>Pesanan anda akan di resolve</p>";

				}

				elseif($order_type['type'] == 7) {

					$refund = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Dana Direfund</p>
							<p style='color:#666;font-size:13px;margin-top:-10px;'>Dana akan di transfer kembali ke rekening yang anda gunakan dalam proses pembayaran sebelumnya</p>";

				}

				elseif($order_type['type'] == 8) {

					$refund = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Pesanan Selesia</p>
							<p style='color:#666;font-size:13px;margin-top:-10px;'>Transaksi selesai, dana akan diteruskan ke penjual</p>";

				}

				elseif($order_type['type'] == 9) {

					$refund = true;
					$msg = "<p style='font-size:13px;font-family: Segoe UI Bold;'>Pesanan Dibatalkan<p>";

				}

				else{

					$msg = null;

				}

				?>

				<div style="font-family: 'Segoe UI Regular';margin-bottom: 50px;border:1px #ddd solid;padding:10px;margin-bottom:10px;background: #f9f9f9">

					<p style="color:#434343;font-size:14px;"><?php echo date("d/m/Y H:i",$show_log['time'])?> WIB</p>
					<?php echo $msg?>

				</div>

			<?php $sum++;} ?>
</div>

