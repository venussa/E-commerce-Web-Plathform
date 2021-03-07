<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Anda bisa menambahkan lebih dari satu alamat sebagai alamat alternatif untuk menentukan lokasi pengiriman barang yang berbeda.</p>
<button class="btn-white" style="cursor:pointer" onClick="window.location='<?php echo HomeUrl()?>/clientarea/tambah_alamat';">Tambah Alamat Baru</button>
<input class="tb-search" type="text" onChange="return search_data(this)" name="search" placeholder="Search ..." value="<?php echo $this->get("q")?>">
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			<tr>
				<th style="width: 100px;">Penerima</th>
				<th>Alamat Pengiriman</th>
				<th style="width: 200px;">Daerah Pengiriman</th>
				<th style="width: 60px;">Action</th>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_destination_address","alamat_pengiriman");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_destination_address ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/mark.png" style="width: 150px;">
						<p style="font-family: 'Segoe UI Bold';font-size: 18px;">Alamat Tidak Ditemukan</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

			?>

			<tr>
				<td valign="top">
					<p style="font-family: 'Segoe UI Bold';font-size: 13px;">
						<?php echo $show['nama_penerima']?>
					</p>
					<p style="font-size: 13px;color:#434343;margin-top:-10px;"><?php echo $show['phone_number']?></p>
				</td>

				<td valign="top">
					<p style="font-family: 'Segoe UI Bold';font-size: 13px;"><?php echo $show['label']?></p>
					<p style="font-size: 13px;margin-top: -10px;"><?php echo $show['address']?>
					, <?php echo $show['district']?>
					, <?php echo $show['state']?>
					</p>
				</td>

				<td valign="top">

					<p style="font-size: 13px;"><img src="<?php echo sourceUrl()?>/media/mark.png" width="13"> <?php echo $show['province']?>
					, <?php echo $show['state']?><br>
					<?php echo $show['district']?>
					, <?php echo $show['zip_code']?>
					</p>
				</td>
				
				
				<td>
					<img onClick="window.location='<?php echo HomeUrl()."/clientarea/rubah_alamat?id=".$show['id']?>';" style="cursor:pointer" src="<?php echo sourceUrl()?>/img/edit.png" width="22">
					<img onClick="delete_product(<?php echo $show['id']?>,'delete_address')" src="<?php echo sourceUrl()?>/img/bin.png" width="22" style="cursor: pointer;">
					
				</td>
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_destination_address","alamat_pengiriman") ?>
	</div>
		
</div>
<?php } ?>