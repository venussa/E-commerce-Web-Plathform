<div class="left-sidebar" style="position: fixed;width: 95%;background: #fff;padding: 10px;overflow: hidden;left:0px;overflow-y: scroll;border-right:1px #ddd solid;display: none;z-index: 999">
		<div class="list-menu">

			<?php

			foreach(client_sidebar_menu() as $key => $val ){ 

				if(($key == "riwayat_saldo") and (wallet_system() == false)) $val['level'] = 5;

				if(userinfo()->level >= $val['level']){	?>

				<a href="<?php echo HomeUrl()?>/clientarea/<?php echo $key?>" style="color:#434343">
					<div <?php echo setActiveMenu($val["slug"]) ?> style="cursor:pointer">
						<img src="<?php echo HomeUrl()?>/sources/<?php echo $val['icon']?>"> <?php echo $val['title']?>

						<?php if(($key == "pemberitahuan") and (alert_notification() > 0)){ ?>
						<button style="background: orangered;font-size: 13px;color:#fff;border-radius: 5px;height:25px;min-width: 25px;float: right;font-weight: 600;padding-top: 0px;border:1px orangered solid;"><?php echo alert_notification()?></button>
						<?php } ?>
					</div>
				</a>

			<?php } } ?>
			<a href="<?php echo HomeUrl()?>/adminpanel/logout" style="color:#434343">
				<div style="cursor:pointer">
					<img src="<?php echo sourceUrl()?>/media/logout.png"> Logout
				</div>
			</a>

		</div>
	</div>