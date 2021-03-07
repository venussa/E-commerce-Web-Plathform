
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman untuk untuk memberikan informasi mengenai kemana pembeli harus mentransfer dana pembeliannya dengan menyediakan banyak pilihan bank yang di daftarkan pada website</p>
<button class="btn-white" style="cursor:pointer;width: 100%" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/addbank';">Add New Bank</button>
<form method="get" action="<?php echo HomeUrl()?>/adminpanel/bank">
<input class="tb-search" style="width: 96%;float: none;border-radius: 5px;margin-top: 10px" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

		

			<?php
			$paging = $this->pagination(false,"db_pay_info","bank");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_pay_info ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/bank1.png" style="width: 150px;">
						<p style="font-weight:600;font-size: 18px;">Rekening Tidak Ditemukan</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

			?>

			<tr>
				<td>
					<p><img src="<?php echo sourceUrl()?>/bank/<?php echo $show['icon']?>" style="width: 60px;height:35px;border:1px #ddd solid;border-radius: 5px;"></p>
					<p style="font-weight:600;"><?php echo $show['bank_name']?></p>
				</td>
				<td>
					<p><span style="font-weight:600;">A/N : </span> <?php echo $show['atas_nama']?></p>
					<p><span style="font-weight:600;">No. Rek : </span><?php echo $show['bank_info']?></p>
					<p><span style="font-weight:600;">Kode Bank:  </span><?php echo $show['code_bank']?></p>

					<p>
						<a style="color:orangered;font-size: 13px;" href="<?php echo HomeUrl()."/adminpanel/editbank?id=".$show['id']?>">Edit</a> · 
						<a style="color:orangered;font-size: 13px;" href="javascript:void(0)" onClick="delete_product(<?php echo $show['id']?>,'delete_bank')">Hapus</a>
					</p>

				</td>
				
				
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_pay_info","bank") ?>
	</div>
		
</div>
<?php } ?>