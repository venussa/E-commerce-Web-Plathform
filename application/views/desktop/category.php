
	<div class="container single_product_container" style="margin-top: 90px;">
		<div class="row">
			<div class="col">

				<!-- Breadcrumbs -->

				<div class="breadcrumbs d-flex flex-row align-items-center" style="border:1px #ddd solid;padding:10px;border-radius: 4px;box-shadow: rgb(224, 224, 224) 1px 1px 6px 1px;margin-bottom: 20px;margin-top: 20px;margin-bottom: 30px;background: #fff">
					<ul>
						<li><a style="color:#fe4c50" href="<?php echo HomeUrl()?>">Home</a></li>

						

						<li><i class="fa fa-angle-right" aria-hidden="true" style="color:rgba(49,53,59,0.68)"></i>
							<?php 

							if(splice(1) == "search"){ ?>

							<a href="<?php echo documentUrl()?>" style="color:#fe4c50">Search</a>

							<?php }elseif(!empty($this->get("sub_category"))) { ?>
							<a style="color:#fe4c50" href="<?php echo HomeUrl()."/".$this->get_category_list()["doc_uri"][splice(1)]?>"><?php echo $this->get_category_list()["title"][splice(1)]?></a>
							<?php }else{ ?>

							<a href="javascript:void(0)"><?php echo $this->get_category_list()["title"][splice(1)]?></a>

						<?php } ?>
						</li>

						
						<?php if((splice(1) !== "search") and (!empty($this->get("sub_category")))) { ?>
						<li><i class="fa fa-angle-right" aria-hidden="true" style="color:rgba(49,53,59,0.68)"></i><?php echo $this->get_category_list()["title"][$this->get("sub_category")]?></li>
						<?php }elseif((splice(1) !== "search") and (empty($this->get("sub_category")))) { ?>


						<?php }else{?>
						<li><i class="fa fa-angle-right" aria-hidden="true" style="color:rgba(49,53,59,0.68)"></i><a href="#"><?php echo stringLimit(strip_tags(urldecode(htmlspecialchars_decode($this->get("q")))),35, "...")?></a></li>
						<?php } ?>
						

					</ul>

					
					
				</div>

				<div style="float:right;margin-top: -80px;">
					<ul class="product_sorting" style="position: relative;">
							<li style="text-align: left;width: 140px;border:transparent;">
								<span class="type_sorting_text loc-name">
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
		</div>

		<div class="row">
			<div class="col-lg-3">

				<div style="padding: 10px;background: #fff;border-radius: 4px;border:1px #ddd solid;">

				<?php if(splice(1) !== "search"){ ?>
				<h5>Kategori Produk</h5>

				<div style="margin-top: 30px;">
				<?php 
				$query = $this->db()->query("SELECT * FROM db_category WHERE level=0");
				while($show = $query->fetch()){ 

					if(splice(1) == url_title($show['title'],"-",true)) $bold = "font-weight:600;color:#fe4c50"; 
					else $bold = "font-weight:400;color:rgba(0,0,0,.54)";



				?>
				<p>
					<a href="<?php echo HomeUrl()."/".url_title($show['title'],"-",true) ?>" style="border-bottom: transparent;font-size:15px;<?php echo $bold?>;padding: 10px;padding-left:0px;">
						<img src="<?php echo sourceUrl()."/website/".$show['img']?>" style="width:35px;height:35px;border-radius: 100%;margin-right: 10px;border:1px #ddd solid;padding:5px;">
						<?php echo $show['title']?>
					</a>
				</p>

				<?php 
				$query1 = $this->db()->query("SELECT * FROM db_category WHERE level=1 and sublevel='".$show['id']."'");
				while($show1 = $query1->fetch()){ 

					if($this->get("sub_category") == url_title($show1['title'],"-",true)) $bold1 = "font-weight:600;color:#fe4c50"; 
					else $bold1 = "font-weight:400;color:rgba(0,0,0,.54)";

				?>
				<p style="margin-left:20px;<?php echo (splice(1) !== url_title($show['title'],"-",true)) ? "display: none;":""; ?> ">
					<a href="<?php echo HomeUrl()?>/<?php echo url_title($show['title'],"-",true)?>?sub_category=<?php echo url_title($show1['title'],"-",true)?>" style="border-bottom: transparent;font-size:15px;<?php echo $bold1?>;padding: 10px;padding-left:7px;">
						<img src="<?php echo sourceUrl()."/media/c-right.png"?>" style="width:8px;border-radius: 100%;margin-right: 10px;">
						<?php echo $show1['title']?>
					</a>
				</p>
			
				<?php } ?>

			
				<?php } ?>
				</div>
				<div style="border-top:1px #ddd solid;height: 40px;margin-top: 40px;"></div>
				<?php } ?>

				
				<h5>Rentang harga</h5>

				<div style="margin-top: 30px;">
					<div style="width: 100%;border:1px #ddd solid;padding: 10px;border-radius: 10px;">
						<span style="font-size: 16px;">Rp</span> <input type="text" id="start_price" name="start_price" placeholder="Harga Minimum" style="border: transparent;background: transparent;width: 80%;margin-left:10px;" onKeyup="return typing(this)" value="<?php echo !empty($this->get("end_price")) ? number_format($this->get("start_price")) : ""?>">
					</div>

					<div style="width: 100%;border:1px #ddd solid;padding: 10px;border-radius: 10px;margin-top:10px;">
						<span style="font-size: 16px;">Rp</span> <input type="text" id="end_price" name="end_price" placeholder="Harga Maksimum" style="border: transparent;background: transparent;width: 80%;margin-left:10px;" onKeyup="return typing(this)" value="<?php echo !empty($this->get("end_price")) ? number_format($this->get("end_price")) : ""?>">
					</div>

				</div>

				<div style="border-top:1px #ddd solid;height: 40px;margin-top: 40px;"></div>
				<h5>Saring Ukuran</h5>

				<div style="margin-top: 30px;">

					<input type="hidden" id="doc_active" style="display: none;" value="<?php echo documentUrl()?>">

					<?php 

					$size = ["Semua Ukuran", "Kecil", "Sedang", "Besar"];
					$url = null;
					foreach($size as $key => $val){

						if(splice(1) !== "search")
						$url[] = "sub_category=".$this->get("sub_category");
						else
						$url[] = "q=".$this->get("q");

						$url[] = "size=".urlencode($val);

						if(!empty($this->get("start_price")) and !empty($this->get("end_price"))){
							$url[] = "start_price=".$this->get("start_price");
							$url[] = "end_price=".$this->get("end_price");
						}

						if(!empty($this->get("list")))
						$url[] = "list=".urlencode(str_replace(" ","_",$this->get("list")));

						$url = HomeUrl()."/".splice(1)."?".implode("&",$url); 

						?>

						<p>
							<label class="cb-container" style="font-weight: 400"> <?php echo $val?>
						  <input type="checkbox" name="kurir" class="check_kurir" url="<?php echo $url?>" <?php echo (urldecode($this->get("size")) == $val or ((empty($this->get("size"))) and ($key == 0))) ? "checked":""; ?>>
						  <span class="checkmark"></span>
						</label></p>

					<?php $url = null; }	?>

					

				</div>

				</div>

			</div>
			<div class="col-lg-9">
				<div>

					<?php

					$paging = $this->pagination(false,"db_product",splice(1));

					$offset = ($paging->page - 1) * $paging->dataperpage;

					$limit = $paging->dataperpage;

					$search_result  = $this->db()->query("SELECT * FROM db_product ".$paging->condition);
					$search_result = $search_result->rowCount();

					$search_limit  = $this->db()->query("SELECT * FROM db_product ".$paging->condition." LIMIT ".($limit * $paging->page));
					$search_limit  = $search_limit->rowCount();

					$query = $this->db()->query("SELECT * FROM db_product ".$paging->condition." LIMIT $offset,$limit");

					$response = $query->rowCount();

					if($query->rowCount() == 0){

						$query1 = $this->db()->query("SELECT * FROM db_product ORDER BY RAND() LIMIT 16");

					}

					if($query->rowCount() == 0){ ?>

					<div style="padding:10px;border-radius: 3px;border:1px #ddd solid;background: #fff">
						<table width="100%">
							<tr>
								<td style="width: 150px;">
									<img src="<?php echo sourceUrl()?>/media/404.png" width="100%">
								</td>
								<td>
									<p style="font-size: 25px;color:#434343">Maaf, Produk tidak ditemukan</p>
									<p style="margin-top:-15px;color:rgba(0,0,0,.54)">Coba kata kunci yang lain atau produk rekomendasi di bawah</p>
								</td>
							</tr>
							
						</table>
					</div>

					<h4 style="margin-top: 50px;font-size: 23px;margin-bottom: 30px;">Rekomendasi Untuk Anda</h4>

					<?php } 

					if($response > 0){ ?>

					<div class="col-lg-12" style="float: left;text-align: right;margin-bottom: 20px;">
						<p style="text-align: left;font-weight: 400;float: left;margin-top: 10px;font-size: 13px;"><span>Menampilkan <b><?php echo number_format($search_result)?></b> Produk Untuk 
							<b>"<?php 
								
								if(splice(1) == "search"){

									echo stringLimit(strip_tags(urldecode(htmlspecialchars_decode($this->get("q")))),20," ...");
								
								}elseif(!empty($this->get("sub_category"))){

									echo $this->get_category_list()["title"][$this->get("sub_category")];

								}else{

									echo $this->get_category_list()["title"][splice(1)];
								}

							?> "</b> ( <?php echo "<b>".number_format($search_limit)."</b>"?> dari <?php echo "<b>".number_format($search_result)."</b>"?> ) </span>
					</p>
						<span style="margin-right: 10px;font-weight: 600">Urutkan : </span>
						<ul class="product_sorting" style="margin-right: -30px;">
							<li style="text-align: left;width: 180px;border-radius: 10px;background: #fff;;border:1px #ddd solid;">
								<span class="type_sorting_text loc-name">
									<?php if(!empty($this->get("list"))){

										echo ucwords(str_replace("_"," ", $this->get("list")));

									}else echo "Terbaru";
									?>
								</span>
								<i class="fa fa-angle-down" style="margin-left: 10px;"></i>
								<ul class="sorting_type" style="border:1px #ddd solid;border-radius: 10px;margin-top:10px;padding-top: 10px;width: 180px;">
									<?php 

									$size = ["Terbaru", "Harga Tertinggi", "Harga Terendah"];

									foreach($size as $key => $val){

										if(splice(1) !== "search")
										$url[] = "sub_category=".$this->get("sub_category");
										else
										$url[] = "q=".$this->get("q");

										if(!empty($this->get("size")))
										$url[] = "size=".$this->get("size");

										if(!empty($this->get("start_price")) and !empty($this->get("end_price"))){
											$url[] = "start_price=".$this->get("start_price");
											$url[] = "end_price=".$this->get("end_price");
										}

										$url[] = "list=".urlencode(str_replace(" ","_",$val));

										$url = HomeUrl()."/".splice(1)."?".implode("&",$url); 



									?>

									<li class="type_sorting_btn" style="text-align:left;">
										<p><a href="<?php echo $url?>" style="border-bottom: transparent;font-size:13px;font-weight: 400">
											<?php echo $val?>
										</a></p>
									</li>
									<?php $url = null;} ?>

								</ul>
							</li>
						</ul>

					
					</div>


					<?php }

					if($query->rowCount()==0) $query = $query1;

					while($show = $query->fetch()){  

						$url = HomeUrl()."/".url_title($this->get_category_data($show['category'])->title,"-",true)."/".url_title($show['title'],"-",true)."?id=".$show['sorting_id'];

						if(userinfo() !== false){
							$check_mark = $this->db()->query("SELECT * FROM db_white_list WHERE user_id='".userinfo()->user_id."' and product_id='".$show['sorting_id']."' ");

							if($check_mark->rowCount() > 0) $w_active = "active";
							else $w_active = null;
						}

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

						
						<div class="col-md-3" style="float:left;margin-bottom:25px;padding-left:0px">
							<div class="box-product" style="border-radius: 3px;overflow: hidden;padding: 10px;background: #fff;">

							<?php if(userinfo() !== false){ ?>
								<div class="product_favorite d-flex flex-column align-items-center justify-content-center <?php echo $w_active?>" p_id="<?php echo $show['sorting_id']?>" onClick="return favourit(this)" style="position: absolute;height: 30px;width: 30px;background: #fff;border-radius: 100%;left:-0px;top:18px;">
									
								</div>
							<?php } ?>

								<a href="<?php echo $url?>">
								<img src="<?php echo sourceUrl()?>/content/<?php echo $picture[0]?>" style="width:100%;height:150px;">
								<p style="padding: 10px;height: 55px;overflow: hidden;font-weight: 600"><?php echo $show['title']?></p>
								<p style="color:#fe4c50;padding: 10px;font-weight: 600;margin-top: -15px;height:35px;"><?php echo $discount_price?></p>
								</a>
							</div>
						</div>




					<?php } ?>

		


					

				<?php if($response > 0){ ?>
				<div style="margin-top:0px;float: right;width: 100%">

					<div style="float: right;margin-top:-5px;">
						<?php echo $this->pagination(true,"db_product",splice(1)) ?>
					</div>
						
				</div>

			<?php } ?>

			</div>
		</div>
	</div>
</div>



