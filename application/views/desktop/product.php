<input type="text" value="<?php echo documentUrl()?>" id="my-link" style="background: transparent;color: transparent;border: transparent;position: absolute;">


	<div class="container single_product_container" style="margin-top: 110px;background: #fff;border:1px #ddd solid;">
		<div class="row">
			<div class="breadcrumbs d-flex flex-row align-items-center" style="padding: 10px;margin-bottom: 10px;">
					<ul>
						<li><a style="color:#fe4c50" href="<?php echo HomeUrl()?>">Home</a></li>
						<li><i class="fa fa-angle-right" aria-hidden="true" style="color:rgba(49,53,59,0.68)"></i><a style="color:#fe4c50" href="<?php echo HomeUrl()."/".url_title($this->get_category()->title,"-",true)?>"><?php echo $this->get_category()->title?></a></li>
						<li><i class="fa fa-angle-right" aria-hidden="true" style="color:rgba(49,53,59,0.68)"></i><a style="color:#fe4c50" href="<?php echo HomeUrl()."/".url_title($this->get_category()->title,"-",true)?>?sub_category=<?php echo url_title($this->get_sub_category()->title,"-",true)?>"><?php echo $this->get_sub_category()->title?></a></li>
						<li class="active" style="color:rgba(49,53,59,0.68)"><i class="fa fa-angle-right" aria-hidden="true"></i><?php echo $this->get_product()->title?></li>
					</ul>
				</div>
			<div class="col-lg-7" style="padding: 20px;">
				<div class="single_product_pics">
					<div class="row">
						<div class="col-lg-3 thumbnails_col order-lg-1 order-2">
							<div class="single_product_thumbnails">
								<ul>

									<?php 

									foreach ($this->show_product_picture() as $key => $value) { ?>
															
									<li <?php if($key == 0) echo 'class="active"';?> style="width: 80px;height:80px;">
										<img src="<?php echo sourceUrl()."/content/".$value?>" alt="" data-image="<?php echo sourceUrl()."/content/".$value?>" style="width: 80px;height:80px;padding:5px;border:1px #f5f5f5 solid;border-radius: 4px;">
									</li>

									<?php } ?>


								</ul>
							</div>
						</div>
						<div class="col-lg-9 image_col order-lg-2 order-1">
							<div class="single_product_image">
								<img src="<?php echo sourceUrl()."/content/".$this->show_product_picture()[0]?>" width="100%" style="height: 500px;border-radius: 10px;">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5" style="padding: 20px;">
				<div class="product_details">
					<div class="product_details_title">

						<?php 

						if(userinfo() !== false){
							$whitelist = $this->db()->query("SELECT * FROM db_white_list WHERE product_id='".$this->get_product()->sorting_id."' and user_id='".userinfo()->user_id."'");
							if($whitelist->rowCount() == 0) $w_active = null;
							else $w_active = "active";
						}

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
						<h3><?php echo $this->get_product()->title?></h3>
						<p style="font-size: 14px;"><span style="font-weight: 400;color:rgba(0,0,0,.54)">Terjual</span> <?php echo number_format($send_stock) ?> Produk&nbsp;&nbsp; · &nbsp;&nbsp;<?php echo number_format($this->page_view(false))?>x <span style="font-weight: 400;color:rgba(0,0,0,.54)">Dilihat</span>&nbsp;&nbsp; · &nbsp;&nbsp; <span style="font-weight: 400;color:rgba(0,0,0,.54)">Ditandai</span> <?php echo number_format($total_whitelist->rowCount())?> Orang</p>
					</div>

					<table>
						<tr>
							<td valign="top" style="width: 100px;"><span style="color:#666">Harga</span></td>
							<td><div class="product_price"><?php echo $discount_price?></div></td>
						</tr>
					</table>

					<table style="margin-top: 20px;">
						<tr>
							<td valign="top" style="width: 100px;"><span style="color:#666">Jumlah</span></td>
							<td valign="top">
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
		
								<div class="quantity_selector" style="width: 105px;margin-left:0px;">
									<span class="minus" onClick="return update_order(this)"><i class="fa fa-minus" aria-hidden="true"></i></span>
									<span id="quantity_value">1</span>

									<span class="plus" onClick="return update_order(this)"><i class="fa fa-plus" aria-hidden="true"></i></span>
								</div>

								<form method="POST" action="<?php echo HomeUrl()?>/clientarea/add_to_cart?id=<?php echo $this->get_product()->sorting_id?>">
								<input type="text" name="total" value="1" style="display: none;" id="total-order">

								<button class="red_button add_to_cart_button" style="color:#fff;font-weight: 600;border:1px #fe4c50 solid;cursor: pointer;">ADD TO CART</button>
								</form>

								<?php if(userinfo() !== false){ ?>
								<div class="product_favorite d-flex flex-column align-items-center justify-content-center <?php echo $w_active?>" p_id="<?php echo $this->get_product()->sorting_id?>" onClick="return favourit(this)"></div>
								<?php } ?>

							</td>
						</tr>
					</table>

					<table style="margin-top: 20px;">

						<tr>
							<td valign="top" style="width: 100px;"><span style="color:#666">Info Produk</span></td>
							<td>
								<span>Berat <b><?php echo number_format($this->get_product()->weight)?> Gram</b>&nbsp;&nbsp;  · &nbsp;&nbsp;Ukuran <b><?php echo ($this->get_product()->size)?></b></span>
							</td>

						</tr>
					</table>

					<table style="margin-top: 20px;">

						<tr>
							<td valign="top" style="width: 100px;"><span style="color:#666">Pengiriman</span></td>
							<td>
								
								<?php 

									$service = ["jne.png", "tiki.png", "pos.png"];

									foreach($service as $key => $val){ ?>

										<img src="<?php echo sourceUrl()?>/img/<?php echo $val?>" style="width:60px;border:1px #ddd solid;border-radius: 5px;margin-right: 10px;" >

									<?php }	?>

									
									<div class="product_sorting_container product_sorting_container_top" style="margin-top:20px;">
									<ul class="product_sorting">
										<li style="width: 205px;border-radius: 5px;">
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
									
									<div style="margin-top: 10px;"><span>Mulai Dari <b id="predict-price" style="color:#fe4c50">Rp 20.000</b></span></div>
								</div>
							</td>

						</tr>
					</table>
					
				
				</div>
			</div>
		</div>

	</div>

	<!-- Tabs -->

	<div class="tabs_section_container" style="margin-top:20px;border-bottom: transparent;">

		<div class="container" style="background: #fff;border:1px #ddd solid;">

			<div class="row">
				<div class="col">

					<div class="row">
						<div class="col-lg-12 desc_col" style="padding: 15px;">
							<div class="tab_title">
								<h4 style="border:transparent;color:#434343">Deskripsi Produk</h4>
								<div style="float:right;margin-top: -10px;">
									<ul class="product_sorting" style="position: relative;margin-right: -10px;margin-top:10px;">
											<li style="text-align: left;width: 140px;border-radius: 10px;">
												<span class="type_sorting_text">
													<img src="<?php echo sourceUrl()?>/media/share.png" width="20" style="margin-right:10px;"> Bagikan
												</span>
												<i class="fa fa-angle-down" ></i>
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

	<div class="container single_product_container" style="margin-top: -100px;padding:0px;">
		<?php 

			

			$query1 = $this->db()->query("SELECT * FROM db_product WHERE status=1 ORDER BY RAND() LIMIT 12");

			if($query1->rowCount() > 0){ ?>

				<div class="panel panel-default">
	  		<div class="panel-heading" style="background: #F2F3F7;float: left;z-index: 2;padding-left:0px;">Produk Lainnya
	  		</div>
	  		<div class="underline" style="width: 99.5%;border-top:4px solid #DCDEE3;margin-top:-21px;float: left;z-index: 1"></div>
	  		<ul class="list-container" style="margin-top: 60px;width: 100%;">

			<?php while($show = $query1->fetch()){

				$query = $this->db()->query("SELECT * FROM db_category WHERE id='".$show['category']."'");

  				$category = $query->fetch();

  				if(userinfo() !== false){

					$whishlist = $this->db()->query("SELECT user_id,product_id FROM db_white_list WHERE user_id='".userinfo()->user_id."' and product_id='".$show['sorting_id']."' ");
					$whishlist = $whishlist->fetch();

					if($whishlist > 0) $w_active = "active";
					else $w_active = null;

				}

				$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($show['title'],"-",true)."?id=".$show['sorting_id'];

				$picture = json_decode($show['picture']);

				$get_discount = $this->db()->query("SELECT * FROM db_product_discount WHERE product_id='".$show['sorting_id']."' ");

				$show_discount = $get_discount->fetch();

				$discount = null;
				$discount_price = "Rp ".number_format($show['price']);

				if($get_discount->rowCount() > 0){

					if((time() >= $show_discount['start_time']) and (time() < $show_discount['end_time'])){

						$total_discount = ceil(($show_discount['price'] * 100 / $show['price']));
						$discount_price = "Rp ".number_format($show['price'] - $show_discount['price'])."<br><span style='text-decoration:line-through;font-size:11px;color:#666'><span style='color:#999;font-weight:400'>Rp ".number_format($show['price'])."</span></span> <span style='font-size:11px;color:#434343;font-weight:400'>-".$total_discount."%</span>";
						
					}
				}

			?>

			<li style="width:175px;background: #fff;padding: 10px;margin: auto;margin-right:5.2px;margin-bottom:5px;">

			<?php if(userinfo() !== false){ ?>
			<div class="product_favorite d-flex flex-column align-items-center justify-content-center <?php echo $w_active?>" p_id="<?php echo $show['sorting_id']?>" onClick="return favourit(this)" style="height: 30px;width: 30px;background: #fff;border-radius: 100%;margin-bottom: -40px;margin-top:10px;margin-left: 10px;">
				
			</div>
			<?php } ?>

			<a href="<?php echo $url?>">
			<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:100%;height:150px;">
			<p style="padding: 10px;height: 55px;overflow: hidden;font-weight: 600"><?php echo $show['title']?></p>
			<p style="color:#fe4c50;padding: 10px;font-weight: 600;margin-top: -15px;height: 35px;"><?php echo $discount_price?></p>
			</a>
		
		</li>

		<?php }  ?>

		</ul>
  	</div>
			  

	<?php }?>
	</div>

	

