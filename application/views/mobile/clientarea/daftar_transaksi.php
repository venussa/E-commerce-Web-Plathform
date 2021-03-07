<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Daftar Transaksi</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Daftar traksaksi yang anda lakukan</i></p>


<p style="font-weight:600;margin-right: 10px;">Filter By : </p>
<select id="month" class="tb-search" style="width: 100px;margin-right:5px;float:left;margin-bottom: 5px;border-radius: 5px;">
	
	<?php if(!empty($this->get("m"))){ ?>

		<option><?php echo $this->get("m")?></option>

	<?php }else{ ?>

		<option></option>

	<?php } ?>
	
	<?php for($i = 1; $i <= 12; $i++){ 

		if($this->get("m") !== monthConvert($i,1)){
		?>
		<option><?php echo monthConvert($i,1)?></option>
	<?php } }?>

</select>

<select id="years" class="tb-search" style="width: 100px;margin-right:5px;float:left;margin-bottom: 5px;border-radius: 5px;">
	<?php if(!empty($this->get("y"))){ ?>

		<option><?php echo $this->get("y")?></option>

	<?php }else{ ?>

		<option></option>
		
	<?php } ?>
	<?php for($i = 2019; $i <= date("Y")+1; $i++){ ?>

		<?php if($this->get("y") !== (String) $i) { ?>
		<option><?php echo $i?></option>

	<?php } } ?>
</select>
<button style="padding: 5px;width: 100px;border-radius: 5px;background: #fe4c50;border:1px #fe4c50 solid;float: right;" class="btn-white" onClick="order_filter('month','years','<?php echo $this->get("filter")?>')">Filter</button>

<div style="margin-top: 60px;overflow-x: scroll;">
<div style="width: 780px;padding: 10px;padding-left:0px;">
	<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi" class="<?php echo empty($this->get("filter")) ? "btn-filter-active" : "btn-filter";?>">Semua</a>

	<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi?filter=1&m=<?php echo $this->get("m")."&y=".$this->get("y")?>" class="<?php echo ($this->get("filter") == "1") ? "btn-filter-active" : "btn-filter";?>">Menunggu Konfirmasi</a>

	<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi?filter=2&m=<?php echo $this->get("m")."&y=".$this->get("y")?>" class="<?php echo ($this->get("filter") == "2") ? "btn-filter-active" : "btn-filter";?>">Diproses</a>

	<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi?filter=3&m=<?php echo $this->get("m")."&y=".$this->get("y")?>" class="<?php echo ($this->get("filter") == "3") ? "btn-filter-active" : "btn-filter";?>">Dikirim</a>

	<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi?filter=4&m=<?php echo $this->get("m")."&y=".$this->get("y")?>" class="<?php echo ($this->get("filter") == "4") ? "btn-filter-active" : "btn-filter";?>">Pesanan Tiba</a>

	<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi?filter=5&m=<?php echo $this->get("m")."&y=".$this->get("y")?>" class="<?php echo ($this->get("filter") == "5") ? "btn-filter-active" : "btn-filter";?>">Dikomplein</a>

	<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi?filter=8&m=<?php echo $this->get("m")."&y=".$this->get("y")?>" class="<?php echo ($this->get("filter") == "8") ? "btn-filter-active" : "btn-filter";?>">Selesai</a>

	<a href="<?php echo HomeUrl()?>/clientarea/daftar_transaksi?filter=9&m=<?php echo $this->get("m")."&y=".$this->get("y")?>" class="<?php echo ($this->get("filter") == "9") ? "btn-filter-active" : "btn-filter";?>">Dibatalkan</a>
</div>
</div>
<div style="height: 0px;"></div>
<div class="big-panel-box" style="margin-top:20px;width: 99%;float: none;">

	<div class="list">
		<table width="100%">

			<?php
			$paging = $this->pagination(false,"db_orders","daftar_transaksi");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_orders ".$paging->condition." ORDER BY sorting_id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:273px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/cart.png" style="width: 150px;">
						<p style="font-weight:600;font-size: 18px;">Tidak Ada Transaksi</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Cari dan temukan barang yang ingin kamu beli</p>
						<a href="<?php echo HomeUrl()?>"><button class="btn-white">Beli Barang</button></a>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

				$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$show['product_id']."' ");
				$product = $product->fetch();

				$picture = json_decode($product['picture']);

				$shipping_data = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."' ");
				$shipping_data = $shipping_data->fetch();

				$total_price = $show['total_order'] *$show['price'];
				$total_cost = $total_price + $shipping_data['price'];
				$total_cost = number_format($total_cost);
				$total_price = number_format($total_price);

				$order_pending = $this->db()->query("SELECT * FROM db_order_pending WHERE order_id='".$show['sorting_id']."'  and user_id='".userinfo()->user_id."' ");
				$order_pending = $order_pending->rowCount();


				if(($show['status'] == 0)) $status = "Menunggu Pembayaran";
				elseif(($show['status'] == 1)) $status = "Menunggu Konfirmasi";
				elseif(($show['status'] == 2)) $status = "Pesanan Diproses";
				elseif(($show['status'] == 3)) $status = "Pesanan Telah Dikirim";
				elseif(($show['status'] == 4)) $status = "Pesanan Telah Tiba";
				elseif(($show['status'] == 5)) $status = "Melakukan Komplain";
				elseif(($show['status'] == 8)) $status = "Pesanan Selesai";
				elseif(($show['status'] == 9)) $status = "Pesanan Dibatalkan";

			?>

			<tr>
				<td valign="top" colspan="2" style="border:transparent;">
					<p style="font-weight:600;font-size: 13px;">
						Nomor Invoice
					</p>

					<p style="font-size: 13px;margin-top:-5px;background: #f5f5f5;padding:5px;border-radius: 5px;border:1px #ddd solid;">
					#<?php echo $show['invoice_id']?>
					</p>

					<p style="font-size: 13px;width: 70px;margin-right:10px;position: absolute;">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:60px;height:60px;border:1px #ddd solid;border-radius: 5px;">
					</p>

				
						<p style="font-size:14px;margin-top:25px;margin-left: 80px;"><a style="color:#434343;font-weight:600;" href="<?php echo HomeUrl()?>/clientarea/detail_pesanan?id=<?php echo $show['sorting_id']?>"><?php echo $product['title']?></a></p>
						<p style="color:orangered;margin-top:-10px;font-size: 13px;margin-left: 80px;">Rp <?php echo number_format($show['price'])?> <span style="color:#666;font-size:12px;margin-left:15px;"><?php echo $show['total_order']?> Product ( <?php echo number_format($product['weight'] * $show['total_order'])?> Gr )</span></p>
						<p style="margin-top: 20px;font-size:13px;margin-left: 80px;"><a href="<?php echo HomeUrl()?>/clientarea/detail_pesanan?id=<?php echo $show['sorting_id']?>" style="color:#666"><img src="<?php echo sourceUrl()?>/media/cart.png" width="15"> Lihat Detail Pesanan</a></p>
					

				</td>
			</tr>
			<tr>

				<td valign="top" style="width: 200px;border-bottom:1px #ccc solid">
					<p style="font-size: 13px;">Status</p>
					<p style="font-weight:600;font-size: 13px;margin-top:-5px;"><?php echo $status?></p>

					<p style="font-size: 13px;margin-top: 30px;">
						Total Harga Produk
					</p>
					<p style="font-weight:600;font-size: 13px;margin-top:-5px;color:orangered">
						Rp <?php echo $total_price ?>
					</p>
				</td>

				<td valign="top" style="width: 120px;border-bottom:1px #ccc solid">

					<p style="font-size: 13px;">
						Total Belanja
					</p>
					<p style="font-weight:600;font-size: 13px;margin-top:-5px;color:orangered">
						<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo $total_cost?>
					<?php } else{ ?>
						Belum Ada
					<?php }?>
					</p>

					<p style="font-size: 13px;margin-top: 35px;">
						<a href="<?php echo HomeUrl()?>/clientarea/add_to_cart?id=<?php echo $product['sorting_id']?>"><button class="btn-white" style="width: 100px;border-radius: 5px;background: #fe4c50;border:1px #fe4c50 solid;">Beli Lagi</button></a>
					</p>
					
				</td>
				
				
				
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>


<?php if($query->rowCount() !== 0) { ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_orders","daftar_transaksi") ?>
	</div>
		
</div>
<?php } ?>