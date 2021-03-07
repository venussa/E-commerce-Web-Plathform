
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman untuk menambah dan menghapus kategori. Jika anda menghapus main kategori ataupun sub category, <span style="color:#ff0000;font-style: italic;">maka semua product yang berkaitan dengan kategori tersebut akan ikut terhapus</span>, jadi berhati hatilah.</p>

<form method="POST" action="<?php echo homeUrl()?>/adminpanel/add_category" enctype="multipart/form-data">
<div class="big-panel-box" style="margin-top:20px;width: 43%;float: left;margin-right: 4%;">
	<div class="list">
		<div class="title" style="border-radius: 0px;background: #f5f5f5;color:#434343;border-bottom:1px #ddd solid;">Add New Category</div>

		<div style="padding: 10px;">
		<p style="font-family: 'Segoe UI Bold';color:#434343;">Name</p>
		<input type="type" name="title" class="form-input" style="width: 90%" placeholder="" required="">

		<p style="font-family: 'Segoe UI Bold';color:#434343;">Description</p>
		<textarea type="type" name="description" class="form-input" style="width: 90%" placeholder="" required=""></textarea>

		<p style="font-family: 'Segoe UI Bold';color:#434343;">Category ID</p>
		<input type="type" name="uniq_id" class="form-input" style="width: 90%" placeholder="" required="">

		<span id="img-cat">
		<p style="font-family: 'Segoe UI Bold';color:#434343;">Skema Transaksi</p>
		<p><label class="cb-container"> Skema Langsung
			  <input type="checkbox" name="transaction_scheme" value="0" class="cbx" checked="">
			  <span class="checkmark"></span>
			</label>
			<span style="font-size:11px;color:#666">* User yang melakukan transaksi bisa dapat langsung mengetahui harga ongkos kirim produk</span>
		</p>

		<p><label class="cb-container"> Skema Tak Langsung
			  <input type="checkbox" name="transaction_scheme" value="1" class="cbx">
			  <span class="checkmark"></span>
			</label>
			<span style="font-size:11px;color:#666">* User yang melakukan transaksi harus menunggu konfirmasi admin mengenai harga ongkos kirim</span>
		</p>

		
		<p style="font-family: 'Segoe UI Bold';color:#434343;">Main Category Image</p>
		<?php $pict = sourceUrl()."/img/img-upload.png"; ?>

			<img src="<?php echo $pict?>" style="width: 75px;height:75px;cursor: pointer;" id="img-icon" onClick="click_upload('input-icon')">
			<input type="file" id="input-icon" name="img" style="display: none;">

		</span>

		<table width="100%">
			
			<tr>
				<td style="width: 150px;">
					<p style="font-family: 'Segoe UI Bold';color:#434343;">Parent</p>
					<p style="font-size: 11px;color:#666;margin-top:-10px;">* Pilih kategori utama dari sub kategori ini <span style="color:#434343">( Optional )</span></p>
				</td>
				<td>
					<select name="category" id="cat-sel" class="form-input" style="width: 98%">
						<option>None</option>
					<?php 

						$query = $this->db()->query("SELECT * FROM db_category WHERE level='0' ORDER BY id ASC");

						while($show = $query->fetch()) { ?>
							<option><?php echo $show['title']?></option>
						<?php } ?>

					</select>
				</td>
			</tr>
		</table>
		
		<button class="btn-white" style="cursor:pointer;padding: 10px;width: 100%;margin-top: 10px;">Save Category</button>

		</div>

		

	</div>
</div>
<div class="big-panel-box" style="margin-top:20px;width: 52%;float: left;">

	<div class="list">
		<table width="100%">

			<tr>
				<th style="width: 40px;">Id</th>
				<th>Name</th>
				<th style="width: 60px;">Action</th>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_category","category");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_category WHERE level='0' ORDER BY id ASC LIMIT $offset,$limit");

			$num = 1;

			while($show = $query->fetch()){ 

			?>

			<tr>
				<td style="font-size: 12px;background: #edfbff">#<?php echo $show['uniq_id']?></td>
				<td style="background: #edfbff"><?php echo $show['title']?></td>
				<td style="background: #edfbff">
					<img onClick="window.location='<?php echo HomeUrl()."/adminpanel/editcategory?id=".$show['id']?>';" style="cursor:pointer" src="<?php echo sourceUrl()?>/img/edit.png" width="22">
					<img onClick="delete_product(<?php echo $show['id']?>,'delete_category')" src="<?php echo sourceUrl()?>/img/bin.png" width="22" style="cursor: pointer;">
					
				</td>
			</tr>

			<?php

			$query1 = $this->db()->query("SELECT * FROM db_category WHERE level='1' and sublevel='".$show['id']."' ORDER BY id DESC");

			while($show1 = $query1->fetch()){?>

				<tr>
				<td style="font-size: 12px;">#<?php echo $show1['uniq_id']?></td>
				<td>

					<img src="<?php echo sourceUrl()?>/img/arrow.png" style="width:20px;position: relative;margin-right:10px;top:3px;">
					<?php echo $show1['title']?>
						
					</td>
				<td>
					<img onClick="window.location='<?php echo HomeUrl()."/adminpanel/editcategory?id=".$show1['id']?>';" style="cursor:pointer" src="<?php echo sourceUrl()?>/img/edit.png" width="22">
					<img onClick="delete_product(<?php echo $show1['id']?> ,'delete_category')" src="<?php echo sourceUrl()?>/img/bin.png" width="22" style="cursor: pointer;">
					
				</td>
			</tr>

			<?php $num++;}?>

		<?php $num++; } ?>

		</table>
	</div>

	<div style="margin:auto;margin-top:-5px;margin-bottom:10px;float: right;width: 100%">

	<div style="float:left;margin-top:18px;padding-left:10px;font-size: 10px;font-style: italic;color:#666;">
		* Berhati hati sebelum menghapus
	</div>

	<div style="float:right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_category","category") ?>
	</div>
		
	</div>
</div>
<div style="height: 50px;float: left;width: 100%;"></div>