
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman untuk untuk memantau segala jenis aktivas yang di lakukan admin dan suplier</p>
<form method="get" action="<?php echo HomeUrl()?>/adminpanel/log_activity">
<span style="float: left;font-family: Segoe UI Bold;margin-right: 10px;">Filter By : </span>
<select id="month" name="month" class="tb-search" style="float: left;width: 100px;margin-right:10px;">
	
	<?php if(!empty($this->get("month"))){ ?>

		<option><?php echo $this->get("month")?></option>

	<?php }else{ ?>

		<option></option>

	<?php } ?>
	
	<?php for($i = 1; $i <= 12; $i++){ 

		if($this->get("month") !== monthConvert($i,1)){
		?>
		<option><?php echo monthConvert($i,1)?></option>
	<?php } }?>

</select>

<select id="years" name="years" class="tb-search" style="float: left;width: 100px;margin-right:10px;">
	<?php if(!empty($this->get("years"))){ ?>

		<option><?php echo $this->get("years")?></option>

	<?php }else{ ?>

		<option></option>
		
	<?php } ?>
	<?php for($i = 2019; $i <= date("Y")+1; $i++){ ?>

		<?php if($this->get("years") !== (String) $i) { ?>
		<option><?php echo $i?></option>

	<?php } } ?>
</select>
<button class="btn-white" type="submit" style="padding: 6px;">Filter</button>

<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			<tr>
				<th>Activity</th>
				<th style="width: 200px;">Date & Time</th>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_activity","log_activity");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_activity ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="2">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/act.png" style="width: 150px;">
						<p style="font-family: 'Segoe UI Bold';font-size: 18px;">Tidak Ada Aktivitas</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba lihat lagi pada waktu berikutnya</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

				$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."' ");
				$user = $user->fetch();

				$time_history = timeHistory($show['date_time'],true,"hour");

				if($time_history > 24 ) $time = date("d/m/Y H:i",$show['date_time']);

				else $time = timeHistory($show['date_time']);

			?>

			<tr>
				<td>
					<p><a href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user['username']?>" style="color:#09f;">@<?php echo $user['username']?></a> <?php echo $show['msg']?></p>
				</td>
				<td>
					<p><?php echo $time?></p>
				</td>
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_activity","log_activity") ?>
	</div>
		
</div>
<?php } ?>