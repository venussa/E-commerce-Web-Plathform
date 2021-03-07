<?php
if(userinfo() == false) die("Access Danied");
if(userinfo()->level < 2) die("Access Danied");
if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
	role_access("funds", "6");
}
$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE type != 1 ");
$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE type = 1 and status = 1 ");
$saldo = $saldo0['saldo'] + $saldo1['saldo'];

?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Data mengenai dana nasabah yang masih terdeposit.</i></p>
<form method="get" action="<?php echo HomeUrl()?>/adminpanel/customer_funds" >
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>" style="float:none;width:97%;">
</form>
<div class="big-panel-box" style="margin-top:20px;float:none;">
	
	<div class="list">
		<table width="100%">

			<tr>
				<td class="tr" style="width: 200px;">
					<p class="t1">Total Saldo</p>
					<p class="t2">* Total saldo customer yang masih terdeposit</p>
			

					<img src="<?php echo sourceUrl()?>/media/deposite.png" style="width: 55px;position: absolute;margin-top:15px;margin-left:10px">
					<p style="font-size: 14px;color:#666;margin-left:80px;margin-top: 20px;">Total Deposit Saldo</p>
					<p style="font-weight:600;font-size: 20px;margin-top:-15px;margin-left:80px;">Rp <?php echo number_format($saldo)?></p>
				</td>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_users","customer_funds");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_users ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/deposite.png" style="width: 150px;">
						<p style="font-weight:600;font-size: 18px;">Tdak Ada Riwayat Saldo</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

				$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".$show['id']."' and type != 1 ");
				$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".$show['id']."' and type = 1 and status = 1 ");
				$saldo = $saldo0['saldo'] + $saldo1['saldo'];


				if(empty($show['profile_pict']) or ($show['profile_pict'] == "")) {

					if(strtolower($show['gender']) == "perempuan")

						$pict = sourceUrl()."/img/woman.png";
						else
						$pict = sourceUrl()."/img/man.png";
						
					}else $pict = sourceUrl()."/usr_pict/".$show['profile_pict'];

				?>
				<tr>
					<td colspan="2"><img src="<?php echo $pict?>" style="width:50px;height:50px;border-radius: 100%;position: absolute;margin-top:10px;">
						<p style="font-weight:600;margin-left:70px;"><?php echo ucwords($show['first_name']." ".$show['last_name']) ?></p>
						<p style="margin-top:-10px;margin-left:70px;"><a href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $show['username']?>" style="color:#09f">@<?php echo $show['username']?></a></p>
					
					<p style="font-weight:600;">Rp <?php echo number_format($saldo)?></p>

					<p><a href="<?php echo HomeUrl()?>/adminpanel/view_funds?id=<?php echo $show['id']?>" style="color:orangered">Lihat Selengkapnya</a></p>
					</td>
				</tr>

			<?php  } } ?>

		</table>
	</div>
</div>


<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_users","customer_funds") ?>
	</div>
		
</div>
<?php } ?>