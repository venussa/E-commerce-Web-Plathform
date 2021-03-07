<input type="text" value="<?php echo documentUrl()?>" id="my-link" style="background: transparent;color: transparent;border: transparent;position: absolute;">


	<div class="container" style="margin-top: 53px;padding:0px;">


				<div style="width: 100%;">
				<div class="swiper-container" style="background: #fff;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);">
				    <div class="swiper-wrapper"  >
				     <?php

						foreach($this->show_product_picture() as $key => $value) { 
						
						$link = sourceUrl()."/content/".$value;

						?>

							<div class="swiper-slide" style="border-radius: 0px;overflow: hidden;padding: 0px;">
								<a href="<?php echo $link?>">
							  		<img src="<?php echo $link?>" alt="" style="height:250px;border-radius: 0px;">
								</a>
								
							</div>

						<?php } ?>

				    </div>
				    <!-- Add Arrows -->
				    <div class="swiper-button-next" style="color:#fff"></div>
				    <div class="swiper-button-prev" style="color:#fff"></div>
				    <div class="swiper-pagination"></div>
				  </div>
				</div>


				<?php 

				if(userinfo() !== false){
					$whitelist = $this->db()->query("SELECT * FROM db_white_list WHERE product_id='".$this->get_product()->sorting_id."' and user_id='".userinfo()->user_id."'");
					if($whitelist->rowCount() == 0) $w_active = null;
					else $w_active = "active";
				}?>


			<div style="padding:10px;background: #fff;border-bottom: 1px #ddd solid;">
				<div class="product_details">
					<div class="product_details_title" style="margin-top: -60px">

						<?php if(userinfo() !== false){ ?>
							<div style="border-radius: 100%;background: #fff;margin-top: -100px;position: absolute;z-index: 995;right:20px;width: 45px;height: 45px;-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);
-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);
box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);" class="product_favorite d-flex flex-column align-items-center justify-content-center <?php echo $w_active?>" p_id="<?php echo $this->get_product()->sorting_id?>" onClick="return favourit(this)"></div>
						<?php } ?>

						

						<?php
						$total_whitelist = $this->db()->query("SELECT * FROM db_white_list WHERE product_id='".$this->get_product()->sorting_id."' ");

						$send_stock = $this->db()->query("SELECT sum(total_order) as TotalOrder FROM db_orders WHERE product_id='".$this->get_product()->product_id."' and status > 1 and status != 9");

						$send_stock = $send_stock->fetch();
						$send_stock = (int) $send_stock['TotalOrder'];

						$stock = $this->get_product()->stock - $send_stock;

						$get_discount = $this->db()->query("SELECT * FROM db_product_discount WHERE product_id='".$this->get_product()->sorting_id."' ");

						$show_discount = $get_discount->fetch();

						$discount = null;
						$discount_price = "Rp ".number_format($this->get_product()->price);

						if($get_discount->rowCount() > 0){

							if((time() >= $show_discount['start_time']) and (time() < $show_discount['end_time'])){

								$total_discount = ceil(($show_discount['price'] * 100 / $this->get_product()->price));
								$discount_price = "Rp ".number_format($this->get_product()->price - $show_discount['price'])."<br><span style='text-decoration:line-through;font-size:11px;color:#666'><span style='color:#999;font-weight:400'>Rp ".number_format($this->get_product()->price)."</span></span> <span style='font-size:11px;color:#434343;font-weight:400'>-".$total_discount."%</span>";
								
							}
						}

						?>
						<h3 style="font-size: 20px;"><?php echo $this->get_product()->title?></h3>
						<p style="font-size: 13px;"><span style="font-weight: 400;color:rgba(0,0,0,.54)">Terjual</span> <?php echo number_format($send_stock) ?> Produk&nbsp;&nbsp; · &nbsp;&nbsp;<?php echo number_format($this->page_view(false))?>x <span style="font-weight: 400;color:rgba(0,0,0,.54)">Dilihat</span>&nbsp;&nbsp; · &nbsp;&nbsp; <span style="font-weight: 400;color:rgba(0,0,0,.54)">Ditandai</span> <?php echo number_format($total_whitelist->rowCount())?> Orang</p>
					</div>

					<table>
						<tr>
							<td valign="top" style="width: 100px;"><span style="color:#666;font-size: 13px;">Harga</span></td>
							<td valign="top"><div class="product_price" style="font-size: 20px;margin-top: -5px;"><?php echo $discount_price?></div></td>
						</tr>
					</table>

					<table style="margin-top: 20px;">
						<tr>
							<td valign="top" style="width: 100px;"><span style="color:#666">Jumlah</span></td>
							<td valign="top" style="font-size: 13px;">
								<?php if($stock < 1){ ?>
								<span style="color: #fe4c50">Barang Tidak Tersedia</span>
								<?php }else{ ?>
								<span>Tersedia Kurang dari <b><?php echo number_format($stock)?></b> Produk</span>
								<?php } ?>
							</td>
						</tr>
					</table>				

					<table style="margin-top: 20px;">

						<tr>
							<td valign="top" style="width: 100px;"></td>
							<td class="quantity d-flex flex-column flex-sm-row align-items-sm-center " style="margin-top: 0px;;">
		
								<div class="quantity_selector" style="width: 105px;margin-left:0px;border:1px #ccc solid;margin-top:0px">
									<span class="minus" onClick="return update_order(this)"><i class="fa fa-minus" aria-hidden="true"></i></span>
									<span id="quantity_value">1</span>

									<span class="plus" onClick="return update_order(this)"><i class="fa fa-plus" aria-hidden="true"></i></span>
								</div>

								<form method="POST" action="<?php echo HomeUrl()?>/clientarea/add_to_cart?id=<?php echo $this->get_product()->sorting_id?>">
								<input type="text" name="total" value="1" style="display: none;" id="total-order">

								<button class="red_button add_to_cart_button" style="color:#fff;font-weight: 600;border:1px #fe4c50 solid;cursor: pointer;">ADD TO CART</button>
								</form>

							

							</td>
						</tr>
					</table>

					<table style="margin-top: 20px;">

						<tr>
							<td valign="top" style="width: 100px; font-size: 13px;"><span style="color:#666">Info Produk</span></td>
							<td style="font-size: 13px;">
								<span>Berat <b><?php echo number_format($this->get_product()->weight)?> Gram</b>&nbsp;&nbsp;  · &nbsp;&nbsp;Ukuran <b><?php echo ($this->get_product()->size)?></b></span>
							</td>

						</tr>
					</table>

					<table style="margin-top: 20px;">

						<tr>
							<td valign="top" style="width: 100px;font-size: 13px;"><span style="color:#666">Pengiriman</span></td>
							<td>
								
								<?php 

									$service = ["jne.png", "tiki.png", "pos.png"];

									foreach($service as $key => $val){ ?>

										<img src="<?php echo sourceUrl()?>/img/<?php echo $val?>" style="width:60px;border:1px #ddd solid;border-radius: 5px;margin-right: 10px;" >

									<?php }	?>

									
									<div class="product_sorting_container product_sorting_container_top" style="margin-top:20px;margin-bottom: 20px;">
									<ul class="product_sorting">
										<li style="width: 205px;border-radius: 5px;border:1px #ccc solid">
											<span class="type_sorting_text loc-name">Select Location</span>
											<i class="fa fa-angle-down"></i>
											<ul class="sorting_type" style="border:1px #ddd solid;overflow-y: scroll;height: 200px;">
												<li class="type_sorting_btn" style="padding: 5px;margin-bottom: -40px;">
													<input type="text" name="destination" style="width: 100%;border:1px #ddd solid;background: #f5f5f5;border-radius: 5px;padding: 5px;height: 30px;font-size: 13px;" placeholder="Cari kabupaten" onkeyup="return select_location(this)">
												</li>
												<span id="data-location" ><?php echo $this->show_location() ?></span>
											</ul>
										</li>
									</ul>
									
									<div style="margin-top: 10px;font-size: 13px;"><span>Mulai Dari <b id="predict-price" style="color:#fe4c50">Rp 20.000</b></span></div>
								</div>
							</td>

						</tr>
					</table>
					
				
				</div>
			</div>
	

	</div>

	<!-- Tabs -->

	<div class="tabs_section_container" style="margin-top:6px;border-bottom: transparent;">

		<div class="container" style="background: #fff;border:1px #ddd solid;">

			<div class="row">
				<div class="col">

					<div class="row">
						<div class="col-lg-12 desc_col" style="padding: 15px;">
							<div class="tab_title">
								<h4 style="border:transparent;color:#434343">Deskripsi Produk</h4>
								<div style="float:right;margin-top: -10px;">
									<ul class="product_sorting" style="position: relative;margin-right: -10px;margin-top:10px;">
											<li style="text-align: left;width: 140px;border-radius: 10px;border:transparent;">
												<div class="type_sorting_text" style="float: right;border:1px #ccc solid;border-radius: 10px;width: 40px;height: 40px;">
													<img src="<?php echo sourceUrl()?>/media/share.png" width="24" style="margin-left:7px;margin-top:-2px;">
												</div>
												<ul class="sorting_type" style="border:1px #ddd solid;border-radius: 10px;margin-top:10px;padding-top: 10px;width: 140px;">

													

													<?php 

													$ln = "https://social-plugins.line.me/lineit/share?url=".urlencode(documentUrl())."&text=".urlencode($this->get_title());

													$fb = "https://www.facebook.com/sharer/sharer.php?u=".urlencode(documentUrl());

													$tw = "https://twitter.com/intent/tweet?text=".urlencode($this->get_title())."&url=".urlencode(documentUrl());

													?>
													
													<li class="type_sorting_btn" style="text-align:left;">
														<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $fb?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/fb.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
															Facebook
														</p>

														<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $tw?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/tw.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
															Twitter
														</p>

														<p style="font-weight: 400;font-size: 13px" onClick="window.open('<?php echo $ln?>','share','toolbar=0,status=0,width=550,height=400')"><img src="<?php echo sourceUrl()?>/media/ln.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
															Line
														</p>

														<p style="font-weight: 400;font-size: 13px" onClick="copy_link()"><img src="<?php echo sourceUrl()?>/media/link.png" style="width:20px;height:20px;border-radius: 5px;margin-right: 10px;">
															Salin Url
														</p>
													</li>

												</ul>
											</li>
										</ul>
									</div>
							</div>
							<div class="tab_text_block" style="margin-top:-80px;border-bottom: transparent;">
								<p style="margin-bottom: -100px;"><?php echo nl2br($this->get_product()->description)?></p>
							</div>
							
						</div>
					
					</div>

				</div>
			</div>


		</div>

	</div>

	<div class="container single_product_container" style="padding:0px;margin-top: -125px;margin-bottom: 50px;">
		<?php 

			$query = $this->db()->query("SELECT * FROM db_category WHERE id='".$this->get_product()->category."' ");

  			$category = $query->fetch();

  			$query1 = $this->db()->query("SELECT * FROM db_product WHERE category='".$category['id']."' and status=1 ORDER BY RAND() LIMIT 12");

  			if($query1->rowCount() > 0){ ?>

  				<div class="panel panel-default" style="background: #fff;border:1px #ddd solid;margin-bottom: -43px;">
		  		
		  		<p style="padding: 10px;font-size: 15px;"><img src="<?php echo sourceUrl()?>/website/<?php echo $category['img']?>" style="width: 28px;height: 28px;padding:3px;border:1px #ddd solid;border-radius: 100%;margin-right:10px;"> Produk Lainnya

		  		<a style="color: #fe4c50;float: right;font-size: 14px;border:none;margin-right: 10px;margin-top:2px;" href="<?php echo HomeUrl()."/".url_title($category['title'],"-",true)?>">Lihat Semua</a>
		  		</p>
		  	
		  		
		  		<div style="overflow-x:scroll; margin-top: -20px;margin-bottom:-10px;">
		  		<ul class="list-container conts" style="width: 100%;">

  			<?php while($show = $query1->fetch()){

  				$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($show['title'],"-",true)."?id=".$show['sorting_id'];

  				$picture = json_decode($show['picture']);

  				$get_discount = $this->db()->query("SELECT * FROM db_product_discount WHERE product_id='".$show['sorting_id']."' ");

				$show_discount = $get_discount->fetch();

				$discount = null;
				$discount_price = "Rp ".number_format($show['price']);

				if($get_discount->rowCount() > 0){

					if((time() >= $show_discount['start_time']) and (time() < $show_discount['end_time'])){

						$total_discount = ceil(($show_discount['price'] * 100 / $show['price']));
						$discount_price = "Rp ".number_format($show['price'] - $show_discount['price'])."<br><span style='text-decoration:line-through;font-size:9px;color:#666'><span style='color:#999;font-weight:400'>Rp ".number_format($show['price'])."</span></span> <span style='font-size:9px;color:#434343;font-weight:400'>-".$total_discount."%</span>";
						
					}
				}

  			?>

  			<li style="width:100px;padding: 0px;border: transparent;">

				<a href="<?php echo $url?>">
				<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:100px;height:100px;border:1px #ddd solid;border-radius: 10px">
				<p style="font-size:12px;padding: 10px;height: 51px;overflow: hidden;font-weight: 600"><?php echo $show['title']?></p>
				<p style="font-size:11px;color:#fe4c50;padding: 10px;font-weight: 600;margin-top: -15px;"><?php echo $discount_price?></p>
				</a>
			
			</li>

			<?php }  ?>

			</ul>
			</div>
	  	</div>
			  

	<?php }?>
	</div>

	

