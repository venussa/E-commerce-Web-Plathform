
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px;font-style: italic;">"Halaman ini untuk mengetahui detail dari order yang masuk. Anda dapat memverifikasi order juga pada halaman ini"
</p>

<div style="width: 97%;margin-bottom: 20px;float: left;background: #f5f5f5;padding: 10px;border:1px #ddd solid;">
<?php

	$order_type = $this->db()->query("SELECT * FROM db_order_type ORDER BY type ASC");

	while($indicator = $order_type->fetch()){ 

	?>

	<div onClick="window.location='<?php echo HomeUrl() ?>/adminpanel/orders?q=t<?php echo $indicator['type']?>';" style="margin-left:10px;cursor: pointer;"><button title="<?php echo $indicator['msg']?>" class="circle-progres-small" style="cursor: pointer;border: 2px <?php echo $indicator['color']?> solid;background: <?php echo $indicator['color']?>;width: auto;float: none;width: 20px;height:20px;"><b><?php echo $indicator['type']?></b></button>
		<span style="font-size: 13px;"><?php echo $indicator['msg']?></span>
	</div>


	<?php } ?>
</div>

<span style="float: left;font-family: Segoe UI Bold;margin-right: 10px;">Filter By : </span>
<select id="month" class="tb-search" style="float: left;width: 100px;margin-right:10px;">
	
	<?php if(!empty($this->get("m"))){ ?>

		<option><?php echo $this->get("m")?></option>

	<?php }else{ ?>

		<option></option>

	<?php } ?>
	
	<?php for($i = 1; $i <= 12; $i++){ 

		if($this->get("m") !== monthConvert($i,1)){
		?>
		<option><?php echo monthConvert($i,1)?></option>
	<?php } }?>

</select>

<select id="years" class="tb-search" style="float: left;width: 100px;margin-right:10px;">
	<?php if(!empty($this->get("y"))){ ?>

		<option><?php echo $this->get("y")?></option>

	<?php }else{ ?>

		<option></option>
		
	<?php } ?>
	<?php for($i = 2019; $i <= date("Y")+1; $i++){ ?>

		<?php if($this->get("y") !== (String) $i) { ?>
		<option><?php echo $i?></option>

	<?php } } ?>
</select>
<button class="btn-white" onClick="order_filter('month','years','<?php echo $this->get("q")?>')" style="padding:6px;">Filter</button>

<form method="get" action="<?php echo HomeUrl()?>/adminpanel/orders" style="float:right">
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			<tr>
				<th style="width: 100px;">Invoice</th>
				<th style="width: 300px;">Product</th>
				<th>Buyer</th>
				<th style="width: 170px;">Total Order</th>
				<th style="width: 100px;">Action</th>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_orders","orders");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

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

			$price = $show['total_order'] * $show['price'] ;
			$price = $price + $shipping_data['price'];
			$price = number_format($price);

			?>

			<tr>
				<td valign="top">
					<p style="font-size: 13px;">#<?php echo $show['invoice_id']?></p>
					<p style="font-size: 11px;">( <?php echo date("d/m/Y",$show['start_time'])?> )</p>
					<p style="font-size:12px;font-family: Segoe UI Bold;"><a style="color:#09f;font-family: Segoe UI Bold;" href="<?php echo HomeUrl()?>/adminpanel/bank?q=<?php echo explode(" ",$bank['bank_name'])[1]?>"><?php echo $bank['bank_name']?></a></p>
				</td>
				<td>
					<p style="font-family: Segoe UI Bold;"><a style="color:#09f;font-family: Segoe UI Bold;" href="<?php echo HomeUrl()?>/adminpanel/product?q=<?php echo $show['product_id']?>"><?php echo $product['title']?></a></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Product Id : <span><?php echo $product['product_id']?></p>
					<p style="font-size:12px;"><span style='font-family: Segoe UI Bold;'>Price : </span><span style="color:orangered">Rp <?php echo number_format($show['price'])?></span></p>

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
				<td valign="top" style="width: 100px;"><p><?php echo ucwords($user['first_name']." ".$user['last_name']) ?><span style="color:#666;font-size:12px;"> <a style="color:#09f;" href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user['username']?>">(@<?php echo $user['username']?>)</a></span></p></td>
				<td valign="top">
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

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_orders","orders") ?>
	</div>
		
</div>
<?php } ?>