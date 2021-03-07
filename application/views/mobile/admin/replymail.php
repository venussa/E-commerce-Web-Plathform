
<?php 
$query = $this->db()->query("SELECT * FROM db_email WHERE id='".$this->get('id')."' ");
if($query->rowCount() == 0){

	echo "<script>window.location='".HomeUrl()."/adminpanel/users_opinion';</script>";
	exit;
}

$show = $query->fetch();

?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Balas pesan dari customer "</i></p>


<p style="background: #f5f5f5;padding: 10px;border:1px #ddd solid;border-radius: 5px;width: 93%">Subject : <?php echo $show['subject']?></p>

<div class="big-panel-box" style="margin-top:20px;border:transparent;">

	<table width="100%">

		<?php


		$query = $this->db()->query("SELECT * FROM db_email WHERE id='".$this->get('id')."' ");
		$show = $query->fetch();

		$this->db()->query("UPDATE db_email SET status=1 WHERE id='".$this->get("id")."' ");

		
		$time_history = timeHistory($show['date_time'],true,"hour");

		if($time_history > 24 ) $time = date("d/m/Y H:i",$show['date_time']);

		else $time = timeHistory($show['date_time']);


		?>
		<tr>
			<td class="tr">
			<img src="<?php echo sourceUrl()?>/media/rps.png" width="50" height="50" class="user-pict" style="box-shadow:none;border-radius: 0px;">
			<p class="t1" style="margin-left:70px;margin-top:10px;cursor: pointer;">
				<?php echo strip_tags($show['email']) ?>
					
				</p>
			<p style="margin-left:70px;font-size:11px;color:#666;margin-top:-10px;"><?php echo $time?></p>
				
			<p style="margin-left:70px;background: #f5f5f5;padding: 10px;margin-top:15px;border-radius: 5px">	

				<?php echo $show['msg']?></p>
			
			</td>
		</tr>

		<?php if($show['reply_time'] > 0){ 


			$time_history = timeHistory($show['reply_time'],true,"hour");

			if($time_history > 24 ) $time = date("d/m/Y H:i",$show['reply_time']);

			else $time = timeHistory($show['reply_time']);

			?>

			<tr>
			<td class="tr">
			<img src="<?php echo sourceUrl()?>/media/rps.png" width="50" height="50" class="user-pict" style="box-shadow:none;border-radius: 0px;">
			<p class="t1" style="margin-left:70px;margin-top:10px;cursor: pointer;">
			Balasan Saya</p>
			<p style="margin-left:70px;font-size:11px;color:#666;margin-top:-10px;"><?php echo $time?></p>
				
			<p style="margin-left:70px;background: #f5f5f5;padding: 10px;margin-top:15px;border-radius: 5px">	

				<?php echo $show['reply']?></p>
			
			</td>
		</tr>

		<?php } ?>


	<?php if($show['reply_time'] < 1){ ?>
	<tr>
		<td style="border: 1px #ddd solid;background: #f5f5f5">

			<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/reply_mail?id=<?php echo $this->get('id')?>" enctype="multipart/form-data">
	
				<textarea style="width: 94%" type="text" name="reply" class="form-input"></textarea>
				<div style="margin-top: 10px;"> 
					<button class="btn-white" style="float: right;" accept="jpg,png">Send Message</button>
				</div>

			</form>
		</td>
	</tr>
<?php } ?>
</table>

</div>

