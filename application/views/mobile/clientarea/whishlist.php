<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Produk Ditandai</p>



<div style="margin-top:20px;">

	<div class="list">

			<?php
			$paging = $this->pagination(false,"db_white_list","whishlist");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_white_list ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			$rowcount = $query->rowCount();

			if($rowcount !== 0){ 

				while($show = $query->fetch()){



				$product = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$show['product_id']."' ");
				$product = $product->fetch();

				$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$product['category']."' ");

				$category = $category->fetch();

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

				$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($product['title'],"-",true)."?id=".$product['sorting_id'];

				?>

					<div style="margin-bottom:5px;padding-left:0px;padding: 10px;border:1px #ccc solid;border-radius: 5px;">
						<div class="box-product" style="border-radius: 3px;overflow: hidden;background: #fff;">

							<a href="<?php echo $url?>" style="color:#434343">
							<img src="<?php echo sourceUrl()?>/content/<?php echo $picture[0]?>" style="width:70px;height:70px;position: absolute;border:1px #ddd solid;border-radius: 5px;">
							<p style="margin-top:-15px;margin-left:80px;padding: 10px;font-weight: 600"><?php echo $product['title']?></p>
							<p style="margin-left:80px;color:#fe4c50;padding: 10px;font-weight: 600;margin-top: -25px;"><?php echo $discount_price?></p>
							</a>

							<table width="100%">
							<tr>
							<td>
								<button type="submit" style="background: #fe4c50;border:1px #fe4c50 solid;width: 100%;border-radius: 5px;" class="btn-white">Beli</button>
							</td>
							<td style="width: 30px;">
								<a href="<?php echo HomeUrl()."/clientarea/delete_whishlist?id=".$show['id']?>"><img src="<?php echo sourceUrl()?>/img/bin.png" style="width: 25px;top: 3px;position: relative;left:5px;"></a>
							</td>
							</tr>
							</table>

						</div>
					</div>
					

				<?php } }else{ ?>
				<div style="padding: 10px;text-align: center;height:283px">
					<img src="<?php echo sourceurl()?>/media/love.png" style="width: 150px;">
					<p style="font-weight:600;">Tidak Ada Barang Yang Ditandai</p>
					<p style="color:#666;font-size:13px;margin-top:-5px;">Silahkan temukan barang yang ingin anda beli</p>
					<a href="<?php echo HomeUrl()?>"><button class="btn-white">Beli Barang</button></a>
				</div>
			<?php } ?>

		
	</div>
</div>


<?php if($rowcount !== 0) { ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_white_list","whishlist") ?>
	</div>
		
</div>
<?php } ?>