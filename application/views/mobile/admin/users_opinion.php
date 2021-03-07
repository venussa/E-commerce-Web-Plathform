
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman ini menampilkan kiriman kritik dan saran dari para customer / pengunjung website. Anda dapat menjadikannya bahan masukan untuk perkembangan bisnis anda.</p>

<div class="big-panel-box" style="margin-top:0px;border: transparent;">

	<div class="list">
		<table width="100%">   


			<?php
			$paging = $this->pagination(false,"db_email","users_opinion");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_email ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");



			if($query->rowCount() == 0){?>

				<tr><td colspan="3">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/surat.png" style="width: 150px;">
						<p style="font-weight:600;font-size: 18px;">Tidak Ada Pesan Masuk</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Pesan hanya akan ada jika ada orang yang mengirim kritik atau saran</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

				$time_history = timeHistory($show['date_time'],true,"hour");

				if($time_history > 24 ) $time = date("d/m/Y H:i",$show['date_time']);

				else $time = timeHistory($show['date_time']);

			?>

			<tr >

				<td >
					<p style="font-weight:600;"><span style="">From : </span> <a href="mailto:<?php echo $show['email']?>" style="color: #09f" ><?php echo htmlspecialchars($show['email']); ?></a></p>
					<p >
						<span style="font-weight:600;"><?php echo stringLimit(strip_tags($show['subject']),100,"...")?></span> -  
						<?php echo stringLimit(strip_tags($show['msg']),100," ...")?> 
					</p>

					<p><?php echo $time?>
					<?php echo $show['reply_time'] > 0 ? "<br><br><span style='color:#666;font-size:13px;'><img src='".sourceUrl()."/media/deliv.png' width='13'> Terbalas</span>" :""; ?> 
					</p>

					<p>
						<a style="color:orangered;font-size: 13px;" href="<?php echo HomeUrl()?>/adminpanel/replymail?id=<?php echo $show['id']?>">Balas</a> · 
						<a style="color:orangered;font-size: 13px;" href="javascript:void(0)" onClick="delete_product(<?php echo $show['id']?>,'delete_email')">Hapus</a>
					</p>
					
						
				</td>
				
			</tr>

		<?php } }?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_email","users_opinion") ?>
	</div>
		
</div>

<?php } ?>