<?php
if(userinfo() == false) die("Access Danied");
if(userinfo()->level < 2) die("Access Danied");
if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
	role_access("income", "6");
}
?>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px;font-style: italic;">"Halaman menyajikan ringkasan pemasukan"</p>

<form method="get" action="<?php echo HomeUrl()?>/adminpanel/money" style="float:right">
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			<tr>
				<th>Name</th>
				<th style="width: 200px;">Detail</th>
				<th style="width: 150px;">Total Pemasukan</th>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_product","money");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_product ".$paging->condition." ORDER BY sorting_id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/pending.png" style="width: 150px;">
						<p style="font-family: 'Segoe UI Bold';font-size: 18px;">Ringkasan Tidak Ditemukan</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){

			$orders = $this->db()->query("SELECT sum(total_order) as TotalOrder FROM db_orders WHERE product_id='".$show['product_id']."' and status >= 0 and status != 9");
			$order = $orders->fetch();

			$pending = $this->db()->query("SELECT * FROM db_orders WHERE product_id='".$show['product_id']."' and status >= 0 and status < 2");

			$order_finish = $this->db()->query("SELECT * FROM db_orders WHERE product_id='".$show['product_id']."' and status > 1  and status != 9");

			$pending_stock = $this->db()->query("SELECT sum(total_order) as TotalOrder FROM db_orders WHERE product_id='".$show['product_id']."' and status >= 0 and status < 2");

			$pending_stock = $pending_stock->fetch();

			$send_stock = $this->db()->query("SELECT sum(total_order) as TotalOrder FROM db_orders WHERE product_id='".$show['product_id']."' and status > 1 and status != 9");

			$send_stock = $send_stock->fetch();
			

			$income = $this->db()->query("SELECT sum(total_order) as TotalOrder,
				sum(price) as eachPrice FROM db_orders
			 WHERE product_id='".$show['product_id']."' and status >= 3 and status != 9 ");
			$income = $income->fetch();

			$shipping = $this->db()->query("SELECT SUM(price) AS price FROM db_delivery_service WHERE product_id='".$show['product_id']."' ");

			$shipping = $shipping->fetch();

			$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."'");
			$user = $user->fetch();

			$stock = $show['stock'] - $order['TotalOrder'];

			$price = $income['TotalOrder'] * $income['eachPrice'];
			$price = $price + $shipping['price'];

			
			$price = number_format($price);

			$ordered = $pending->rowCount();

			$pending_stock = (int) $pending_stock['TotalOrder'];

			$send_stock = (int) $send_stock['TotalOrder'];

			$order_finish = $order_finish->rowCount();

			if($stock <= 0){

				$stock = "<b style='color:#ff0000'>Out of stock</b>";

			}


			?>

			<tr>
				<td valign="top">
					<p style="font-family: Segoe UI Bold;"><a style="color:#09f;font-family: Segoe UI Bold;" href="<?php echo HomeUrl()?>/adminpanel/product?q=<?php echo $show['product_id']?>"><?php echo $show['title']?></a></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Suplier : </span><?php echo ucwords($user['first_name']." ".$user['last_name']) ?> <span style="color:#666;font-size:12px;"> <a style="color:#09f;" href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user['username']?>">(@<?php echo $user['username']?>)</a></span></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Product Id : <span>#<?php echo $show['product_id']?></p>
					
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Stock : </span><?php echo $show['stock']?></p> 

						
					</td>
				
				<td>
					
				
				
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Order Tertunda : </span><?php echo $ordered?></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Order Terverifikasi : </span><?php echo $order_finish?></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Stok Tertunda : </span><?php echo $pending_stock?></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Stok Terkirim : </span><?php echo $send_stock?></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Stok Tersisa : </span><?php echo $stock?></p>
					
				</td>

				<td>
					<p style="font-size:15px;font-family: Segoe Ui Bold;color:orangered">Rp <?php echo $price?></p>
					<p><a href="<?php echo HomeUrl()?>/adminpanel/orders?q=<?php echo $show['product_id']?>" style="color:#09f;font-size:13px;">Lihat History Order</a></p>
				</td>
				
			</tr>

		<?php } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_product","money") ?>
	</div>
		
</div>
<?php } ?>