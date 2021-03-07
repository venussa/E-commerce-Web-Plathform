<div class="left-sidebar">
		<div class="list-menu">

			<?php

			$role = json_decode(userinfo()->role);

			$whishlist = ["dashboard","notification"];

			foreach(admin_sidebar_menu() as $key => $val ){ 

				$key_role = $val['role'];
				$count = array_sum($role->$key_role);

				$wallet_system = ["request_refund","request_deposit","customer_funds"];

				if(in_array($key,$wallet_system) and (wallet_system() == false)) $val['level'] = 5;


				if((userinfo()->level >= $val['level']) or in_array($key_role, $whishlist) ) {	
				
				if($val['level'] < 5){

				?>

				<a href="<?php echo HomeUrl()?>/adminpanel/<?php echo $key?>" style="color:#434343">
					<div <?php echo setActiveMenu($val["slug"]) ?> style="cursor:pointer">
						<img src="<?php echo HomeUrl()?>/sources/<?php echo $val['icon']?>"> <?php echo $val['title']?>

						<?php if(($key == "notification") and (alert_notification() > 0)){ ?>
						<span style="background: orangered;padding: 5px;font-size: 10px;color:#fff;border-radius: 5px;float: right;"><?php echo alert_notification()?></span>
						<?php } ?>
					</div>
				</a>

			<?php }}elseif($count > 0){ 

					if($val['level'] < 5){
				?>

				<a href="<?php echo HomeUrl()?>/adminpanel/<?php echo $key?>" style="color:#434343">
					<div <?php echo setActiveMenu($val["slug"]) ?> style="cursor:pointer">
						<img src="<?php echo HomeUrl()?>/sources/<?php echo $val['icon']?>"> <?php echo $val['title']?>

						<?php if(($key == "notification") and (alert_notification() > 0)){ ?>
						<span style="background: orangered;padding: 5px;font-size: 10px;color:#fff;border-radius: 5px;float: right;"><?php echo alert_notification()?></span>
						<?php } ?>
					</div>
				</a>

			 <?php } } } ?>

		</div>
	</div>