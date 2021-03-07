<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Lihat daftar produk yang kamu tandai</i></p>



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

				?>

					<div style="width: 20%;padding: 5px;float: left;">

						<div style="border-radius: 4px;box-shadow: 0 1px 6px 0 rgba(0,0,0,0.1);">
						<a href="<?php echo HomeUrl()."/".url_title($category['title'],"-",true)?>/<?php echo url_title($product['title'],"-",true)?>?id=<?php echo $product['sorting_id']?>">
						<img src="<?php echo sourceUrl()?>/content/<?php echo $picture[0]?>" style="width:100%;border-radius: 5px 5px 0 0;height:150px;">
						<p style="padding: 5px;height: 33px;overflow: hidden;margin-top:0px;font-size: 14px;font-weight: 400;color:rgba(49,53,59,0.96);font-family: 'Segoe UI Bold';"><?php echo $product['title']?></p>

						<p style="color:orangered;height:35px;padding: 5px;margin-top: -10px;font-size: 14px;font-family: 'Segoe UI Bold';"><?php echo $discount_price?></p>
						</a>

						<form method="POST" action="<?php echo HomeUrl()?>/clientarea/add_to_cart?id=<?php echo $product['sorting_id']?>">
						
						<input type="text" name="total" value="1" style="display: none;" id="total-order">

						<p style="padding: 5px;"><button type="submit" style="width: 80%;border-radius: 5px;" class="btn-white">Beli</button>

						<a href="<?php echo HomeUrl()."/clientarea/delete_whishlist?id=".$show['id']?>"><img src="<?php echo sourceUrl()?>/img/bin.png" style="width: 25px;top: 6px;position: relative;"></a>
						</p>

						</form>
						</p>
					</div>
						
					</div>
					

				<?php } }else{ ?>
				<div style="padding: 10px;text-align: center;height:283px">
					<img src="<?php echo sourceurl()?>/media/love.png" style="width: 150px;">
					<p style="font-family: 'Segoe UI Bold';">Tidak Ada Barang Yang Ditandai</p>
					<p style="color:#666;font-size:13px;margin-top:-5px;">Silahkan temukan barang yang ingin anda beli</p>
					<a href="<?php echo HomeUrl()?>"><button class="btn-white">Beli Barang</button></a>
				</div>
			<?php } ?>

		
	</div>
</div>


<?php if($rowcount !== 0) { ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_white_list","whishlist") ?>
	</div>
		
</div>
<?php } ?>