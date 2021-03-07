<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>"Lihat pemberitahuan"</i></p>


<div style="margin-top:20px;">

	<div class="list">

			<?php
			$paging = $this->pagination(false,"db_alert","notification");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_alert ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			$rowcount = $query->rowCount();

			if($rowcount !== 0){ 

				while($show = $query->fetch()){

				$time_history = timeHistory($show['date_time'],true,"hour");

				if($time_history > 24 ) $time = date("d/m/Y H:i",$show['date_time']);
				else $time = timeHistory($show['date_time']);

				if(strpos(" ".$show['url'],"{id}"))
				$paramater = HomeUrl()."/".str_replace("{id}","&id=".$show['order_id'],$show['url']);
				else $paramater = HomeUrl()."/".$show['url']."?id=".$show['order_id'];

				$url = HomeUrl()."/handler/read/".$show['id']."/".base64_encode(urlencode($paramater));

				if($show['status'] > 0) $background = null;
				else $background = "background: #edffff";

				?>
				<a style="color:#434343;" href="<?php echo $url?>">
					<div style="<?php echo $background ?>;border-bottom: 1px #ddd solid;margin-top: -14px;">
						<img src="<?php echo sourceUrl()."/alert/".$show['icon']?>.png" style="width: 30px;height: 30px;position:absolute;margin-top: 2px;padding: 10px;">
						<p style="padding-bottom: 10px;padding-top:10px;margin-left:60px;padding-right:10px;font-size: 15px;"><?php echo filter_alert($show)?><br><span style="background:#ccebf0;color:#666;font-size:12px;padding: 2px;color:#434343;border-radius: 5px;padding-left:5px;padding-right:5px;"><?php echo $time?></span>
						</p>
					</div>
					
				</a>

				<?php } }else{ ?>
				<div style="padding: 10px;text-align: center;height:283px">
					<img src="<?php echo sourceurl()?>/media/bell.png" style="width: 150px;">
					<p style="font-family: 'Segoe UI Bold';">Tidak Ada Pemberitahuan</p>
					<p style="color:#666;font-size:13px;margin-top:-5px;">Kembali ke halaman utama</p>
					<a href="<?php echo HomeUrl()?>"><button class="btn-white"><?php echo setting()->title?></button></a>
				</div>
			<?php } ?>

		
	</div>
</div>


<?php if($rowcount !== 0) { ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_alert","notification") ?>
	</div>
		
</div>
<?php } ?>