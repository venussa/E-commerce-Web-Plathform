
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Fitur untuk menambahkan halaman baru pada website</i></p>
<button class="btn-white" style="cursor:pointer" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/addpage';">Add New Page</button>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			<tr>
				<th>Title</th>
				<th style="width: 150px;">Position</th>
				<th style="width: 100px;">Status</th>
				<th style="width: 60px;">Action</th>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_custom_page","page_content");

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

			?>

			<tr>
				<td>
					<p>
						<a href="<?php echo HomeUrl()."/".$show['slug']?>" target="_blank" style="color:#09f;font-family: Segoe UI Bold;">
						<?php 

						echo $show['title'];

						if($show['level'] == 1){

							echo '<div style="width:150px;"><img src="'.sourceUrl().'/website/'.$show['img'].'" style="width:100%;"></div>';
						}

						?></a>
						</p>
					<p><span style="font-family: Segoe UI Bold;">Type : </span><?php echo $type?></p>
					
				</td>
				<td><span style="font-family: Segoe UI Bold;">Urut Ke : </span>
					<select class="form-input" style="padding:5px;margin-top:-5px;width: 45%;margin-left:10px;" data-id="<?php echo $show['id']?>" onChange="return change_position(this)">
						<?php

							echo "<option>".$show['position']."</option>";

							for($i = 1; $i <= $query->rowCount(); $i++){

								if($i <> $show['position'])
								echo "<option>".$i."</option>";

							}
						?>
					</select>
				</td>
				<td><?php echo $status?></td>
				<td>
					<img onClick="window.location='<?php echo HomeUrl()."/adminpanel/editpage?id=".$show['id']?>';" style="cursor:pointer" src="<?php echo sourceUrl()?>/img/edit.png" width="22">
					<img onClick="delete_product(<?php echo $show['id']?>,'delete_page')" src="<?php echo sourceUrl()?>/img/bin.png" width="22" style="cursor: pointer;">
					
				</td>
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_custom_page","page_content") ?>
	</div>
		
</div>
<?php } ?>