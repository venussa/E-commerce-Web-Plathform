<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Pembayaran Tertunda</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Daftar pembayaran yang belum dibayarkan, segera lakukan pembayaran sebelum batas waktu yang di tetapkan</i></p>

<div class="big-panel-box" style="margin-top:20px;float: none;">

	<div class="list">
		<table width="100%">
			<?php
			$paging = $this->pagination(false,"db_orders","pembayaran_tertunda");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_orders ".$paging->condition." ORDER BY sorting_id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:293px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/pending.png" style="width: 150px;">
						<p style="font-weight:600;font-size: 18px;">Tidak Ada Transaksi</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Cari dan temukan barang yang ingin kamu beli</p>
						<a href="<?php echo HomeUrl()?>"><button class="btn-white">Beli Barang</button></a>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

				$product = $this->db()->query("SELECT * FROm db_product WHERE product_id='".$show['product_id']."' ");
				$product = $product->fetch();

				$picture = json_decode($product['picture']);

				$shipping_data = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."' ");
				$shipping_data = $shipping_data->fetch();

				$total_price = $show['total_order'] * $show['price'];
				$total_cost = $total_price + $shipping_data['price'];
				$pay_method = $total_cost;
				$total_cost = number_format($total_cost);
				$total_price = number_format($total_price);

				$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$show['pay_with']."' ");
				$bank = $bank->fetch();

				$last_pay = $show['start_time'] + 86400;
				$last_pay = date("d F Y, H:i",$last_pay)." WIB";

				if(($show['status'] == 0)) $status = "Menunggu Pembayaran";
				elseif(($show['status'] == 1)) $status = "Menunggu Konfirmasi";
				elseif(($show['status'] == 2)) $status = "Pesanan Diproses";
				elseif(($show['status'] == 3)) $status = "Pesanan Telah Dikirim";
				elseif(($show['status'] == 4)) $status = "Pesanan Telah Tiba";
				elseif(($show['status'] == 5)) $status = "Melakukan Komplain";
				elseif(($show['status'] == 8)) $status = "Pesanan Selesai";
				elseif(($show['status'] == 9)) $status = "Pesanan Dibatalkan";

				$order_pending = $this->db()->query("SELECT * FROM db_order_pending WHERE order_id='".$show['sorting_id']."'  and user_id='".userinfo()->user_id."' ");
				$order_pending = $order_pending->rowCount();
				$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE invoice_id='".$show['invoice_id']."' ");
				$wallet = $wallet->fetch();
				$wallet['saldo'] = $wallet['saldo'] - $wallet['saldo'] - $wallet['saldo'];

				if(($show['wallet'] == 1) and ($wallet['saldo'] >= $pay_method)) { 
				$total_cost = $total_cost;
				}elseif(($show['wallet'] == 1) and ($wallet['saldo'] < $pay_method)) {
				$total_cost = number_format(($pay_method - $wallet['saldo']));
				}else{
				$total_cost = $total_cost;
				}


			?>

			<tr>
				<td valign="top" colspan="2" style="border: transparent;">
					<p style="font-size: 13px;">
						<span style="font-weight:600;">Nomor Invoice</span>
					</p>
					<p style="background: #f5f5f5;border-radius: 5px;border:1px #ddd solid;padding: 5px;font-size: 13px;">#<?php echo $show['invoice_id']?></p>

					<p style=";font-size: 13px;float: left;width: 70px;margin-right:10px">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:60px;height:60px;border:1px #ddd solid;border-radius: 5px;">
					</p>

					<p style=";font-size: 13px;float: left;">
						<p style="font-size:13px;margin-top:25px;"><a style="color:#434343;font-weight:600;" href="<?php echo HomeUrl()?>/clientarea/detail_pesanan?id=<?php echo $show['sorting_id']?>"><?php echo $product['title']?></a></p>
						<p style="color:orangered;margin-top:-10px;font-size: 13px;">Rp <?php echo number_format($show['price'])?> <span style="color:#666;font-size:12px;margin-left:15px;"><?php echo $show['total_order']?> Product ( <?php echo number_format($product['weight'] * $show['total_order'])?> Gr )</span></p>
						
						<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						<p style="background: #f5f5f5;border:1px #ddd solid;padding:5px;margin-top:30px;font-size:13px;border-radius: 4px;">Lakukan Pembayaran Sebelum <?php echo $last_pay?></p>
						<?php }else{ ?>
						<p style="background: #fff3d6;border:1px #ddd solid;padding:5px;margin-top:30px;font-size:13px;border-radius: 4px;">Informasi total pembayaran akan segera di proses, Mohon tunggu.</p>
						<?php } ?>
					
					</p>

				</td>
			</tr>
			<tr>

				<td valign="top" style="width: 200px;border-bottom: 1px #ccc solid;">
					<p style=";font-size: 13px;">Metode Pembayaran</p>
					
					<?php if(($show['wallet'] == 1) and ($wallet['saldo'] >= $pay_method)) { ?>
					<p style="font-weight:600;font-size: 13px;margin-top:-5px;">Saldo Dompet Digital</p>
					<?php }else{ ?>
					<p style="font-weight:600;font-size: 13px;margin-top:-5px;">Transfer <?php echo $bank['bank_name']?></p>
					<?php } ?>

					<p style=";font-size: 13px;margin-top: 30px;">
						Total Pembayaran
					</p>
					<p style="font-weight:600;font-size: 13px;margin-top:-5px;color:orangered">

						<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo $total_cost?>
					<?php } else{ ?>
						Belum Ada
					<?php }?>
					</p>
				</td>

				<td valign="top" style="width: 120px;border-bottom: 1px #ccc solid;">

			
					<?php if($show['status'] >= 2){  ?>

						<?php if(($show['wallet'] == 1) and ($wallet['saldo'] >= $pay_method)) { ?>

					<p style="font-size: 13px;border:1px #ddd solid;border-radius: 5px;width: 70px;text-align: center;">
						<img src="<?php echo sourceUrl()?>/media/wallet.png" style="width:40px;height:40px;">
					</p>
					<p style="color:green;font-style: italic;font-weight:600;">Telah Diverifikasi</p>
					<?php }else{ ?>
					<p style="font-size: 13px;">
						<img src="<?php echo sourceUrl()?>/bank/<?php echo $bank['icon']?>" style="width:70px;height:40px;border:1px #ddd solid;border-radius: 5px;">
					</p>
					<p style="color:green;font-style: italic;font-weight:600;">Telah Diverifikasi</p>
					<?php } ?>

					<?php }else{ ?>
					<p style=";font-size: 13px;margin-top: 35px;">
						<a href="<?php echo HomeUrl()?>/clientarea/konfirmasi_pembayaran?id=<?php echo $show['sorting_id']?>"><button class="btn-white" style="width: 100px;border-radius: 5px;background: #fe4c50;border:1px #fe4c50 solid;">Konfirmasi</button></a>

					</p>

					<?php } ?>
					
				</td>
				
				
				
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0) { ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_orders","pembayaran_tertunda") ?>
	</div>
		
</div>
<?php } ?>