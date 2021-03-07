
<?php 

if(!empty($this->get("action"))){

	$query = $this->db()->query("SELECT * FROM db_users WHERE username='".$this->get("chat_to")."' ");
	$show = $query->fetch();

	save_activity("melakukan percakapan dengan username <b>".$show['username']."</b>");

	$query_handle = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
	$show_handle = $query_handle->fetch();

	if(!isset($show_handle['handle_by'])) $show_handle['handle_by'] = null;

	$user_handle = $this->db()->query("SELECT * FROM db_users WHERE id='".$show_handle['handle_by']."' ");

	$user_handle = $user_handle->fetch();

	
	if(!isset($user_handle['username'])) $user_handle['username'] = null;

	if($show_handle['handle_by'] !== userinfo()->user_id){

		$username_active = $user_handle['username'];

	}else $username_active = null;


	if($show_handle['handle_by'] > 0){

		if($show_handle['handle_by'] == userinfo()->user_id){

			$allow_chat = true;

		}

	}

}

if(!empty($this->get("id"))){


	$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
	$show  = $query->fetch();

	if($query->rowCount() == 0){

		header("location:".HomeUrl()."/adminpanel/orders");
		exit;
	}


	$product = $this->db()->query("SELECT * FROm db_product WHERE product_id='".$show['product_id']."' ");
	$product = $product->fetch();

	$picture = json_decode($product['picture']);

	$shipping_data = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."' ");
	$shipping_data = $shipping_data->fetch();

	$destination = $this->db()->query("SELECT * FROM db_destination_address WHERE id='".$show['destination']."'");
	$destination = $destination->fetch();

	$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$show['pay_with']."' ");
	$bank = $bank->fetch();

	$total_price = $show['total_order'] * $show['price'];
	$total_cost = $total_price + $shipping_data['price'];
	$total_cost = number_format($total_cost);
	$total_price = number_format($total_price);

	if(empty($show['resi_number'])) $show['resi_number'] = " Belum Tersedia";


	if(empty($show['note_order'])) $show['note_order'] = "Tidak ada catatan";

	if(($show['status'] == 0)) $status = "Menunggu Pembayaran";
	elseif(($show['status'] == 1)) $status = "Menunggu Konfirmasi";
	elseif(($show['status'] == 2)) $status = "Pesanan Diproses";
	elseif(($show['status'] == 3)) $status = "Pesanan Telah Dikirim";
	elseif(($show['status'] == 4)) $status = "Pesanan Telah Tiba";
	elseif(($show['status'] == 5)) $status = "Melakukan Komplain";
	elseif(($show['status'] == 8)) $status = "Pesanan Selesai";
	elseif(($show['status'] == 9)) $status = "Pesanan Dibatalkan";

	$check_order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");

	if($check_order->rowCount() == 0){

		echo "<script>alert('Tidak ditemukan');window.location='".HomeUrl()."/adminpanel/orders';</script>";
		exit;

	}

	$new_cond = "and chat_object='".$this->get('id')."' and chat_type = 1";
	$new_cond2 = "and chat_object > 0 and chat_type = 1 and chat_object='".$this->get('id')."' ";
	$display = "none;";
	$note = "Live chat ini adalah sarana diskusi anatara penjual dengan pembeli guna menyelesaikan maslah dan memperoleh kesepakatan bersama mengenai komplain yang customer ajukan";
	$height = "490px;";

}else{
	$new_cond = null;
	$new_cond2 = null;
	$display = null;
	$note = "Fitur ini hanya dapat melakukan komunikasi 2 arah antara customer dengan admin dan tidak di khususkan untuk berkomunikasi nantar cutomer. Customer dan admin akan mendapatkan notifikasi pemberitahuan pesan masuk melalui email apabila ada pesan terbaru";
	$username_active = null;
	$height = "420px;";
}

?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><?php echo $note?></p>

<?php if(!empty($this->get("id"))) { ?>
<div class="list-chat-box" style="border: none;overflow-y: unset;height:auto">
	<table width="100%" style="margin-top:-20px;">


	<tr>
		<td valign="top" style="width: 450px;">
			
			<p style="font-family: 'Segoe UI Regular';font-size: 13px;float: left;width: 70px;margin-right:10px">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:60px;height:60px;border:1px #ddd solid;border-radius: 5px;margin-top:10px;">
					</p>

					<p style="font-family: 'Segoe UI Regular';font-size: 13px;float: left;">
						<p style="font-size:16px;margin-top:25px;"><a style="color:#09f;font-family: 'Segoe UI Bold';" href=""><?php echo $product['title']?></a></p>
						<p style="color:orangered;margin-top:-10px;font-size: 13px;">Rp <?php echo number_format($show['price'])?><span style="color:#666;font-size:12px;margin-left:5px;">x <?php echo $show['total_order']?> Product ( <?php echo number_format($product['weight'])?> Gr )</span></p>
						
					</p>

			<p style="font-family: 'Segoe UI Bold';float: left;width: 100%;color:#434343">Alasan Komplain</p>	
			<p style="border:3px orangered solid;padding: 5px;width: 100%;float: left;border-radius: 4px;background: #f9f9f9;margin-top:-10px"><?php echo $show['note_complain']?></p>
					

		</td>

		</tr>

		<tr>
			<td valign="top">
				<p style="font-size: 13px;color:#666;">Nomor Invoice</p>
				<p style="font-family: 'Segoe UI Bold';margin-top:-10px;color:#09f;cursor: pointer;" onclick="window.location='<?php echo HomeUrl()?>/adminpanel/lihatorder?id=<?php echo $this->get("id")?>';">#<?php echo $show['invoice_id']?></p>

				<p style="font-size: 13px;color:#666;">Status</p>
				<p style="font-family: 'Segoe UI Bold';margin-top:-10px;color:#434343"><?php echo $status?></p>


				<p style="font-size: 13px;color:#666;">Tanggal Pembelian</p>
				<p style="font-family: 'Segoe UI Bold';margin-top:-10px;color:#434343"><?php echo date("d M Y H:i",$show['start_time'])?> WIB</p>

				<?php if($show_handle['handle_by'] > 0){ ?>
				<p style="color:#666;font-style: italic;">Komplain di tangani oleh <a style="font-family: 'Segoe UI Bold';color:#09f" href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user_handle['username']?>"><?php echo ucwords($user_handle['first_name']." ".$user_handle['last_name'])?></a></p>

				<?php if(($show['status'] > 5) and ($show['status'] < 9)){  ?>

					<p style="color:green;font-style: italic;font-family: 'Segoe UI Bold';">Komplain Selesai</p>

				<?php } }?>

			</td>

		</tr>
	
		
</table>
</div>

<?php } ?>

<div class="list-chat-box" style="display: <?php echo $display?>">
	<div class="list-chat" style="box-shadow: none;">

		<?php

		if(!empty($this->get("chat_to"))){

			$query = $this->db()->query("SELECT * FROM db_users WHERE username='".$this->get("chat_to")."' ");
			$show = $query->fetch();
			save_activity("melakukan percakapan dengan username <b>".$show['username']."</b>");

			if(!empty($this->get("id"))) $cond = "chat_type='1' and ";
			else $cond = "chat_type='0' and";

			$check = $this->db()->query("SELECT * FROM db_chats WHERE 
				($cond user_id = '".$show['id']."' and sender_id = '".userinfo($username_active)->user_id."' $new_cond) or 
				($cond user_id = '".userinfo($username_active)->user_id."' and sender_id = '".$show['id']."' $new_cond)

				ORDER BY id DESC");



			if($check->rowCount() == 0){
	

			$time = "Just Now";

			if(empty($show['profile_pict']) or ($show['profile_pict'] == "")){

				if(strtolower($show['gender']) == "perempuan")
				$pict = sourceUrl()."/img/woman.png";
				else
				$pict = sourceUrl()."/img/man.png";
				
			}else $pict = sourceUrl()."/usr_pict/".$show['profile_pict'];


			$chat_data = $check->fetch();

			if(!empty($this->get("id")))
			$click_id = $show['username']."-".$this->get("id");
			else
			$click_id = $show['username'];


			


		?>

		<div class="list-data" id="<?php echo $click_id?>" user_id="<?php echo $show['id']?>" room="<?php echo time()?>" name="<?php echo $show['first_name'] ?> <?php echo $show['last_name'] ?>" img="<?php echo $pict ?>" date="<?php echo $time ?>" username="@<?php echo $show['username']?>" onClick="return load_chat(this)" style="cursor:pointer;background:#f5f5f5">

			<img src="<?php echo $pict?>" width="50" height="50">

			<p class="user-name"><?php echo strip_tags($show['first_name'])?> <?php echo strip_tags($show['last_name'])?> 
				<span class="time"><?php echo $time ?></span>
			</p>

			<p class="chat chatz">Start chat ...</p>

		

		</div>

	<?php } } ?>


	<?php

	$command = "SELECT * FROM db_chats WHERE (sender_id = '".userinfo($username_active)->user_id."' or user_id = '".userinfo($username_active)->user_id."') $new_cond2 GROUP BY room ORDER BY room DESC";
	$query = $this->db()->query($command);

	$response = 0;
	$sigma_alert = 0;
	while($show = $query->fetch()){ 

	if($show['sender_id'] == userinfo($username_active)->user_id){
		$usr = "SELECT * FROM db_users WHERE id='".$show['user_id']."'";
		$usr = $this->db()->query($usr);
		$usr = $usr->fetch();

		$check_chat = "SELECT * FROM db_chats WHERE user_id='".$usr['id']."' and room='".$show['room']."' $new_cond ORDER BY id DESC";
		$check_chat = $this->db()->query($check_chat);
		$fetch_chat = $check_chat->fetch();
		$rows_count = $check_chat->rowCount();

		$sum_alert = $this->db()->query("SELECT * FROM db_chats WHERE sender_id='".$usr['id']."' and room='".$show['room']."' $new_cond and status='0' ");
		$sum_alert = $sum_alert->rowCount();



	}

	if($show['user_id'] == userinfo($username_active)->user_id){
		$usr = "SELECT * FROM db_users WHERE id='".$show['sender_id']."'";
		$usr = $this->db()->query($usr);
		$usr = $usr->fetch();

		$check_chat = "SELECT * FROM db_chats WHERE sender_id='".$usr['id']."' and room='".$show['room']."' $new_cond ORDER BY id DESC";
		$check_chat = $this->db()->query($check_chat);
		$fetch_chat = $check_chat->fetch();
		$rows_count = $check_chat->rowCount();

		$sum_alert = $this->db()->query("SELECT * FROM db_chats WHERE sender_id='".$usr['id']."' and room='".$show['room']."' $new_cond  and status='0' ");
		$sum_alert = $sum_alert->rowCount();
	}

	$sigma_alert += $sum_alert;

	$last_chat = "SELECT * FROM db_chats WHERE (sender_id = '".userinfo($username_active)->user_id."' or user_id = '".userinfo($username_active)->user_id."') and room='".$show['room']."' $new_cond ORDER BY id DESC";
	$last_chat = $this->db()->query($last_chat);
	$last_chat = $last_chat->fetch();


	$time_history = timeHistory($fetch_chat['date_time'],true,"hour");

	if($time_history > 24 ) $time = date("d/m/Y",$last_chat['date_time']);

	else $time = date("H:i",$last_chat['date_time']);

	

		if(empty($usr['profile_pict']) or ($usr['profile_pict'] == "")){

			if(strtolower($usr['gender']) == "perempuan")
			$pict = sourceUrl()."/img/woman.png";
			else
			$pict = sourceUrl()."/img/man.png";
			
		}else $pict = sourceUrl()."/usr_pict/".$usr['profile_pict'];

	if(($show['chat_type'] > 0) and (empty($this->get("id")))){

		$pict = sourceUrl()."/media/complain.png";

	}

	$data_order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$show['chat_object']."'");
	$data_order = $data_order->fetch();

	if($show['chat_type'] < 1){
	
		$user_name = strip_tags($usr['first_name'])." ".strip_tags($usr['last_name']);
		$url_chat = HomeUrl()."/adminpanel/message?chat_to=".$usr['username'];

	}else{

	$user_name = "#".$data_order['invoice_id'];
	$url_chat = HomeUrl()."/adminpanel/message?chat_to=".$usr['username']."&action=complain&id=".$data_order['sorting_id']."#".$usr['username'];

	}

	if(($this->get("chat_to") == $usr['username']) and ($show['chat_type'] == 0)) $bg="background:#f5f5f5";
	else $bg = null;

	if($show['chat_type'] == 0) $click_id = $usr['username'];
	if($show['chat_type'] == 1) $click_id = $usr['username']."-".$show['chat_object'];

	if(!isset($data_order['status'])) $data_order['status'] = null;

	if(!empty($this->get("id")) or ($data_order['status'] < 8)){
	$response += 1;

	?>
		<span id="<?php echo $click_id?>" user_id="<?php echo $usr['id']?>" room="<?php echo $show['room']?>" name="<?php echo $usr['first_name'] ?> <?php echo $usr['last_name'] ?>" username="@<?php echo $usr['username']?>" img="<?php echo $pict ?>" date="<?php echo $time ?>" onClick="return load_chat(this)" alert-el="<?php echo $click_id?>" style="display:none"></span>

		<div class="list-data" onclick="window.location='<?php echo $url_chat?>';" style="cursor:pointer;<?php echo $bg?>;">

			<img src="<?php echo $pict?>" width="50" height="50">

			<p class="user-name"><?php echo $user_name ?>

				<?php if((check_online($usr['id']) == "online") and ($show['chat_type'] < 1)){ ?>
				<span style="background: #5bbd5f;color:#fff;padding: 2px;font-size:8px;border-radius: 10px;">Online</span>
				<?php } ?>
				<span class="time"><?php echo $time?></span>
			</p>

			<p class="chat chatz-<?php echo $click_id?>" style="min-height: 8px;"><?php 

			if(empty($last_chat['chat'])){

				if($last_chat['sender_id'] !== userinfo($username_active)->user_id){
				echo "<span style='color:#22ba54'></span>
				<span ><img src='".sourceurl()."/img/rpl.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;'>
					<img src='".sourceurl()."/img/img-icon.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;margin-left:25px;'><span style='margin-left:50px;'>Send picture</span></span>";
				}else{

				echo "<span style='color:#22ba54'></span>
				<span ><img src='".sourceurl()."/img/img-icon.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;'><span style='margin-left:25px;'>Send picture</span></span>";
				}
			
			}else{

				if($last_chat['sender_id'] !== userinfo($username_active)->user_id){
				echo "<span style='color:#22ba54'></span>

					<span><img src='".sourceurl()."/img/rpl.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;'>";

				echo "<span style='margin-left:25px;'>".stringLimit(strip_tags($last_chat['chat']),27," ...")."</span></span>";
				
				}else{

				echo "<span style='color:#22ba54'></span>
				<span >".stringLimit(strip_tags($last_chat['chat']),27," ...")."</span>";

				}
			}
			?></p>

			<?php if($sum_alert !== 0){ ?>
			<div class="alert alert-<?php echo $click_id?>"><?php echo $sum_alert ?></div>
			<?php } ?>

		</div>

	<?php }}

	$_SESSION['last_list_msg'] = $sigma_alert;

	if(isset($response) and ($response == 0)) {?>
	<div style="padding: 10px;text-align: center;height:283px;margin-top: 80px;">
		<img src="<?php echo sourceurl()?>/media/cb.png" style="width: 150px;">
		<p style="font-family: 'Segoe UI Bold';">Tidak Ada Percakapan</p>
		<p style="color:#666;font-size:13px;margin-top:-5px;">Cek menu users untuk memulai percakapan dengan orang lain</p>
		<a href="<?php echo HomeUrl()?>/adminpanel/users"><button class="btn-white">List Users</button></a>
	</div>
<?php }	 ?>

	</div>
</div>


<?php if((isset($allow_chat) and ($show_handle['status'] <= 5)) or (empty($this->get("id"))) or ($show_handle['handle_by'] == 0)) $height = null;?>

<div class="chat-box" style="height: <?php echo $height?>">
	<div class="header" style="display: none;">
		<img src="<?php echo sourceUrl()?>/img/mark.jpg">
		<p class="title"><span id="title-username">Mark Zuckerberg</span> <span id="chat-username" style="font-family: 'Segoe UI Regular';font-size:13px;color:#f5f5f5;text-shadow: 2px 2px 3px rgba(14,6,4,0.52);margin-left:5px;">e</span></p>

		<p class="typing time" style="display: none;">Under Typing ...</p>

		<p class="time times finish-typing">14/03/2019</p>
	</div>

	
	<div class="top-box" id="chat-list"  status="<?php echo $this->get("id")?>">
		<span id="chat-data-list"></span>
	</div>

	<?php if((isset($allow_chat) and ($show_handle['status'] <= 5)) or (empty($this->get("id"))) or ($show_handle['handle_by'] == 0)) { ?>
	<div class="input-chat" style="display: none;">

		<form method="POST" id="form" chat_type="<?php echo $this->get("action")?>" onSubmit="return send_chat(this)">
			<textarea onKeyup="return typing_send()" class="form-input" style="width: 92%;border-radius: 3px;height:25px;" placeholder="Type Message ..."></textarea>

			<img src="<?php echo sourceUrl()?>/img/img-upload.png" width="30" style="margin-top:10px;cursor:pointer" onClick="click_upload('file-upload')">

			<button class="btn-white" style="float: right;margin-right:15px;margin-top:10px;">
			Send Message
			</button>
		</form>

	</div>
	<?php } ?>
	
</div>

<div id="preview-upload" class="upload-hover">

	<img class="img-thumbnail" src="<?php echo sourceUrl()?>/img/close.png" width="30" onClick="close_preview()">

	<form method="POST" id="upload-image" enctype="multipart/form-data">
		
		<input type="file" id="file-upload" name="file-upload" style="display: none;">
		<div style="width: 600px;margin:auto;margin-top:100px">
			<img id="img-prev" src="<?php echo sourceurl()?>/chat/mark.jpg" width="600" class="show-img-prev">
		</div>
		<div style="width: 600px;margin:auto;">
			<input class="form-input input-img" name="chat" placeholder="Tambah Keterangan"/>
			<input class="uid" name="user_id" value="" style="display: none;" />
			<input class="room" name="room" value="" style="display: none;" />
			<input class="utp" name="type" value="send" style="display: none;" />
			<input class="utp" name="order_id" value="<?php echo $this->get("id")?>" style="display: none;" />
			<input class="chat_type" name="chat_type" value="<?php echo $this->get("action")?>" style="display: none;">
			<button class="btn-white" style="float: right;margin-right:3px;margin-top:20px;padding:5px;cursor: pointer;" type="submit">Kirim</button>
		</div>
	</form>
</div>

<?php 
if(!isset($show_handle['handle_by'])) $show_handle['handle_by'] = 0;
if(!isset($show_handle['status'])) $show_handle['status'] = 10;

if(($show_handle['handle_by'] == userinfo()->user_id)  and ($show_handle['status'] < 9) and ($show_handle['status'] == 5)){ ?>
<p style="padding-top:10px;font-family: 'Segoe UI Bold';width: 100%;float: left;border-top:1px #ddd solid;">Pilih solusi yang di sepakati</span></p>

<div style="border:1px #ddd solid;padding:5px;float: left;width: 98.5%;margin-top:10px;border-radius: 5px;background: #f6f6f6">
<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/verifikasi_order?id=<?php echo $show_handle['sorting_id']?>" enctype="multipart/form-data">
<table width="100%">
	<tr>

		<td>
			<div style="margin-top:30px;float:left;margin-top: 10px;">
				<label class="cb-container"> Resolve
				  <input type="checkbox" name="verifikasi" value="resolve" class="cbx" checked="">
				  <span class="checkmark"></span>
				</label>
			</div>

			<div style="margin-top:30px;float:left;margin-left:40px;margin-top: 10px;">
				<label class="cb-container"> Refund
				  <input type="checkbox" name="verifikasi" value="refund" class="cbx">
				  <span class="checkmark"></span>
				</label>
			</div>
			
			<div style="margin-top:10px;float:left;width: 100%;float: left;">
			<p style="padding-top:10px;border-top:2px #ddd dashed;font-family: 'Segoe UI Bold';">Catatan <span style="color:#666;font-size:11px;"> ( * Catatan hasil negosiasi dengan customer )</span></p>


			<textarea class="form-input" name="note"></textarea>
			</div>

		</td>
		</tr>

	<tr>
	
		<td><p><button class="btn-white">Selesaikan Komplain</button></p></td>
	</tr>
</table>

</form>
</div>
<?php }elseif(!empty($this->get("id"))){ ?>
<div style="border:1px #ddd solid;padding:5px;float: left;width: 98.5%;margin-top:10px;border-radius: 5px;background: #f6f6f6">
	<p>Silahkan reload halaman jika form input hasil komplain tidak muncul</p>
</div>
<?php } ?>
<?php if(($show_handle['status'] > 5) and ($show_handle['status'] < 9)){ 

$check_result = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$this->get('id')."' and type > 5 and type < 8 ");
$check_result = $check_result->fetch();

if($check_result['type'] == 6) $resolve = "checked"; else $resolve = null;
if($check_result['type'] == 7) $refund = "checked"; else $refund = null;

?>
<p style="padding-top:10px;font-family: 'Segoe UI Bold';width: 100%;float: left;border-top:1px #ddd solid;">Pilih solusi yang di sepakati</span></p>

<div style="border:1px #ddd solid;padding:5px;float: left;width: 98.5%;margin-top:10px;border-radius: 5px;background: #f6f6f6">
<table width="100%">
	<tr>

		<td>
			<div style="margin-top:30px;float:left;margin-top: 10px;">
				<label class="cb-container"> Resolve
				  <input type="checkbox" disabled <?php echo $resolve ?>>
				  <span class="checkmark"></span>
				</label>
			</div>

			<div style="margin-top:30px;float:left;margin-left:40px;margin-top: 10px;">
				<label class="cb-container"> Refund
				  <input type="checkbox" disabled <?php echo $refund ?>>
				  <span class="checkmark"></span>
				</label>
			</div>
			
			<div style="margin-top:10px;float:left;width: 100%;float: left;">
			<p style="padding-top:10px;border-top:2px #ddd dashed;font-family: 'Segoe UI Bold';">Catatan <span style="color:#666;font-size:11px;"> ( * Catatan hasil negosiasi dengan customer )</span></p>


			<textarea class="form-input" disabled=""><?php echo $show_handle['note_deal_complain']?></textarea>
			</div>

		</td>
		</tr>

</table>

</div>
<?php } ?>

<div style="float: left;height: 20px;width: 100%"></div>