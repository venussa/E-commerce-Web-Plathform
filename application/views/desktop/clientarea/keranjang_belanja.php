<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>lihat isi keranjang belanja</i></p>

<div style="margin-top:20px;">

	<div class="list">

			<?php
			$paging = $this->pagination(false,"db_cart","keranjang_belanja");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_cart ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			$rowcount = $query->rowCount();

			if($rowcount !== 0){ ?>

				<table width="100%">

					

				<?php while($show = $query->fetch()){

				$product = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$show['product_id']."' ");
				$product = $product->fetch();

				$picture = json_decode($product['picture']);

				$get_discount = $this->db()->query("SELECT * FROM db_product_discount WHERE product_id='".$product['sorting_id']."' ");

				$show_discount = $get_discount->fetch();

				$discount = null;
				$discount_price = "Rp ".number_format($product['price']);
				$product_price = $product['price'];

				if($get_discount->rowCount() > 0){

					if((time() >= $show_discount['start_time']) and (time() < $show_discount['end_time'])){

						$product_price = $product['price'] - $show_discount['price'];
						$total_discount = ceil(($show_discount['price'] * 100 / $product['price']));
						$discount_price = "Rp ".number_format($product['price'] - $show_discount['price'])."<br><span style='text-decoration:line-through;font-size:11px;color:#666'><span style='color:#999;font-weight:400'>Rp ".number_format($product['price'])."</span></span> <span style='font-size:11px;color:#434343;font-weight:400'>-".$total_discount."%</span>";
						
					}
				}

				$address_delivery = $this->db()->query("SELECT * FROM db_destination_address WHERE user_id='".userinfo()->user_id."' ORDER BY id DESC");
				$address_delivery = $address_delivery->fetch();

				$total_price0 = $product_price;
				
				if($show['total'] < 1) $total = 1;
				else $total = $show['total'];

				$total_price = number_format(($total_price0 * $total));

				$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$product['category']."'");
				$category = $category->fetch();

				$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($product['title'],"-",true)."?id=".$product['sorting_id'];

				?>

					<tr>

						<td valign="top" style="width: 110px;border-bottom: 1px #ddd solid;">
							<p style="margin-top: 23px;"><img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width: 90px;height:90px;border:1px #ddd solid;padding:2px;"></p>
						</td>

						<td valign="top" style="border-bottom: 1px #ddd solid;width: 300px;">

							
							
							<p style="font-size:16px;margin-top:20px;">
								<a href="<?php echo $url?>" style="font-family: 'Segoe UI Bold';color:#09f"><?php echo strip_tags($product['title'])?></a></p>
							<p style="color:orangered;font-family: 'Segoe UI Regular';font-size:13px;margin-top:-10px;"><?php echo $discount_price?>
								
								<span style="margin-left:10px;color:#666;font-size: 12px;font-family: 'Segoe UI Regular';">1 barang ( <?php echo $product['weight']?> gr )</span>
							</p>

							<p style="font-size:12px;"><span style="font-family: 'Segoe UI Bold';">Ukuran</span> : <?php echo $product['size']?></p>

							

							
						</td>

						


						<td style="border-bottom: 1px #ddd solid;">
							<p style="font-family: 'Segoe UI Regular';font-size: 13px;margin-top: 23px;">
						Total Harga Produk
					</p>
					<p id="cart-price-<?php echo $show['id']?>" data="<?php echo $total_price0?>" style="font-family: 'Segoe UI Bold';font-size: 13px;margin-top:-5px;color:orangered">
						Rp <?php echo $total_price ?>
					</p>
							<form method="POST" action="<?php echo HomeUrl()?>/clientarea/konfirmasi_pembelian">

							<p style="float:left">
						
								<input type="button" value="-" id="min-<?php echo $show['id']?>" onClick="set_minus(<?php echo $show['id']?>)" style="border: 1px #ddd solid;padding: 5px;border-radius:5px;width: 15px;width:40px;font-size:15px;cursor: pointer;">
								<input type="text" readonly="" id="cart-<?php echo $show['id']?>" name="jumlah" value="<?php echo $total?>" style="border: 1px #ddd solid;padding: 5px;border-radius:5px;width: 15px;width:30px;font-size:15px;text-align: center;color:#666">
								<input type="button"  value="+" id="plus-<?php echo $show['id']?>" onClick="set_plus(<?php echo $show['id']?>)" style="border: 1px #ddd solid;padding: 5px;border-radius:5px;width: 15px;width:40px;font-size:15px;cursor: pointer;">

								<input type="text" name="product_id" value="<?php echo $show['product_id']?>" style="display: none;">
								<input type="text" name="cart_id" value="<?php echo $show['id']?>" style="display: none;">
								<input type="text" name="address_id" value="<?php echo $address_delivery['id']?>" style="display: none;">
								

							</p>
							<p style="float:left;width: 150px;">
								
								<button class="btn-white" type="submit" style="color:#fff;font-size:15px;margin-left:30px;width: 100px;border-radius: 5px;">Lanjut Beli</button>
							</p>

							<p style="float:right">

								<img src="<?php echo sourceurl()?>/media/trash.png" onClick="if(confirm('Yakin mau menghapusnya') == true) window.location='<?php echo HomeUrl()."/clientarea/delete_cart?id=".$show['id']?>';" style="width: 30px;cursor:pointer">
							</p>

						</form>

						</td>
					</tr>
					

				<?php }  ?>

				</table>

				

			<?php }else{ ?>
				<div style="padding: 10px;text-align: center;height:283px">
					<img src="<?php echo sourceurl()?>/img/cart.png" style="width: 150px;">
					<p style="font-family: 'Segoe UI Bold';">Tidak Ada Barang di Keranjang</p>
					<p style="color:#666;font-size:13px;margin-top:-5px;">Silahkan temukan barang yang ingin anda beli</p>
					<a href="<?php echo HomeUrl()?>"><button class="btn-white">Beli Barang</button></a>
				</div>
			<?php } ?>

		
	</div>
</div>


<?php if($rowcount !== 0) { ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_cart","keranjang_belanja") ?>
	</div>
		
</div>
<?php } ?>