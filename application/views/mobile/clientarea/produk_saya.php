<?php if(userinfo()->level < 1){
echo "<script>window.location='".HomeUrl()."/clientarea/dashboard';</script>";
exit;
}?>

<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Produk Saya</p>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman produk untuk melakukan editing , penambahan dan penghapusan data produk. Dan juga anda dapat menghidden produk anda agar tidak dapat dilihat oleh pengunjung dengan menekan tombol on / off</p>
<button class="btn-white" style="cursor:pointer" onClick="window.location='<?php echo HomeUrl()?>/clientarea/tambah_produk';">Add New Product</button>
<input class="tb-search" type="text" onChange="return search_data_product(this)" name="search" placeholder="Search ..." value="<?php echo $this->get("q")?>" style="width: 150px;border-radius: 5px;">
<div class="big-panel-box" style="margin-top:20px;float: none;">

	<div class="list">
		<table width="100%">

			
			<?php
			$paging = $this->pagination(false,"db_product","produk_saya");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_product ".$paging->condition." ORDER BY sorting_id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="6">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/barang.png" style="width: 150px;">
						<p style="font-family: 'Segoe UI Bold';font-size: 18px;">Produk Tidak Ditemukan</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

			$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$show['category']."' ");

			$category = $category->fetch();

			$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."' ");
			$user = $user->fetch();

			$order = $this->db()->query("SELECT sum(total_order) as TotalOrder FROM db_orders WHERE product_id='".$show['product_id']."' and status > 0");
			$order = $order->fetch();

			$stok = $show['stock'] - $order['TotalOrder'];

			if($stok <= 0){

				$stok = "<b style='color:#ff0000'>Out of stock</b>";

			}

			if($show['status'] == 1) $status = '<img style="cursor:pointer;" sort-id="'.$show['sorting_id'].'" onClick="set_status(this)" src="'.sourceUrl().'/img/on.png" width="62">';

			else $status = '<img style="cursor:pointer;" sort-id="'.$show['sorting_id'].'" onClick="set_status(this)" src="'.sourceUrl().'/img/off.png" width="62">';

			$picture = json_decode($show['picture']);

			?>

			<tr>
				<td style="border-bottom: 1px #ccc solid">
					<img src="<?php echo sourceUrl()?>/content/<?php echo $picture[0]?>" style="width:100px;height:100px;position: absolute;margin-top:16px">
					<p style='font-weight:600;font-size: 12px;margin-left: 120px;'>#<?php echo $show['product_id']?></p>
					<p style="margin-left: 120px;margin-top: -10px"><a style="color:#434343;" href="<?php echo HomeUrl()."/".url_title($category['title'],"-",true)?>/<?php echo url_title($show['title'],"-",true)?>?id=<?php echo $show['sorting_id']?>"><?php echo $show['title']?></a><br>

					</p>
					<p style="font-size:12px;margin-left: 120px;color:orangered"><span style='font-weight:600;color:#000'>Price : </span>Rp <?php echo number_format($show['price'])?></p>
					<p style="font-size:12px;margin-left: 120px;"><span style='font-weight:600;'>Stock Tersisa : </span> <?php echo $stok ?></p>

					

					


				<p style="color: orangered;font-weight:600;"><span style='font-weight:600;color:#000'>Kategori : </span><?php echo $category['title']?></p>
				<p style="font-size:13px;"><span style='font-weight:600;color:#000'>Tanggal : </span><?php echo date("d/y/Y", $show['date_time'])?></p>
				<p class="btn-white" onClick="window.location='<?php echo HomeUrl()."/clientarea/rubah_produk?id=".$show['sorting_id']?>';" style="cursor:pointer;width: 120px;">
				Edit Data Produk
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
		<?php echo $this->pagination(true,"db_product","produk_saya") ?>
	</div>
		
</div>
<?php } ?>