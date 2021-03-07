
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman untuk untuk memberikan informasi mengenai kemana pembeli harus mentransfer dana pembeliannya dengan menyediakan banyak pilihan bank yang di daftarkan pada website</p>
<button class="btn-white" style="cursor:pointer" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/addbank';">Add New Bank</button>
<form method="get" action="<?php echo HomeUrl()?>/adminpanel/bank" style="float:right">
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			<tr>
				<th>Bank Name</th>
				<th style="width: 200px;">No. Rek</th>
				<th style="width: 100px;">Code Bank</th>
				<th style="width: 60px;">Action</th>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_pay_info","bank");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_pay_info ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/bank1.png" style="width: 150px;">
						<p style="font-family: 'Segoe UI Bold';font-size: 18px;">Rekening Tidak Ditemukan</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

			?>

			<tr>
				<td>
					<p><img src="<?php echo sourceUrl()?>/bank/<?php echo $show['icon']?>" style="width: 60px;height:35px;border:1px #ddd solid;border-radius: 5px;"></p>
					<p style="font-family: 'Segoe UI Bold';"><?php echo $show['bank_name']?></p>
				</td>
				<td>
					<p><span style="font-family: 'Segoe UI Bold';">A/N : </span> <?php echo $show['atas_nama']?></p>
					<p><span style="font-family: 'Segoe UI Bold';">No. Rek : </span><?php echo $show['bank_info']?></p>
				</td>
				<td><?php echo $show['code_bank']?></td>
				
				<td>
					<img onClick="window.location='<?php echo HomeUrl()."/adminpanel/editbank?id=".$show['id']?>';" style="cursor:pointer" src="<?php echo sourceUrl()?>/img/edit.png" width="22">
					<img onClick="delete_product(<?php echo $show['id']?>,'delete_bank')" src="<?php echo sourceUrl()?>/img/bin.png" width="22" style="cursor: pointer;">
					
				</td>
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_pay_info","bank") ?>
	</div>
		
</div>
<?php } ?>