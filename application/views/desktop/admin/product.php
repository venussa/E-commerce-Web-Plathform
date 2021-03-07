
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman produk untuk melakukan editing , penambahan dan penghapusan data produk. Dan juga anda dapat menghidden produk anda agar tidak dapat dilihat oleh pengunjung dengan menekan tombol on / off</p>
<button class="btn-white" style="cursor:pointer" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/addproduct';">Add New Product</button>

<button class="btn-white" style="cursor:pointer;background: #fff;color:#fe4c50;border:1PX #fe4c50 solid" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/product?discount=true';">Filter Active Discount</button>

<form method="get" action="<?php echo HomeUrl()?>/adminpanel/product" style="float:right">
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			<tr>
				<th>Title</th>
				<th style="width: 100px;">Categories</th>
				<th style="width: 105px;">Date</th>
				<th style="width: 100px;">Status</th>
				<th style="width: 60px;">Action</th>
			</tr>

			<?php

			if($this->get("discount") == "true"){
			
				$paging = $this->pagination(false,"db_product_discount","product");
				$orderby = "id";
				$table = "db_product_discount";

			}else{
				
				$paging = $this->pagination(false,"db_product","product");
				$orderby = "sorting_id";
				$table = "db_product";

			}

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM $table ".$paging->condition." ORDER BY ".$orderby." DESC LIMIT $offset,$limit");

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

			if($this->get("discount") == "true"){
				
				$product = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$show['product_id']."' ");
				$product = $product->fetch();

			}else{

				$product = $show;

			}

			$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$product['category']."' ");

			$category = $category->fetch();

			$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($product['title'],"-",true)."?id=".$product['sorting_id'];

			$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$product['user_id']."' ");
			$user = $user->fetch();

			$order = $this->db()->query("SELECT sum(total_order) as TotalOrder FROM db_orders WHERE product_id='".$product['product_id']."' and status > 0");
			$order = $order->fetch();

			$stok = $product['stock'] - $order['TotalOrder'];

			if($stok <= 0){

				$stok = "<b style='color:#ff0000'>Out of stock</b>";

			}

			if($product['status'] == 1) $status = '<img style="cursor:pointer;" sort-id="'.$product['sorting_id'].'" onClick="set_status(this)" src="'.sourceUrl().'/img/on.png" width="62">';

			else $status = '<img style="cursor:pointer;" sort-id="'.$product['sorting_id'].'" onClick="set_status(this)" src="'.sourceUrl().'/img/off.png" width="62">';

			$get_discount = $this->db()->query("SELECT * FROM db_product_discount WHERE product_id='".$product['sorting_id']."' ");

			$show_discount = $get_discount->fetch();

			$discount = null;
			$discount_price = "Rp ".number_format($product['price']);

			if($get_discount->rowCount() > 0){

				if((time() >= $show_discount['start_time']) and (time() < $show_discount['end_time'])){

					$total_discount = ceil(($show_discount['price'] * 100 / $product['price']));
					$discount_price = "<span style='text-decoration:line-through;color:#666'><span style='color:#999'>Rp ".number_format($product['price'])."</span></span> ( Rp ".number_format($product['price'] - $show_discount['price'])." )";
					$discount = "<span style='color:orangered;border:1px orangered solid;border-radius:10px;padding:5px' >Discount ".$total_discount."%</span>";
				}
			}

			?>

			<tr>
				<td>
					<p style='font-family: Segoe UI Bold;font-size: 12px'>#<?php echo $product['product_id']?></p>
					<p>
						<a style="color:#434343;" href="<?php echo $url ?>"><?php echo $product['title']?></a><br>

						<?php if(userinfo()->level > 2){ ?>
						<a style="color:#09f;font-size:12px;" href="<?php echo HomeUrl()?>/adminpanel/money?q=<?php echo $product['product_id']?>">(Detail Income)</a>
						<?php } ?>

					</p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Stock Tersisa : </span> <?php echo $stok ?></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Post By : </span><?php echo ucwords($user['first_name']." ".$user['last_name'])?> <span style="font-family: 'Segoe UI Regular';font-size:12px;color:#666;margin-left:10px;"><a style="color:#09f;" href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user['username']?>">(@<?php echo $user['username']?>)</span></a></p>
					<p style="font-size:12px;color:orangered"><span style='font-family: Segoe UI Bold;color:#000'>Price : </span><?php echo $discount_price?></p>

					


	
				</td>
				<td><p style="color: orangered;font-family: Segoe UI Bold;"><?php echo $category['title']?></p></td>
				<td><p style="font-size:13px;"><?php echo date("d/y/Y", $product['date_time'])?></p>

					<p><?php echo $discount?></p></td>
				<td><?php echo $status?></td>
				<td>
					<img onClick="window.location='<?php echo HomeUrl()."/adminpanel/editproduct?id=".$product['sorting_id']?>';" style="cursor:pointer" src="<?php echo sourceUrl()?>/img/edit.png" width="22">
					<img onClick="delete_product(<?php echo $product['sorting_id']?>,'delete_product')" src="<?php echo sourceUrl()?>/img/bin.png" width="22" style="cursor: pointer;">
					
				</td>
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php 
		if($this->get("discount") == "true")
		echo $this->pagination(true,"db_product_discount","product");
		else
		echo $this->pagination(true,"db_product","product") ?>
	</div>
		
</div>
<?php } ?>