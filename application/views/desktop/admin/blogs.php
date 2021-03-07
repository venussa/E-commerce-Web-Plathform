<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Fitur untuk menambahkan tulisan atau blog's</i></p>
<button class="btn-white" style="cursor:pointer" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/addblog';">Add New Blog</button>
<form method="get" action="<?php echo HomeUrl()?>/adminpanel/blogs" style="float:right">
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			<tr>
				<th>Title</th>
				<th style="width: 100px;">Status</th>
				<th style="width: 60px;">Action</th>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_custom_page","blogs");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_custom_page ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="6">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/blog.png" style="width: 150px;">
						<p style="font-family: 'Segoe UI Bold';font-size: 18px;">Halaman tidak ditemukan</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

			if($show['status'] == 1) $status = '<img style="cursor:pointer;" sort-id="'.$show['id'].'" onClick="set_status_page(this)" src="'.sourceUrl().'/img/on.png" width="62">';

			else $status = '<img style="cursor:pointer;" sort-id="'.$show['id'].'" onClick="set_status_page(this)" src="'.sourceUrl().'/img/off.png" width="62">';

			if($show['level'] == 0) $type = "Normal";
			else $type = "Slider";

			$user = ($this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."' "))->fetch();

			$time_history = timeHistory($show['date_time'],true,"hour");

			if($time_history > 24 ) $time = date("d/m/Y H:i",$show['date_time']);

			else $time = timeHistory($show['date_time']);

			?>

			<tr>
				<td>
					<div style="width:160px;margin-top: 20px;position: absolute;"><img src="<?php echo sourceUrl().'/website/'.$show['img']?>" style="width:100%;border:1px #ddd solid;height: 90px;"></div>

					<p style="margin-left: 180px;">
						
						<a href="<?php echo HomeUrl()."/blog/".$show['slug']?>" target="_blank" style="color:#09f;font-family: Segoe UI Bold;"><?php echo $show['title']?></a>
						</p>
					

					<p style="margin-left: 180px;"><span style="font-family: Segoe UI Bold;">Post By : </span><a href="<?php echo HomeUrl()."/adminpanel/users/?q=".$user['username']?>" target="_blank" style="color:#000"><?php echo ucwords($user['first_name']." ".$user['last_name'])?></a></p>

					<p style="margin-left: 180px;"><span style="font-family: Segoe UI Bold;">Publist Date : </span><?php echo $time?></p>
				</td>
				
				<td><?php echo $status?></td>
				<td>
					<img onClick="window.location='<?php echo HomeUrl()."/adminpanel/editblog?id=".$show['id']?>';" style="cursor:pointer" src="<?php echo sourceUrl()?>/img/edit.png" width="22">
					<img onClick="delete_product('<?php echo $show['id']?>&page=true','delete_page')" src="<?php echo sourceUrl()?>/img/bin.png" width="22" style="cursor: pointer;">
					
				</td>
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_custom_page","blogs") ?>
	</div>
		
</div>
<?php } ?>