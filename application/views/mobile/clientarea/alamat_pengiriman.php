<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Alamat Pengiriman</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Anda bisa menambahkan lebih dari satu alamat sebagai alamat alternatif untuk menentukan lokasi pengiriman barang yang berbeda.</p>
<button class="btn-white" style="cursor:pointer;background: #fe4c50;border:1px #fe4c50 solid;width: 100%;border-radius: 5px;padding:10px;" onClick="window.location='<?php echo HomeUrl()?>/clientarea/tambah_alamat';">Tambah Alamat Baru</button>
<input class="tb-search" type="text" onChange="return search_data(this)" name="search" placeholder="Search ..." value="<?php echo $this->get("q")?>" style="float:none;width: 93%;padding:10px;border:1px #ccc solid;border-radius: 5px;margin-top: 10px;">
<div class="big-panel-box" style="margin-top:20px;width: 100%;float: none;">

	<div class="list">
		<table width="100%">


			<?php
			$paging = $this->pagination(false,"db_destination_address","alamat_pengiriman");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_destination_address ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/mark.png" style="width: 150px;">
						<p style="font-weight:600;font-size: 18px;">Alamat Tidak Ditemukan</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

			?>

			<tr>
				<td valign="top">
					<p style="font-weight:600;font-size: 14px;">
						<?php echo $show['nama_penerima']?>
					</p>
					<p style="font-size: 13px;color:#434343;margin-top:-10px;"><?php echo $show['phone_number']?></p>
				
					<p style="font-weight:600;font-size: 14px;"><?php echo $show['label']?></p>
					<p style="font-size: 13px;margin-top: -10px;"><?php echo $show['address']?>
					, <?php echo $show['district']?>
					, <?php echo $show['state']?>
					</p>
				

					<p style="font-size: 13px;"><img src="<?php echo sourceUrl()?>/media/mark.png" width="13"> <?php echo $show['province']?>
					, <?php echo $show['state']?><br>
					<?php echo $show['district']?>
					, <?php echo $show['zip_code']?>
					</p>
				<p style="background: #f5f5f5;border:1px #ccc solid;border-radius: 5px;padding:10px;">
					<a href="<?php echo HomeUrl()."/clientarea/rubah_alamat?id=".$show['id']?>" style="color:#434343"><img style="cursor:pointer" src="<?php echo sourceUrl()?>/img/edit.png" width="15">  Edit</a>
					<span onClick="delete_product(<?php echo $show['id']?>,'delete_address')" style="cursor: pointer;"><img style="margin-left:20px;" src="<?php echo sourceUrl()?>/img/bin.png" width="15" style="cursor: pointer;"> Hapus</span>
				</p>
				</td>
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>


<?php if($query->rowCount() !== 0) { ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_destination_address","alamat_pengiriman") ?>
	</div>
		
</div>
<?php } ?>