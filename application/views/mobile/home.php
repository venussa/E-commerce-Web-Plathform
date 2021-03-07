
<div class="container" style="margin-top: 55px;padding: 0px;">
 <?php 

$query = $this->db()->query("SELECT * FROM db_custom_page WHERE level=1 and status=1 ORDER BY position ASC");
if($query->rowCount() > 0){ ?>
<div style="width: 100%;">
<div class="swiper-container" style="background: #fff;">
    <div class="swiper-wrapper" >
     <?php

		while($show = $query->fetch()) { 

		if(empty($show['slug'])) $link = "javascript:void(0)";
		else $link = HomeUrl()."/".$show['slug'];

		?>

			<div class="swiper-slide" style="border-radius: 0px;overflow: hidden;padding: 0px;">
				<a href="<?php echo $link?>">
			  <img src="<?php echo sourceUrl()?>/website/<?php echo $show['img']?>" alt="" style="width: 101%;height:200px;border-radius: 0px;">
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



  	<div class="panel panel-default" style="width: 100%;background: #fff;border:1px #ddd solid;margin-top:0px;overflow-x: scroll;">
  		<ul class="list-container conts" style="margin-bottom: :-5px;">

  		<?php

  		$query = $this->db()->query("SELECT * FROM db_category WHERE level=0 LIMIT 6");
  		while($show = $query->fetch()){ ?>
  		<li style="background: #fff;display: inline;border: none;text-align: center;margin:0px;display: inline-grid;padding:10px;">

  			<a href="<?php echo HomeUrl()."/".url_title($show['title'],"-",true)?>">

  			<p style="font-size: 14px;font-weight: 400">
  				<img src="<?php echo sourceUrl()?>/website/<?php echo $show['img']?>" style="width:60px;height:60px;border:1px #ddd solid;padding:5px;border-radius: 100%">
  			</p>
  			<p style="text-align: center;margin-top:-10px;color:#434343"><?php echo $show['title']?></p>

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
<div class="container" style="margin-top:-43px;padding: 0px;margin-bottom: 50px;">
 <div style="width: 102%;">
  	
  			<?php 

  			$query = $this->db()->query("SELECT * FROM db_category WHERE level=0");

  			while($category = $query->fetch()){

		  			$query1 = $this->db()->query("SELECT * FROM db_product WHERE status=1 and category='".$category['id']."' ORDER BY RAND() LIMIT 12");

		  			if($query1->rowCount() > 0){ ?>

		  				<div class="panel panel-default" style="background: #fff;border:1px #ddd solid;margin-bottom: -43px;">
				  		
				  		<p style="padding: 10px;font-size: 15px;"><img src="<?php echo sourceUrl()?>/website/<?php echo $category['img']?>" style="width: 28px;height: 28px;padding:3px;border:1px #ddd solid;border-radius: 100%;margin-right:10px;"> Produk <?php echo $category['title']?>

				  		<a style="color: #fe4c50;float: right;font-size: 14px;border:none;margin-right: 10px;" href="<?php echo HomeUrl()."/".url_title($category['title'],"-",true)?>">Lihat Semua</a>
				  		</p>
				  	
				  		
				  		<div style="overflow-x:scroll;margin-top: -10px;margin-bottom:-10px;">
				  		<ul class="list-container cat-list-pro" style="width: 100%;">

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

		  			<li style="width:100px;border: transparent;">

						<a href="<?php echo $url?>">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:100px;height:100px;border:1px #ddd solid;border-radius: 10px">
						<p style="font-size:12px;padding: 10px;height: 51px;overflow: hidden;font-weight: 600"><?php echo $show['title']?></p>
						<p style="font-size:11px;color:#fe4c50;padding: 10px;font-weight: 600;margin-top: -15px;height:40px;"><?php echo $discount_price?></p>
						</a>
					
					</li>

					<?php }  ?>

					</ul>
					</div>
			  	</div>
			  

	<?php }}?>


  		
 </div>



</div>