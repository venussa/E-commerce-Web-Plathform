<?php
$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."'  and user_id='".userinfo()->user_id."' and status < 3");

$show  = $query->fetch();

if(($query->rowCount() == 0) or ($show['status'] == 1)){

	header("location:".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id"));
	exit;
}

$product = $this->db()->query("SELECT * FROm db_product WHERE product_id='".$show['product_id']."' ");
$product = $product->fetch();

$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$product['category']."' ");

$category = $category->fetch();

$picture = json_decode($product['picture']);

$shipping_data = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."' ");
$shipping_data = $shipping_data->fetch();

$destination = $this->db()->query("SELECT * FROM db_destination_address WHERE id='".$show['destination']."'");
$destination = $destination->fetch();

$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$show['pay_with']."' ");
$bank = $bank->fetch();

$cancel_order = $this->db()->query("SELECT * FROM db_cancel_order WHERE order_id='".$this->get("id")."' ");
$show_cancel_order = $cancel_order->fetch();

if(($cancel_order->rowCount() > 0) and (($show_cancel_order['status'] > 0) or ($show['rec_cancel'] > 0))) {

	header("location:".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id"));
	exit;
}


$total_price = $show['total_order'] * $show['price'];
$total_cost = $total_price + $shipping_data['price'];
$pay_method = $total_cost;
$total_cost = number_format($total_cost);
$total_price = number_format($total_price);

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

$order_pending = $this->db()->query("SELECT * FROM db_order_pending WHERE order_id='".$this->get("id")."'  and user_id='".userinfo()->user_id."' ");
$order_pending = $order_pending->rowCount();

$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE invoice_id='".$show['invoice_id']."' ");
$wallet = $wallet->fetch();
$wallet['saldo'] = $wallet['saldo'] - $wallet['saldo'] - $wallet['saldo'];

?>

<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Batalkan Pesanan</p>

<div class="big-panel-box" style="margin-top:10px;padding: 5px;width: 96%;background: #f5f5f5;border-radius: 5px;">
	<form method="POST" action="<?php echo HomeUrl()?>/clientarea/submit_cancel?id=<?php echo $this->get("id")?>">
	<p style="font-weight:600;">Alasan Melakukan Pembatalan</p>
	<textarea name="note" style="width: 97.3%;border-radius: 4px;border: 1px #ddd solid;" required=""></textarea>
	
		<p>
			<label class="cb-container"> Apakah anda yakin anda ingin membatalkan pemesanan barang ini?
			  <input type="checkbox" required="">
			  <span class="checkmark"></span>
			</label>
		</p>
		<button class="btn-white" type="submit" style="border-radius: 4px;width: 100%;background: #fe4c50;border:1px #fe4c50 solid;">Ajukan Pembatalan</button>
	</form>
</div>


<table width="100%">
	<tr>
		<td valign="top" colspan="2">
			<p style="font-size: 13px;color:#666;">Nomor Invoice</p>
			<p style="font-weight:600;margin-top:-10px;color:#434343">#<?php echo $show['invoice_id']?></p>

			<p style="font-size: 13px;color:#666;">Status</p>
			<p style="font-weight:600;margin-top:-10px;color:#434343"><?php echo $status?></p>


			<p style="font-size: 13px;color:#666;">Tanggal Pembelian</p>
			<p style="font-weight:600;margin-top:-10px;color:#434343"><?php echo date("d M Y H:i",$show['start_time'])?> WIB</p>
		</td>

	</tr>
	<tr>
		<td valign="top">
			
			<p style="font-size: 13px;width: 70px;margin-right:10px;position: absolute;">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:60px;height:60px;border:1px #ddd solid;border-radius: 5px;margin-top:10px;">
					</p>

			
						<p style="font-size:14px;margin-top:25px;margin-left: 70px"><a style="color:#434343;font-weight:600;" href="<?php echo HomeUrl()."/".url_title($category['title'],"-",true)?>/<?php echo url_title($product['title'],"-",true)?>?id=<?php echo $product['sorting_id']?>"><?php echo $product['title']?></a></p>
						<p style="color:orangered;margin-top:-10px;font-size: 13px;margin-left: 70px">Rp <?php echo number_format($show['price'])?><span style="color:#666;font-size:12px;margin-left:5px;">x <?php echo $show['total_order']?> Product ( <?php echo number_format($product['weight'])?> Gr )</span></p>
						
				

					<p style="width: 93%;border:1px #ddd solid;border-radius: 5px;background: #f5f5f5;padding: 10px;margin-top:20px">
						<span style="font-size: 13px;color:#666">Catatan Untuk Penjual</span><br>
						<i><?php echo $show['note_order']?></i></p>

					

		</td>
	</tr>
	<tr>
		<td valign="top" style="width: 150px;">
			<p style="font-size: 13px; margin-top:30px;">
				Total Belanja
			</p>
			<p style="font-weight:600;font-size: 13px;margin-top:-5px;color:orangered">
				Rp <?php echo $total_price ?>
			</p>

	



		</td>
	</tr>
</table>

<p style="font-weight:600;border-top:1px #ddd solid;padding: 10px;padding-left:0px;font-size: 14px;color:#434343">
	<img src="<?php echo sourceUrl()?>/media/ship.png" width="30" style="position: relative;top:10px;margin-right:10px;"> Informasi Pengiriman</p>
<table width="100%" style="margin-top: -10px;">
	<tr>

		<td>
			<img src="<?php echo sourceUrl()?>/img/<?php echo $shipping_data['code']?>.png" style="position: absolute;width: 60px;height:60px;border:1px #ddd solid;margin-top:17px;">
			<p style="margin-left: 80px;font-weight:600;font-size: 14px;color:#434343">
				<?php echo $shipping_data['company_name']?> - <?php echo $shipping_data['service_name']?>
			</p>
			<p style="margin-left: 80px;font-size: 14px;color:#434343;margin-top:-5px;">
				No. Resi : <span style="color:#09f"><?php echo $show['resi_number']?></span>
			</p>
			<p style="font-size: 13px;margin-top: 35px;">
				Dikirim Kepada <span style="font-weight:600;"><?php echo $show['nama_penerima']?></span></p>
			<p style="font-size: 13px;margin-top: -5px;">
			<?php echo $show['address']?>, <?php echo $show['district']?>
			, <?php echo $show['state']?>, <?php echo $show['zip_code']?>
			</p>

			<p style="font-size: 13px;margin-top: -5px;">
			<?php echo $show['province']?></p>

			<p style="font-size: 13px;margin-top: -5px;">
			Telp : <?php echo $show['phone_number']?></p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<p style="font-size: 13px;">
				Biaya Pengiriman
			</p>
			<p style="font-weight:600;font-size: 13px;margin-top:-5px;color:orangered">
				<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo number_format($shipping_data['price'])?>
					<?php } else{ ?>
						Belum Ada
					<?php }?>
			</p>
		</td>
	</tr>
</table>


<p style="font-weight:600;border-top:1px #ddd solid;padding: 10px;padding-left:0px;font-size: 14px;color:#434343">
	<img src="<?php echo sourceUrl()?>/media/pending.png" width="25" style="position: relative;top:6px;margin-right:10px;"> Pembayaran</p>
<table width="100%" style="margin-top: -10px;">
	<tr>
		<td valign="top" style="color:#666;font-size: 13px;">
			<p>Total Harga Barang ( <?php echo $show['total_order']?> Barang )</p>
		<p style="color:#434343;font-weight:600;font-size: 13px;">Rp <?php echo $total_price ?></p>
	</td>
	</tr>
	<tr>
		<td valign="top" style="color:#666;font-size: 13px;">
			<p>Total Ongkos Kirim ( <?php echo number_format($show['total_order'] * $product['weight'])?> Gr )</p>
		<p valign="top" style="color:#434343;font-weight:600;font-size: 13px;">

			<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo number_format($shipping_data['price'])?>
					<?php } else{ ?>
						Belum Ada
					<?php }?>
				
		</p>
			</td>
	</tr>
	<tr>
		<td valign="top" style="color:#666;font-size: 13px;padding-bottom:10px;">
			<p>Total Pembayaran</p>
		<p valign="top" style="color:orangered;font-weight:600;font-size: 13px;padding-bottom:10px;">
			
				<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo $total_cost ?>
					<?php } else{ ?>
						Belum Ada
					<?php }?>
				</p>
			</td>
	</tr>
	<tr>
		<td valign="top" style="color:#666;font-size: 13px;border-top:1px #ddd solid;padding: 10px;padding-left:0px">
			<p>Metode pembayaran</p>
	
			<?php if(($show['wallet'] == 1) and ($wallet['saldo'] >= $pay_method)) { ?>

				<p style="font-size: 13px;font-weight:600;color:#434343;margin-top: 5px;">Pembayaran Penuh Dengan Saldo Dompet Digital</p>

			<?php }elseif(($show['wallet'] == 1) and ($wallet['saldo'] < $pay_method)) { ?>

				<p style="font-size: 13px;font-weight:600;color:#434343;margin-top: 5px;">Sebagian Dibayar Dengan Saldo Dompet Digital <span style="color:orangered;font-weight:600">Rp <?php echo number_format(($wallet['saldo']))?></span></p>

				<div style="background: #f5f5f5;padding: 5px;border:1px #ddd solid;border-radius: 5px;margin-top:10px;">
				<img src="<?php echo sourceUrl()?>/bank/<?php echo $bank['icon']?>" style="width: 75px;height:50px;border-radius:5px;border:1px #ddd solid;position: absolute;margin-top:7px;background: #fff;">
				<p style="margin-left:89px;font-size: 13px;font-weight:600;color:#434343;margin-top: 5px;">Transfer <?php echo $bank['bank_name']?></p>
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
			<p style="margin-left:89px;font-size: 13px;font-weight:600;color:#434343;margin-top: 5px;">Transfer <?php echo $bank['bank_name']?></p>
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
