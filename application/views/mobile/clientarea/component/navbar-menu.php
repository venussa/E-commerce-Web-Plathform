	<div id="t-nav" style="position: fixed;top:0px;z-index: 999;background: #fff;width: 100%;padding: 7px;border-bottom: 1px #ddd solid;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);left:0px;height:42px;">

		<!-- Main Navigation -->



			

	<?php 

	if(splice(1) == "blog") $link = "blog";
	else $link = "search";

	if((userinfo() !== false) and  (userinfo()->level > 1)){

		$url1 = "adminpanel/notification";
		$url2 = null;
		$url3 = null;
		$url4 = "adminpanel/profile";
		$url5 = "adminpanel";
		$url6 = "adminpanel/profileset";

	}else{

		$url1 = "clientarea/pemberitahuan";
		$url2 = "clientarea/whishlist";
		$url3 = "clientarea/keranjang_belanja";
		$url4 = "adminpanel/profile";
		$url5 = "clientarea";
		$url6 = "clientarea/pengaturan_profile";

	}

	?>

	<form method="GET" action="<?php echo HomeUrl()?>/<?php echo $link?>">

			<table width="100%" >
				<tr>
					<td style="width: 40px;"><a href="javascript:void(0)" onClick="open_menu()"><img src="<?php echo sourceUrl()?>/media/menu-bar.png" height="35" ></a></td>
					<td>
						<?php if(splice(1) == "blog"){ ?>
						<input type="text" style="border:1px #ccc solid;padding-left:5px;height:31px;position:relative;top:-3px;border-radius: 5px;width: 100%;left:-4px;" placeholder="Cari artikel <?php echo setting()->title?>" value="<?php echo strip_tags(urldecode(htmlspecialchars_decode($this->get("q"))))?>" name="q">
						<?php }else{ ?>
						<input type="text" style="border:1px #ccc solid;padding-left:5px;height:31px;position:relative;top:-3px;border-radius: 5px;width: 100%;left:-4px;" placeholder="Cari produk <?php echo setting()->title?>" value="<?php echo strip_tags(urldecode(htmlspecialchars_decode($this->get("q"))))?>" name="q">
						<?php } ?>
						<button style="background: transparent;right:65px;padding: 4px;border: transparent;position: absolute;cursor: pointer;top: 12px;">
						<img src="<?php echo sourceUrl()."/media/search.png"?>" style="width:25px;">
						</button>
					</td>
					<td style="width: 55px;">
						<a href="<?php echo HomeUrl()?>/<?php echo $url1?>" style="position: absolute;margin-top:-20px;padding: 8px;padding-top: 2px;border-radius: 100%;margin-left: 0px;">
						<img src="<?php echo sourceUrl()?>/media/bell.png" style="width:30px;">

						<?php if(alert_notification() > 0) { ?>
						<span id="checkout_items" class="checkout_items" style="font-size: 10px;width: 15px;height: 15px;margin-top: 8px;"><?php echo alert_notification()?></span>
						<?php } ?>
					</a>
					</td>
				</tr>
			</table>

	</form>

	</div>