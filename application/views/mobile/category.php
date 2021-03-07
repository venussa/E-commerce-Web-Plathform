
	<div class="container" style="margin-top: 90px;padding: 0px">


			<div id="filter-search" style="position: fixed;z-index: 994;background: #fff;top:50px;overflow-y: scroll;right: 0px;left:0px;width: 100%;display: none;">

				<div id="filt-1" style="padding: 10px;margin-top: 20px;">
					<h5 style="margin-bottom: 20px;">Urutkan Produk <img src="<?php echo sourceUrl()?>/media/times.png" style="position: fixed;width:40px;height:40px;border-radius: 5px;padding: 5px;border:1px #ddd solid;right:20px;margin-top:-10px;z-index: 996;background: #fff" onClick="return menu_collapse()"></h5>
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


					<p style="border-bottom: 1px #ddd solid;padding: 10px;"><img src="<?php echo sourceUrl()."/media/c-right.png"?>" style="width:8px;border-radius: 100%;margin-right: 10px;"> <a href="<?php echo $url?>" style="border-bottom: transparent;font-size:13px;font-weight: 400">
						<?php echo $val?>
					</a></p>
			
					<?php $url = null;} ?>
				</div>
				<div id="filt-2" style="padding: 10px;margin-top:20px;">
				<img src="<?php echo sourceUrl()?>/media/times.png" style="position: fixed;width:40px;height:40px;border-radius: 5px;padding: 5px;border:1px #ddd solid;right:20px;margin-top:-10px;z-index: 996;background: #fff" onClick="return menu_collapse()">
				<?php if(splice(1) !== "search"){ ?>
				<h5>Kategori Produk </h5>

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

				<div style="margin-top: 30px;margin-bottom: 100px;">

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

			<div >
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

					<div style="padding:10px;border-radius: 3px;margin-top:-15px;border:1px #ddd solid;background: #fff">
						<table width="100%">
							<tr>
								<td>
									<p style="font-size: 17px;color:#434343">Maaf, Produk tidak ditemukan</p>
									<p style="margin-top:-15px;color:rgba(0,0,0,.54)">Coba kata kunci yang lain atau produk rekomendasi di bawah</p>
								</td>
							</tr>
							
						</table>
					</div>

					<h4 style="margin-top: 50px;font-size: 18px;margin-bottom: 30px;">Rekomendasi Untuk Anda</h4>

					<?php } 

					if($response > 0){ ?>

					<div>
						<p style="font-weight: 400;margin-top: -10px;font-size: 12px;margin-left: 10px;"><span><b><?php echo number_format($search_result)?></b> Produk Untuk 
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


<div style="position: fixed;z-index: 992;width: 100%;text-align: center;height: 50px;bottom:100px;">

	<button style="border:transparent;background: #fff;padding: 5px;-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);
	-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);
	box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);border:1px #ddd solid;border-radius: 10px;" onClick="return menu_collapse(1)"><img src="<?php echo sourceUrl()?>/media/sort.png" style="width: 30px;height:30px;"> Sort By</button>

	<button style="border:transparent;background: #fff;padding: 5px;-webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);
	-moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);
	box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.39);border:1px #ddd solid;border-radius: 10px;" onClick="return menu_collapse(2)"><img src="<?php echo sourceUrl()?>/media/filter.png" style="width: 30px;height:30px;">Filter By</button>

</div>					
					

					
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

						
						<div style="margin-bottom:5px;padding-left:0px">
							<div class="box-product" style="border-radius: 3px;overflow: hidden;padding: 10px;background: #fff;">

								<a href="<?php echo $url?>">
								<img src="<?php echo sourceUrl()?>/content/<?php echo $picture[0]?>" style="width:100px;height:100px;position: absolute;border:1px #ddd solid;border-radius: 5px;">
								<p style="margin-left:110px;margin-top:-10px;padding: 10px;font-weight: 600"><?php echo $show['title']?></p>
								<p style="margin-left:110px;margin-top:-10px;color:#fe4c50;padding: 10px;font-weight: 600;margin-top: -25px;height:40px;"><?php echo $discount_price?></p>
								</a>
							</div>
						</div>




					<?php } ?>

		


					

				<?php if($response > 0){ ?>
				<div style="margin-top:20px;margin-bottom:20px;margin-left:10px;width: 100%">

						<?php echo $this->pagination(true,"db_product",splice(1)) ?>
						
				</div>

			<?php } ?>

			</div>
		</div>
	
</div>



