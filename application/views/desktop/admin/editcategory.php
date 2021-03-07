<?php
$command = "SELECT * FROM db_category WHERE id='".$this->get("id")."' ";
$query = $this->db()->query($command);
$show = $query->fetch();

$main = "SELECT * FROM db_category WHERE id='".$show['sublevel']."'  ";
$main = $this->db()->query($main);
$main = $main->fetch();

?>


<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman untuk menambah dan menghapus kategori. Jika anda menghapus main kategori ataupun sub category, <span style="color:#ff0000;font-style: italic;">maka semua product yang berkaitan dengan kategori tersebut akan ikut terhapus</span>, jadi berhati hatilah.</p>

<form method="POST" action="<?php echo homeUrl()?>/adminpanel/edit_category?id=<?php echo $show['id']?>" enctype="multipart/form-data">
<div class="big-panel-box" style="margin-top:20px;width: 99%;float: left;margin-right: 4%;">
	<div class="list">
		<div class="title" style="background: #f5f5f5;color:#434343;border-bottom:1px #ddd solid;border-radius: 0px;">Add New Category</div>

		<div style="padding: 10px;">
		<p style="font-family: 'Segoe UI Bold';color:#434343;">Name</p>
		<input type="type" name="title" class="form-input" style="width: 97%" value="<?php echo $show['title']?>" placeholder="" required>

		<p style="font-family: 'Segoe UI Bold';color:#434343;">Description</p>
		<textarea type="type" name="description" class="form-input" style="width: 97%" placeholder="" required><?php echo $show['description']?></textarea>

		<p style="font-family: 'Segoe UI Bold';color:#434343;">Category ID</p>
		<input type="type" name="uniq_id" class="form-input" style="width: 97%" value="<?php echo $show['uniq_id']?>" placeholder="" required>

		<?php if($show['level'] > 0) $style = "display:none;";
		else $style = ""; ?>
		<span id="img-cat" style="<?php echo $style ?>">
		<p style="font-family: 'Segoe UI Bold';color:#434343;">Skema Transaksi</p>
		<p><label class="cb-container"> Skema Langsung
			  <input type="checkbox" name="transaction_scheme" value="0" <?php echo ($show['transaction_scheme'] == 0) ? "checked" : "";?> class="cbx">
			  <span class="checkmark"></span>
			</label>
			<span style="font-size:11px;color:#666">* User yang melakukan transaksi bisa dapat langsung mengetahui harga ongkos kirim produk</span>
		</p>
		
		<p><label class="cb-container"> Skema Tak Langsung
			  <input type="checkbox" name="transaction_scheme" value="1" <?php echo ($show['transaction_scheme'] == 1) ? "checked" : "";?> class="cbx">
			  <span class="checkmark"></span>
			</label>
			<span style="font-size:11px;color:#666">* User yang melakukan transaksi harus menunggu konfirmasi admin mengenai harga ongkos kirim</span>
		</p>
	

		
		<p style="font-family: 'Segoe UI Bold';color:#434343;">Main Category Image</p>
			
			<?php 

			if(empty($show['img'])) $pict = sourceUrl()."/img/img-upload.png";
			else $pict = sourceUrl()."/website/".$show['img']; 

			?>

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

					
					<select name="category" id="cat-sel" class="form-input" style="width: 100%;margin-left:9px;">

						<?php

						if($show['sublevel'] == 0){?>

						<option>None</option>

						<?php }else{

						

						?>

						<option><?php echo $main['title']?></option>
						<option>None</option>

						<?php } ?>
					<?php 

						$query1 = $this->db()->query("SELECT * FROM db_category WHERE level='0' ORDER BY id ASC");

						while($show1 = $query1->fetch()) { 
						if($show['title'] !== $show1['title']){
						?>
							<option><?php echo $show1['title']?></option>
						<?php } }?>

					</select>
				</td>
			</tr>
		</table>
		
		<button class="btn-white" style="cursor:pointer;padding: 10px;width: 100%;margin-top: 10px;">Save Category</button>

		</div>

		

	</div>
</div>

<div style="height: 50px;float: left;width: 100%;"></div>