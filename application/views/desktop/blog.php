<div class="container" style="margin-top:110px;">



<?php
	$paging = $this->pagination(false,"db_custom_page","blog");

	$offset = ($paging->page - 1) * $paging->dataperpage;

	$limit = $paging->dataperpage;

	$query = $this->db()->query("SELECT * FROM db_custom_page ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

	$rowcount = $query->rowCount();

	if($rowcount !== 0){ ?>

		<div class="panel panel-default">
		<a style="color: #434343" href="<?php echo HomeUrl()."/blog"?>">
		<div class="panel-heading" style="background: #F2F3F7;float: left;z-index: 2;padding-left:0px;">Topics Blog
		</div></a>
		<div class="underline" style="width: 99.5%;border-top:4px solid #DCDEE3;margin-top:-21px;float: left;z-index: 1"></div>
		<ul class="list-container" style="margin-top: 60px;width: 100%;">


		<?php while($show = $query->fetch()){	

			$url = HomeUrl()."/blog/".url_title($show['title'],"-",true)."/".$show['id'];

			?>

			<li style="width:259px;background: #fff;margin: auto;margin-right:5.1px;margin-bottom:10px;">

				<a href="<?php echo $url?>">
				<img src="<?php echo sourceUrl()."/website/".$show['img']?>" style="width:100%;height:180px;">
				<p style="padding: 10px;height: 55px;overflow: hidden;font-weight: 600"><?php echo $show['title']?></p>
				<p style="padding: 10px;font-weight: 400;font-size:12px;color:#9c9c9c;padding-top:0px;padding-bottom: 0px;margin-top:-5px;margin-bottom: 4px;"><?php echo date("d M Y, H:i", $show['date_time'])?></p>
				<p style="padding: 10px;height: 55px;overflow: hidden;font-weight: 400;font-size:12px;margin-top:-10px;"><?php echo stringLimit(strip_tags($show['description']),90," ...")?></p>

				</a>

			</li>

			
			

		<?php } ?>
			</ul>
		</div>
		<?php }else{ ?>
		<div style="padding: 10px;text-align: center;height:283px">
			<img src="<?php echo sourceurl()?>/media/love.png" style="width: 150px;">
			<p style="font-family: 'Segoe UI Bold';">Tidak Ada Barang Yang Ditandai</p>
			<p style="color:#666;font-size:13px;margin-top:-5px;">Silahkan temukan barang yang ingin anda beli</p>
			<a href="<?php echo HomeUrl()?>"><button class="btn-white">Beli Barang</button></a>
		</div>
	<?php } ?>

<?php if($rowcount !== 0) { ?>
<div style="margin-top:20px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_custom_page","blog") ?>
	</div>
		
</div>
<?php } ?>
</div>