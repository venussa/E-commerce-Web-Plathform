
<div class="container" style="margin-top: 110px;">
 <?php 

$query = $this->db()->query("SELECT * FROM db_custom_page WHERE level=1 and status=1 ORDER BY position ASC");
if($query->rowCount() > 0){ ?>
<div style="width: 800px;position: absolute;right: 0px;">
<div class="swiper-container" style="background: transparent;">
    <div class="swiper-wrapper" >
     <?php

		while($show = $query->fetch()) { 

		if(empty($show['slug'])) $link = "javascript:void(0)";
		else $link = HomeUrl()."/".$show['slug'];

		?>

			<div class="swiper-slide" style="border-radius: 3px;overflow: hidden;border:1px #ddd solid;">
				<a href="<?php echo $link?>">
			  <img src="<?php echo sourceUrl()?>/website/<?php echo $show['img']?>" alt="" style="width: 800px;height: 348px;border-radius: 3px;">
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
<?php } ?>



  	<div class="panel panel-default" style="width: 275px;background: #fff;height:350px;border:1px #ddd solid;">
  		<div class="panel-heading" style="font-size: 15px;text-align: left;">Kategori Saya
  			<div class="underline" style="width: 100%;border-top:1px solid #DCDEE3;"></div>
				  		
  		</div>
  		
  		
  		<ul class="list-container" style="margin-top:5px;">

  		<?php

  		$query = $this->db()->query("SELECT * FROM db_category WHERE level=0 LIMIT 6");
  		while($show = $query->fetch()){ ?>
  		<li style="width:100%;background: #fff;display: inline;border: none;border-bottom: 2px #ddd solid;text-align: left;margin:0px;">

  			<a href="<?php echo HomeUrl()."/".url_title($show['title'],"-",true)?>">

  			<p style="font-size: 14px;margin-left:10px;font-weight: 400"><img src="<?php echo sourceUrl()?>/website/<?php echo $show['img']?>" style="width:30px;height:30px;border:1px #ddd solid;padding:5px;border-radius: 100%"> <span style="margin-left:10px;"><?php echo $show['title']?></span>

  				<img src="<?php echo sourceUrl()."/media/c-right.png"?>" style="width:12px;border-radius: 100%;margin-right: 10px;float: right;margin-top:8px;margin-right: 10px;">

  			</p>

  			</a>
  		</li>
  		<?php } ?>
  		</ul>

  </div>

</div>
  
<!--   <div class="newsletter">

  	<div class="container">
  		<p style="font-weight: 600;text-align: center;font-size: 25px;
}">Spesial Potongan Harga</p>
  	</div>

  </div> -->
<div class="container" style="margin-top:-27px;">
 <div style="width: 102%;">
  	
  			<?php 

  			$query = $this->db()->query("SELECT * FROM db_category WHERE level=0");

  			while($category = $query->fetch()){

		  			$query1 = $this->db()->query("SELECT * FROM db_product WHERE status=1 and category='".$category['id']."' ORDER BY RAND() LIMIT 12");

		  			if($query1->rowCount() > 0){ ?>

		  				<div class="panel panel-default">
				  		<a style="color: #434343" href="<?php echo HomeUrl()."/".url_title($category['title'],"-",true)?>"><div class="panel-heading" style="background: #F2F3F7;float: left;z-index: 2;padding-left:0px;">Produk <?php echo $category['title']?>
				  		</div></a>
				  		<div class="underline" style="width: 99.5%;border-top:4px solid #DCDEE3;margin-top:-21px;float: left;z-index: 1"></div>
				  		<ul class="list-container" style="margin-top: 60px;width: 100%;">

		  			<?php while($show = $query1->fetch()){

		  				if(userinfo() !== false){
			  				$whishlist = $this->db()->query("SELECT user_id,product_id FROM db_white_list WHERE user_id='".userinfo()->user_id."' and product_id='".$show['sorting_id']."' ");
			  				$w_rowcount = $whishlist->rowCount();
			  				$whishlist = $whishlist->fetch();

			  				if($w_rowcount > 0) $w_active = "active";
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

		  			<li style="width:174px;background: #fff;padding: 10px;margin: auto;margin-right:5px;margin-bottom:5px;">

		  				<?php if(userinfo() !== false){ ?>
						<div class="product_favorite d-flex flex-column align-items-center justify-content-center <?php echo $w_active?>" p_id="<?php echo $show['sorting_id']?>" onClick="return favourit(this)" style="height: 30px;width: 30px;background: #fff;border-radius: 100%;margin-bottom: -40px;margin-top:10px;margin-left: 10px;">
							
						</div>
						<?php } ?>

						<a href="<?php echo $url?>">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:100%;height:150px;">
						<p style="padding: 10px;height: 55px;overflow: hidden;font-weight: 600"><?php echo $show['title']?></p>
						<p style="color:#fe4c50;padding: 10px;font-weight: 600;margin-top: -15px;height:40px;"><?php echo $discount_price?></p>
						</a>
					
					</li>

					<?php }  ?>

					</ul>
			  	</div>
			  

	<?php }}?>


  		
 </div>



</div>