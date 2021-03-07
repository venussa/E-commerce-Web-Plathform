
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Selamat datang <b><?php echo ucwords(userinfo()->first_name." ".userinfo()->last_name) ?></b> di halaman khusus admin, anda memiliki level akses 
<?php switch(userinfo()->level){

	case "0":
		echo "<b>Customer</b>";
	break;

	case "1":
		echo "<b>Suplier</b>";
	break;

	case "2":
		echo "<b>Admin</b> yang mana anda dapat mengakses seluruh menu pada halaman ini. namun memiliki wewenang di bawah level administrator";
	break;

	case "3":
		echo "<b>Administrator</b> yang mana anda dapat mengakses seluruh menu pada halaman ini dan juga mempunya wewenang penuh atas kontrol website";
	break;

}?>
</p>

<?php 
$time = 300;
$post = $this->db()->query("SELECT * FROM db_product");
$customer = $this->db()->query("SELECT * FROM db_users WHERE (".time()." - online) < $time ");
$category = $this->db()->query("SELECT * FROM db_category WHERE level=0 and sublevel=0");
$pending = $this->db()->query("SELECT * FROM db_orders WHERE status > 0 and status < 2");
$finish = $this->db()->query("SELECT * FROM db_orders WHERE status = 8 ");
$complain = $this->db()->query("SELECT * FROM db_orders WHERE status = 5 ");
$cancel = $this->db()->query("SELECT * FROM db_cancel_order WHERE status=0");
$reqship = $this->db()->query("SELECT * FROM db_orders WHERE status=2");
$inship = $this->db()->query("SELECT * FROM db_orders WHERE status=3");
?>



<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;margin-right:14.5px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t1';">
	<img src="<?php echo HomeUrl()?>/sources/media/order.png">
	<p class="title">PAYMENT REQUEST</p>
	<p class="description"><?php echo number_format($pending->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;margin-right:14.5px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t5';">
	<img src="<?php echo HomeUrl()?>/sources/media/complain.png">
	<p class="title">COMPLAIN ORDER</p>
	<p class="description"><?php echo number_format($complain->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;margin-right:14.5px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t8';">
	<img src="<?php echo HomeUrl()?>/sources/media/cart2.png">
	<p class="title">FINISH ORDER</p>
	<p class="description"><?php echo number_format($finish->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;margin-right:0px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=request_cancel';">
	<img src="<?php echo HomeUrl()?>/sources/media/cancel.png">
	<p class="title">CANCEL REQUEST</p>
	<p class="description"><?php echo number_format($cancel->rowCount())?></p>
</div>

<div style="height: 110px;"></div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;margin-right:14.5px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t2';">
	<img src="<?php echo HomeUrl()?>/sources/media/reqship.png">
	<p class="title">DELIVERY REQUEST</p>
	<p class="description"><?php echo number_format($reqship->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;margin-right:14.5px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t3';">
	<img src="<?php echo HomeUrl()?>/sources/media/inship.png">
	<p class="title">IN SHIPPING</p>
	<p class="description"><?php echo number_format($inship->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;margin-right:14.5px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/product';">
	<img src="<?php echo HomeUrl()?>/sources/media/post.png">
	<p class="title">TOTAL PRODUCT</p>
	<p class="description"><?php echo number_format($post->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;margin-right:0px;">
	<img src="<?php echo HomeUrl()?>/sources/media/online.png">
	<p class="title">USER ONLINE</p>
	<p class="description"><?php echo number_format($customer->rowCount())?></p>
</div>




<div class="big-panel-box" style="margin-top:20px;width:100%;float:left;margin-right: 10px;">
<div class="title" style="border-radius: 0px;background: #f5f5f5;color:#434343;">Order Terbaru 
<span style="font-size: 10px;float: right;"><a href="<?php echo HomeUrl()?>/adminpanel/orders" style="color:#09f;margin-top:15px;position: relative;top:5px;">Selengkapnya >></a></span>
</div>
	<div class="list" style="border-top:1px #ddd solid">
		<table width="100%">
			<?php
			$paging = $this->pagination(false,"db_orders","orders");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = 5;

			$query = $this->db()->query("SELECT * FROM db_orders ".$paging->condition." ORDER BY sorting_id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){ ?>

				<tr><td colspan="5">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
					<img src="<?php echo sourceurl()?>/media/tf.png" style="width: 150px;">
					<p style="font-family: 'Segoe UI Bold';font-size: 18px;">Tidak ada order masuk</p>
					<p style="color:#666;font-size:13px;margin-top:-5px;">Silahkan periksa lagi lain kali</p>
					</div>

				</td></tr>

			<?php }else{  

			while($show = $query->fetch()){

			$shipping_data = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."' ");
			$shipping_data = $shipping_data->fetch();


			$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$show['product_id']."' ");
			$product = $product->fetch();

			$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."'");
			$user = $user->fetch();

			$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$show['pay_with']."' ");
			$bank = $bank->fetch();

			if($show['status'] == 0) $status = '<span class="order-cancel">Cancel</span>';
			if($show['status'] == 1) $status = '<span class="order-success">Ordered</span>';
			if($show['status'] == 2) $status = '<span class="order-pending">Pending</span>';
			if($show['status'] == 3) $status = '<span class="order-pay">Success</span>';
			if($show['status'] == 4) $status = '<span class="order-complete">Finish</span>';
			if($show['status'] == 5) $status = '<span class="order-complain">Complain</span>';

			$price = $show['total_order'] * $product['price'] ;
			$price = $price + $shipping_data['price'];
			$price = number_format($price);

			?>

			<tr>
				<td valign="top">
					<p style="font-size: 13px;">#<?php echo $show['invoice_id']?></p>
					<p style="font-size: 11px;">( <?php echo date("d/m/Y",$show['start_time'])?> )</p>
					<p style="font-size:12px;font-family: Segoe UI Bold;"><a style="color:#09f;font-family: Segoe UI Bold;" href="<?php echo HomeUrl()?>/adminpanel/bank?q=<?php echo explode(" ",$bank['bank_name'])[1]?>"><?php echo $bank['bank_name']?></a></p>
				</td>
				<td style="width: 300px;">
					<p style="font-family: Segoe UI Bold;"><a style="color:#09f;font-family: Segoe UI Bold;" href="<?php echo HomeUrl()?>/adminpanel/product?q=<?php echo $show['product_id']?>"><?php echo $product['title']?></a></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Product Id : <span><?php echo $product['product_id']?></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Price : </span><span style="color:orangered">Rp <?php echo number_format($product['price'])?></span></p>

					<p style="font-family: 'Segoe UI Bold';font-size:12px;margin-top:0px;">Status Pemesanan</p>
					<div style="float: left;width: 100%;height: 60px;margin-top:5px;margin-left: 10px;">
						
					<?php

					$log_order = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$show['sorting_id']."' ORDER BY type ASC");

					$sum = 1;
					while($show_log = $log_order->fetch()){ 

						$order_type = $this->db()->query("SELECT * FROM db_order_type WHERE type='".$show_log['type']."' ");
						$order_type = $order_type->fetch();

						?>

						<button title="<?php echo $order_type['msg']?>" class="circle-progres-small" style="border: 2px <?php echo $order_type['color']?> solid;background: <?php echo $order_type['color']?>"><b><?php echo $order_type['type']?></b></button>


						<?php $sum++;} ?>
					</div>
						
					</td>
				<td valign="top" style="width: 120px;"><p><?php echo ucwords($user['first_name']." ".$user['last_name']) ?><span style="color:#666;font-size:12px;"> <a style="color:#09f;" href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user['username']?>">(@<?php echo $user['username']?>)</a></span></p></td>
				<td valign="top" style="width: 180px;">
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Total Order : </span> <?php echo $show['total_order']?></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Shipping Cost : </span><span style="color: green">Rp <?php echo number_format($shipping_data['price'])?></span></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Total Price : </span><span style="color: orangered">Rp <?php echo $price?></span></p>
				</td>
				
				<td valign="top" onClick="window.location='<?php echo HomeUrl()."/adminpanel/lihatorder?id=".$show['sorting_id']?>';"style="cursor:pointer;font-size: 12px;">
					<p><img  src="<?php echo sourceUrl()?>/img/edit.png" width="22"> <br>Lihat / Verifikasi</p>
					
					
				</td>
			</tr>

		<?php } }?>

		</table>
	</div>
</div>

