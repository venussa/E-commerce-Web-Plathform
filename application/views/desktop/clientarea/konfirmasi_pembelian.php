
<?php
	
	$_SESSION['shipping'] = null;

	if(empty($this->post("cart_id"))){
		header("location:".HomeUrl()."/clientarea/keranjang_belanja");
		exit;
	}

	$check = $this->db()->query("SELECT * FROM db_cart WHERE id='".$this->post("cart_id")."' ");
	
	if(($check->rowCount() == 0) or (empty($this->post("product_id")))){

		header("location:".HomeUrl()."/clientarea/keranjang_belanja");
		exit;

	}

	$product = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->post("product_id")."' ");
	$product = $product->fetch();

	if($this->post("jumlah") < $product['min_order']) {

		echo "<script>alert('Minimal pembelian ".$product['min_order']." Product');window.location='".HomeUrl()."/clientarea/keranjang_belanja';</script>";
		exit;

	}

	$_SESSION['jumlah'] = $this->post("jumlah");

	$address = $this->db()->query("SELECT * FROM db_destination_address WHERE user_id='".userinfo()->user_id."' ORDER BY id ASC");
	$address1 = $this->db()->query("SELECT * FROM db_destination_address WHERE id='".$this->post("address_id")."' and user_id='".userinfo()->user_id."' ORDER BY id ASC");

	$shipping = $address1->fetch();


	$orders = $this->db()->query("SELECT sum(total_order) as TotalOrder FROM db_orders WHERE product_id='".$product['product_id']."' and status >= 0 and status != 9");
	
	$order = $orders->fetch();

	$ready_stock = $product['stock'] - $order['TotalOrder'];

	if($this->post("jumlah") > $ready_stock){

		echo "<script>alert('Stock Tidak Tersedia');window.location='".HomeUrl()."/clientarea/keranjang_belanja';</script>";
		exit;
		

	}

	$picture = json_decode($product['picture']);

	$get_discount = $this->db()->query("SELECT * FROM db_product_discount WHERE product_id='".$product['sorting_id']."' ");

	$show_discount = $get_discount->fetch();

	$discount = null;
	$discount_price = "Rp ".number_format($product['price']);
	$product_price = $product['price'];

	if($get_discount->rowCount() > 0){

		if((time() >= $show_discount['start_time']) and (time() < $show_discount['end_time'])){

			$product_price = $product['price'] - $show_discount['price'];
			$total_discount = ceil(($show_discount['price'] * 100 / $product['price']));
			$discount_price = "Rp ".number_format($product['price'] - $show_discount['price'])."<br><span style='text-decoration:line-through;font-size:11px;color:#666'><span style='color:#999;font-weight:400'>Rp ".number_format($product['price'])."</span></span> <span style='font-size:11px;color:#434343;font-weight:400'>-".$total_discount."%</span>";
			
		}
	}

	$origin = setting()->distributor_location;

	$destination_query = $this->db()->query("SELECT * FROM db_location WHERE name='".$shipping['province']."' and type='provinsi'");
	$destination_query = $destination_query->fetch();
	$destination = $destination_query["loc_id"];

	$destination1 = $this->db()->query("SELECT * FROM db_location WHERE parrent='$destination' and name='".$shipping['state']."' ");
	$destination1 = $destination1->fetch();
	$destination1 = $destination1['loc_id'];

	$delivery_service = delivery_cost($origin,$destination1,($product['weight'] * $this->post("jumlah")));

	$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$product['category']."'");
	$category = $category->fetch();

	$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($product['title'],"-",true)."?id=".$product['sorting_id'];

	$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type != 1 ");
	$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type=1 and status=1 ");
	$saldo = $saldo0['saldo'] + $saldo1['saldo'];


?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Pastikan anda melengkapi data dengan baik dan benar</i></p>
<p style="font-family: 'Segoe UI Bold';color:#434343">Alamat Pengiriman</p>

<div style="background: #f5f5f5;border: 1px #ddd solid;border-radius: 4px;padding: 5px;">
<?php $no = 1; while($show = $address->fetch()){?>



	<form method="POST" action="<?php echo HomeUrl()?>/clientarea/konfirmasi_pembelian" style="display: none;">
		<input type="text" name="product_id" value="<?php echo $this->post("product_id")?>" style="display: none;">
		<input type="text" name="cart_id" value="<?php echo $this->post("cart_id")?>" style="display: none;">
		<input type="text" name="jumlah" value="<?php echo $this->post("jumlah")?>" style="display: none;">
		<input type="text" class="new-addr-id" name="address_id" value="<?php echo $this->post("address_id")?>" style="display: none;">

		<?php if(!empty($this->post("code"))){?>

			<input type="text" name="code" value="<?php echo $this->post("code")?>" style="display: none;">
			<input type="text" name="company_name" value="<?php echo $this->post("company_name")?>" style="display: none;">
			<input type="text" name="service_name" value="<?php echo $this->post("service_name")?>" style="display: none;">
			<input type="text" name="service_description" value="<?php echo $this->post("service_description")?>" style="display: none;">
			<input type="text" name="time" value="<?php echo $this->post("time")?>" style="display: none;">
			<input type="text" name="invoice_id" value="<?php echo $this->post("invoice_id")?>" style="display: none;">
			<input type="text" name="shipping_price" value="<?php echo $this->post("shipping_price")?>" style="display: none;">
			<input type="text" name="delivery_service_id" value="<?php echo $this->post("delivery_service_id")?>" style="display: none;">

		<?php } ?>

		<button type="submit" style="display: none;" id="reload_ongkir"></button>
	</form>
	<p style="color: #666;font-size: 13px;">
	<?php if($show['id'] == $this->post("address_id")){ ?>

		<label class="cb-container"> <?php echo $show['address']?>, <?php echo $show['district']?><br><?php echo $show['state']?>, <?php echo $show['province']?>, <?php echo $show['zip_code']?> <br> Tlp : <?php echo $show['phone_number']?>
		  <input type="checkbox" class="address-list" name="alamat" value="<?php echo $show['id']?>" onClick="return reload_ongkir(this)" checked="">
		  <span class="checkmark"></span>
		</label>


	<?php }else{ ?>

		<label class="cb-container"> <?php echo $show['address']?>, <?php echo $show['district']?><br><?php echo $show['state']?>, <?php echo $show['province']?>, <?php echo $show['zip_code']?> <br> Tlp : <?php echo $show['phone_number']?>
		  <input type="checkbox" class="address-list" name="alamat" value="<?php echo $show['id']?>" onClick="return reload_ongkir(this)">
		  <span class="checkmark"></span>
		</label>

	<?php } ?>

	</p>

<?php $no++;  } ?>

</div>
<p align="right"><a href="<?php echo HomeUrl()?>/clientarea/alamat_pengiriman" style="color:#09f;float: right;font-size: 14px;margin-right:10px;">Tambah Alamat</a></p>

<p style="font-family: 'Segoe UI Bold';border-top:2px #ddd dashed;padding-top: 10px;margin-top: 50px;color:#434343">Informasi Barang</p>


<table width="100%">

	<tr>
		
		<td style="width: 180px;border-bottom: 2px #ddd dashed;padding-top:10px;" valign="top">
			<p><img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width: 160px;border:1px #ddd solid;padding:2px;"></p>
		</td>

		<td valign="top" style="border-bottom: 2px #ddd dashed;">

		
			<p style="font-size:18px;">
				<a style="font-family: 'Segoe UI Bold';color:#09f;" href="<?php echo $url?>"><?php echo strip_tags($product['title'])?></a></p>
			<p style="color:#666;font-size:14px;margin-top:-15px;font-size: 13px;">1 barang ( <?php echo $product['weight']?> gr) </p>
			<p style="color:orangered;font-family: 'Segoe UI Bold';font-size:14px;margin-top:-10px;"><?php echo $discount_price?></p>

			<p><textarea class="form-input" placeholder="Note kepada penjual" onKeyup="return write_note(this)"></textarea></p>
			
		</td>
	</tr>

</table>

<p style="font-family: 'Segoe UI Bold';padding-top: 10px;padding-bottom: 10px;margin-top: 10px;color:#434343">Jasa & Durasi Pengiriman</p>

<?php foreach($delivery_service as $key => $val){

	if($val->code == "pos"){

		$sn = explode(" ",$val->service_name);
		foreach ($sn as $key1 => $vals) {
			$str[] = str_split($vals)[0];
		}

		$val->service_name = strtoupper(implode("",$str));

	}

	?>
	<div style="padding:5px;border-bottom: 1px #ddd solid; width: 48.5%;float: left;height:100px">

		<?php
		$_SESSION['shipping'][] = $val->price;
		$shipping_price = $val->price;
		$code = $val->code;
		$company_name = $val->company_name;
		$service_name = $val->service_name;
		$service_description = $val->service_description;
		$time = explode("|",str_replace(" ",null,str_replace(["hari"],null,str_replace("-","|",$val->time))));
		$time = $time[count($time)-1];
		$invoice_id = time()+rand(1,250);
		$delivery_service_id = $key;

		if(empty($this->post("delivery_service_id"))){
			$math_id = 0;
		}else{
			$math_id = $this->post("delivery_service_id");
		}

		 if($key == $math_id){ 
		 $cost = $shipping_price;

		$shipping_price1 = $val->price;
		$code1 = $val->code;
		$company_name1 = $val->company_name;
		$service_name1 = $val->service_name;
		$service_description1 = $val->service_description;
		$time1 = explode("|",str_replace(" ",null,str_replace(["hari"],null,str_replace("-","|",$val->time))));
		$time1 = $time1[count($time1)-1];
		$invoice_id1 = time()+rand(1,250);
		$delivery_service_id1 = $key;

		 ?>

		 <label class="cb-container" style="position: absolute;margin-top:10px;">
		  <input type="checkbox" name="kurir" class="check_kurir" checked="" onClick="return reload_ongkir1(<?php echo $key?>)">
		  <span class="checkmark"></span>
		</label>

		<?php }else{?>

		<label class="cb-container" style="position: absolute;margin-top:10px;">
		  <input type="checkbox" name="kurir" class="check_kurir" onClick="return reload_ongkir1(<?php echo $key?>)">
		  <span class="checkmark"></span>
		</label>

		<?php }?>

		<form method="POST" action="<?php echo HomeUrl()?>/clientarea/konfirmasi_pembelian" style="display: none;">
		<input type="text" name="product_id" value="<?php echo $this->post("product_id")?>" style="display: none;">
		<input type="text" name="cart_id" value="<?php echo $this->post("cart_id")?>" style="display: none;">
		<input type="text" name="jumlah" value="<?php echo $this->post("jumlah")?>" style="display: none;">
		<input type="text" class="new-addr-id" name="address_id" value="<?php echo $this->post("address_id")?>" style="display: none;">

		<input type="text" name="code" value="<?php echo $code?>" style="display: none;">
		<input type="text" name="company_name" value="<?php echo $company_name?>" style="display: none;">
		<input type="text" name="service_name" value="<?php echo $service_name?>" style="display: none;">
		<input type="text" name="service_description" value="<?php echo $service_description?>" style="display: none;">
		<input type="text" name="time" value="<?php echo $time?>" style="display: none;">
		<input type="text" name="invoice_id" value="<?php echo $invoice_id?>" style="display: none;">
		<input type="text" name="shipping_price" value="<?php echo $shipping_price?>" style="display: none;">
		<input type="text" name="delivery_service_id" value="<?php echo $delivery_service_id?>" style="display: none;">


		<button type="submit" style="display: none;" id="reload_ongkir-<?php echo $key?>"></button>
		</form>


		<img src="<?php echo sourceUrl()."/img/".$val->code.".png"?>" style="width: 50px;position: absolute;margin-left:35px;margin-top:8px;">
		<p style="font-family: 'Segoe UI Bold';margin-left:99px;margin-top:2px;"><?php echo $val->company_name?></p>
		<p style="margin-left: 99px;color:#666;font-size:12px;margin-top:-5px;">Nama Paket : <?php echo $val->service_description." ( ".$val->service_name." )"?></p>
		<p style="margin-left: 99px;color:#666;font-size:12px;margin-top:-9px;">Lama Kirim : <?php echo str_replace("hari",null,strtolower($val->time))?> Hari</p>

		<?php if($product['transaction_scheme'] < 1){ ?>
		<p style="margin-left: 99px;color:orangered;font-size:12px;margin-top:-9px;font-family: 'Segoe UI Bold'">Rp <?php echo number_format($val->price)?></p>
		<?php } ?>

		</div>
	<?php } ?>



<?php if($product['transaction_scheme'] < 1){ ?>
<div style="float: left;width: 97.5%;background: #f5f5f5;padding-left:15px;border:1px #ddd solid;padding-bottom:15px;border-radius: 5px;margin-top: 30px;">
<p style="font-family: 'Segoe UI Bold';color:#434343;">Ringkasan Belanja</p>

<table width="100%">

	<tr>
		
		<td style="border-bottom:1px #ddd solid;padding:5px;color: #666;font-size: 14px;">Total Harga ( <?php echo $this->post("jumlah")?> Barang )</td>
		<td style="border-bottom:1px #ddd solid;padding:5px;color: #434343;font-size: 13px;font-family: 'Segoe UI Bold';text-align: right;">Rp <?php echo number_format(($this->post("jumlah") * $product_price))?></td>

	</tr>

	<tr>
		
		<td style="border-bottom:1px #ddd solid;padding:5px;color: #666;font-size: 14px;">Total Ongkos Kirim</td>
		<td style="border-bottom:1px #ddd solid;padding:5px;color: #434343;font-size: 13px;font-family: 'Segoe UI Bold';text-align: right;">Rp <?php echo number_format($cost)?></td>
		
	</tr>

	<tr>
		
		<td style="border-bottom:1px #ddd solid;padding:5px;color: #666;font-size: 14px;">Total Tagihan</td>
		<td style="border-bottom:1px #ddd solid;padding:5px;color: orangered;font-size: 13px;font-family: 'Segoe UI Bold';text-align: right;">Rp <?php echo number_format(($this->post("jumlah") * $product_price) + $cost)?></td>
		
	</tr>

		

</table>

</div>

<?php }?>

<div style="float: left;width: 98%;margin-top: -20px;">
<p style="font-family: 'Segoe UI Bold';border-top:2px #ddd dashed;padding-top: 10px;margin-top: 50px;color:#434343">Bayar Menggunakan</p>

<form method="POST" action="<?php echo HomeUrl()?>/clientarea/finish_order">
	<div>
	<?php 
		$query = $this->db()->query("SELECT * FROM db_pay_info");
		$sum = 1;
		while($show = $query->fetch()){ 

			if($sum == 1){
			$active_id = $show['id'];
		?>

			<img class="picture-bank" src="<?php echo sourceUrl()?>/bank/<?php echo $show['icon']?>" style="width:100px;height:50px;border-radius: 6px;border:6px orangered solid;padding:1px;cursor: pointer;margin-right: 10px" data="<?php echo $show['id']?>" onClick="return select_bank(this)">

			<?php }else{ ?>

			<img class="picture-bank" src="<?php echo sourceUrl()?>/bank/<?php echo $show['icon']?>" style="width:100px;height:50px;border-radius: 6px;border:1px #ddd solid;padding: 1px;cursor: pointer;margin-right: 10px" data="<?php echo $show['id']?>" onClick="return select_bank(this)">

		<?php } $sum++; } ?>
	</div>
	<input type="text" name="bank" id="bank-info" value="<?php echo $active_id?>" style="display: none;">

	<input type="text" name="product_id" value="<?php echo $this->post("product_id")?>" style="display: none;">
	<input type="text" name="cart_id" value="<?php echo $this->post("cart_id")?>" style="display: none;">
	<input type="text" name="jumlah" value="<?php echo $this->post("jumlah")?>" style="display: none;">
	<input type="text" class="new-addr-id" name="address_id" value="<?php echo $this->post("address_id")?>" style="display: none;">

	<input type="text" name="code" value="<?php echo $code1?>" style="display: none;">
	<input type="text" name="company_name" value="<?php echo $company_name1?>" style="display: none;">
	<input type="text" name="service_name" value="<?php echo $service_name1?>" style="display: none;">
	<input type="text" name="service_description" value="<?php echo $service_description1?>" style="display: none;">
	<input type="text" name="time" value="<?php echo $time1?>" style="display: none;">
	<input type="text" name="invoice_id" value="<?php echo $invoice_id1?>" style="display: none;">
	<input type="text" name="shipping_price" value="<?php echo $shipping_price1?>" style="display: none;">
	<input type="text" name="delivery_service_id" value="<?php echo $delivery_service_id1?>" style="display: none;">
	<textarea id="note" style="display: none;" name="note"></textarea>

	<p style="border-bottom: 1px #ddd solid;padding-bottom: 10px;color:#666">

		<?php if(wallet_system()){ ?>
		<label class="cb-container"> Bayar sebagian / penuh dengan saldo Dompet Digital jika mencukupi
		  <input type="checkbox" class="dompet_digital" name="wallet" value="1">
		  <span class="checkmark"></span>
		</label>
		<?php } ?>
		
		<label class="cb-container"> Dengan anda membeli ini, berarti anda menyetujui ketentuan dan ketentuan layanan yang kami tetapkan
		  <input type="checkbox" name="konfirmasi" required="">
		  <span class="checkmark"></span>
		</label>

	</p>

	<?php if(($product['transaction_scheme'] > 0)) { ?>

	<p style="font-size:11px;color:#666;">
		* Dalam menenuntukan biaya pengiriman yang dikenakan, kami akan melakukan pengukuran berat keseluruhan barang karena barang yang anda pesan membutuhkan media air yang mana kami harus menghitung valume dari air tersebut untuk mendapatkan berat total dari barang yang anda pesan. Total biaya yang harus anda bayar akan segera kami beritahukan melalui email atau anda dapat mengeceknya pada menu <a style="color:#09f" href="<?php echo HomeUrl()?>/clientarea/pembayaran_tertunda" target="_blank">pembayaran tertunda</a> dengan masa kerja Maksimal 1 x 24 Jam.
	</p>
	<?php } ?>
	<button class="btn-white" style="padding:10px;margin-top: 10px">Selesaikan Order</button>

</form>
</div>