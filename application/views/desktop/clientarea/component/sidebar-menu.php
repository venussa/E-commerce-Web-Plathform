<div class="left-sidebar">

	<?php if(wallet_system()){

		$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type != 1 ");
		$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type=1 and status=1 ");
		$saldo = $saldo0['saldo'] + $saldo1['saldo'];

	?>
	<div style="background: #fff;border:1px #ddd solid;padding:10px;padding-top:0px;padding-bottom:10px;margin-bottom: 10px;">
		<img src="<?php echo sourceUrl()?>/media/wallet.png" style="width: 55px;position: absolute;margin-top:10px;margin-left:10px">
		<p style="font-size: 14px;color:#666;margin-left:80px;">Total Saldo</p>
		<p style="font-family: Segoe UI Bold;font-size: 20px;margin-top:-15px;margin-left:80px;">Rp <?php echo number_format($saldo)?></p>
		<a href="<?php echo HomeUrl()?>/clientarea/penarikan_saldo"><button class="btn-white" style="width: 100%;border-radius: 5px;">Tarik Saldo</button></a><p></p>
		<a href="<?php echo HomeUrl()?>/clientarea/deposit"><button class="btn-white" style="width: 100%;border-radius: 5px;border:1px #fe4c50 solid; color : #fe4c50;background: #fff;">Deposit</button></a>
	</div>
	<?php } ?>

	<div class="list-menu">

		<?php

		foreach(client_sidebar_menu() as $key => $val ){ 

			if(($key == "riwayat_saldo") and (wallet_system() == false)) $val['level'] = 5;

			if(userinfo()->level >= $val['level']){	?>

			<a href="<?php echo HomeUrl()?>/clientarea/<?php echo $key?>" style="color:#434343">
				<div <?php echo setActiveMenu($val["slug"]) ?> style="cursor:pointer">
					<img src="<?php echo HomeUrl()?>/sources/<?php echo $val['icon']?>"> <?php echo $val['title']?>

					<?php if(($key == "pemberitahuan") and (alert_notification() > 0)){ ?>
					<span style="background: orangered;padding: 5px;font-size: 10px;color:#fff;border-radius: 5px;float: right;"><?php echo alert_notification()?></span>
					<?php } ?>
				</div>
			</a>

		<?php } } ?>

	</div>
</div>