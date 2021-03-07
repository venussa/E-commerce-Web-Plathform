<?php

$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."'");
$show  = $query->fetch();

if($query->rowCount() == 0){

	header("location:".HomeUrl()."/clientarea/komplain_pembelian");
	exit;
}

$discus = $this->db()->query("SELECT * FROM db_chats WHERE privacy='1' and chat_type='1' and chat_object='".$show['sorting_id']."' ");

if(($discus->rowCount() == 0) or ($show['status'] > 7)){

	header("location:".HomeUrl()."/clientarea/komplain_pembelian");
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

?>
<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Diskusi Komplain</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Periksan detail dari pesanan</i></p>

<table width="100%" class="data-table" id="<?php echo $this->get("id")?>">
	<tr>
		<td valign="top">
			<p style="font-size: 13px;color:#666;">Nomor Invoice</p>
			<p style="font-weight:600;margin-top:-10px;color:#434343">#<?php echo $show['invoice_id']?></p>

			<p style="font-size: 13px;color:#666;">Status</p>
			<p style="font-weight:600;margin-top:-10px;color:#434343"><?php echo $status?></p>


			<p style="font-size: 13px;color:#666;">Tanggal Pembelian</p>
			<p style="font-weight:600;margin-top:-10px;color:#434343"><?php echo date("d M Y H:i",$show['start_time'])?> WIB</p>
		</td>

	</tr>
	<tr>
		<td valign="top" style="width: 450px;">
			
			<p style="font-size: 13px;width: 70px;margin-right:10px;position: absolute;">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:60px;height:60px;border:1px #ddd solid;border-radius: 5px;margin-top:10px;">
					</p>

				
						<p style="font-size:14px;margin-top:20px;margin-left: 80px;"><a style="color:#434343;font-weight:600;" href=""><?php echo $product['title']?></a></p>
						<p style="color:orangered;margin-top:-10px;font-size: 13px;margin-left: 80px;">Rp <?php echo number_format($show['price'])?><span style="color:#666;font-size:12px;margin-left:5px;">x <?php echo $show['total_order']?> Product ( <?php echo number_format($product['weight'])?> Gr )</span></p>
						
				

					<p style="width: 93%;border:1px #ddd solid;border-radius: 5px;background: #f5f5f5;padding: 10px;margin-top:20px;">
						<span style="font-size: 13px;color:#666">Catatan Untuk Penjual</span><br>
						<i><?php echo $show['note_order']?></i></p>


					

		</td>
	</tr>
	<tr>

		<td valign="top" style="width: 150px;">
			<p style="font-size: 13px; margin-top:30px;">
				Total Belanja
			</p>
			<p style="font-weight:600;font-size: 13px;margin-top:-5px;color:orangered">
				Rp <?php echo $total_price ?>
			</p>

			

		</td>
	</tr>
</table>


<div class="list-chat-box" style="display: none;">
	<div class="list-chat" style="box-shadow: none;">

		<?php

		if(!empty($this->get("chat_to"))){

			$query = $this->db()->query("SELECT * FROM db_users WHERE username='".$this->get("chat_to")."' ");
			$show = $query->fetch();

			$check = $this->db()->query("SELECT * FROM db_chats WHERE 
				(user_id = '".$show['id']."' and sender_id = '".userinfo()->user_id."' and chat_object='".$this->get('id')."') or 
				(user_id = '".userinfo()->user_id."' and sender_id = '".$show['id']."' and chat_object='".$this->get('id')."')

				ORDER BY id DESC");

			if($check->rowCount() == 0){
	

			$time = "Just Now";

			if(empty($show['profile_pict']) or ($show['profile_pict'] == "")){

				if(strtolower($show['gender']) == "perempuan")
				$pict = sourceUrl()."/img/woman.png";
				else
				$pict = sourceUrl()."/img/man.png";
				
			}else $pict = sourceUrl()."/usr_pict/".$show['profile_pict'];

			if(($show['chat_type'] > 0)) {

				$pict = sourceUrl()."/media/complain.png";

			}

		?>

		<div class="list-data" id="<?php echo $show['username']?>" user_id="<?php echo $show['id']?>" room="<?php echo time()?>" name="Customer Service" img="<?php echo $pict ?>" date="<?php echo $time ?>" username="@<?php echo $show['username']?>" onClick="return load_chat(this)" style="cursor:pointer;">

			<img src="<?php echo $pict?>" width="50" height="50">

			<p class="user-name"><?php echo strip_tags($show['first_name'])?> <?php echo strip_tags($show['last_name'])?> 
				<span class="time"><?php echo $time ?></span>
			</p>

			<p class="chat">Start chat ...</p>

		

		</div>

	<?php } } ?>


	<?php

	$command = "SELECT * FROM db_chats WHERE (sender_id = '".userinfo()->user_id."' or user_id = '".userinfo()->user_id."') and chat_object='".$this->get('id')."'  GROUP BY room ORDER BY id DESC";
	$query = $this->db()->query($command);

	$response = 0;
	$sigma_alert = 0;
	while($show = $query->fetch()){ 

	if($show['sender_id'] == userinfo()->user_id){
		$usr = "SELECT * FROM db_users WHERE id='".$show['user_id']."'";
		$usr = $this->db()->query($usr);
		$usr = $usr->fetch();

		$check_chat = "SELECT * FROM db_chats WHERE user_id='".$usr['id']."' and room='".$show['room']."' and chat_object='".$this->get('id')."' ORDER BY id DESC";
		$check_chat = $this->db()->query($check_chat);
		$fetch_chat = $check_chat->fetch();
		$rows_count = $check_chat->rowCount();

		$sum_alert = $this->db()->query("SELECT * FROM db_chats WHERE sender_id='".$usr['id']."' and room='".$show['room']."' and chat_object='".$this->get('id')."' and status='0' ");
		$sum_alert = $sum_alert->rowCount();



	}

	if($show['user_id'] == userinfo()->user_id){
		$usr = "SELECT * FROM db_users WHERE id='".$show['sender_id']."'";
		$usr = $this->db()->query($usr);
		$usr = $usr->fetch();

		$check_chat = "SELECT * FROM db_chats WHERE sender_id='".$usr['id']."' and room='".$show['room']."' and chat_object='".$this->get('id')."' ORDER BY id DESC";
		$check_chat = $this->db()->query($check_chat);
		$fetch_chat = $check_chat->fetch();
		$rows_count = $check_chat->rowCount();

		$sum_alert = $this->db()->query("SELECT * FROM db_chats WHERE sender_id='".$usr['id']."' and room='".$show['room']."'  and status='0' and chat_object='".$this->get('id')."' ");
		$sum_alert = $sum_alert->rowCount();
	}

	$sigma_alert += $sum_alert;

	$last_chat = "SELECT * FROM db_chats WHERE (sender_id = '".userinfo()->user_id."' or user_id = '".userinfo()->user_id."') and room='".$show['room']."' and chat_object='".$this->get('id')."' ORDER BY id DESC";
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

	if(($show['chat_type'] > 0)){

		$pict = sourceUrl()."/media/complain.png";

	}





	$response += 1;

	?>

		<div class="list-data" id="<?php echo $usr['username']?>" user_id="<?php echo $usr['id']?>" room="<?php echo $show['room']?>" name="Customer Service" username="@<?php echo $usr['username']?>" img="<?php echo $pict ?>" date="<?php echo $time ?>" onClick="return load_chat(this)" style="cursor:pointer;">

			<img src="<?php echo $pict?>" width="50" height="50">

			<p class="user-name"><?php echo strip_tags($usr['first_name'])?> <?php echo strip_tags($usr['last_name'])?>

				<?php if(check_online($usr['id']) == "online"){ ?>
				<span style="background: #5bbd5f;color:#fff;padding: 2px;font-size:8px;border-radius: 10px;">Online</span>
				<?php } ?>
				<span class="time"><?php echo $time?></span>
			</p>

			<p class="chat" style="min-height: 8px;"><?php 

			if(empty($last_chat['chat'])){

				if($last_chat['sender_id'] !== userinfo()->user_id){
				echo "<span class='typing-".$usr['id']."' style='color:#22ba54'></span>
				<span class='finish-typing-".$usr['id']."'><img src='".sourceurl()."/img/rpl.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;'>
					<img src='".sourceurl()."/img/img-icon.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;margin-left:25px;'><span style='margin-left:50px;'>Send picture</span></span>";
				}else{

				echo "<span class='typing-".$usr['id']."' style='color:#22ba54'></span>
				<span class='finish-typing-".$usr['id']."'><img src='".sourceurl()."/img/img-icon.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;'><span style='margin-left:25px;'>Send picture</span></span>";
				}
			
			}else{

				if($last_chat['sender_id'] !== userinfo()->user_id){
				echo "<span class='typing-".$usr['id']."' style='color:#22ba54'></span>

					<span class='finish-typing-".$usr['id']."'><img src='".sourceurl()."/img/rpl.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;'>";

				echo "<span style='margin-left:25px;'>".stringLimit(strip_tags($last_chat['chat']),27," ...")."</span></span>";
				
				}else{

				echo "<span class='typing-".$usr['id']."' style='color:#22ba54'></span>
				<span class='finish-typing-".$usr['id']."'>".stringLimit(strip_tags($last_chat['chat']),27," ...")."</span>";

				}
			}
			?></p>

			<?php if($sum_alert !== 0){ ?>
			<div class="alert alert-<?php echo $usr['id']?>"><?php echo $sum_alert ?></div>
			<?php } ?>

		</div>

	<?php }

	$_SESSION['last_list_msg'] = $sigma_alert;

	if(isset($response) and ($response == 0)) {?>
	<div style="padding: 10px;text-align: center;height:283px;margin-top: 80px;">
		<img src="<?php echo sourceurl()?>/media/cb.png" style="width: 150px;">
		<p style="font-weight:600;">Tidak Ada Percakapan</p>
		<p style="color:#666;font-size:13px;margin-top:-5px;">Cek menu users untuk memulai percakapan dengan orang lain</p>
		<a href="<?php echo HomeUrl()?>/adminpanel/users"><button class="btn-white">List Users</button></a>
	</div>
<?php }	 ?>

	</div>
</div>

<hr style="border: transparent;border-bottom: 1px #ddd solid" />

<div class="chat-box" style="width: 100%;margin:auto;float:none;margin-top:30px;">
	<div class="header" style="display: none;background: #fe4c50">
		<img src="<?php echo setting()->icon?>">
		<p class="title"><span id="title-username">Customer Service</span></p>

		<p class="typing time" style="display: none;">Under Typing ...</p>

		<p class="time times finish-typing">14/03/2019</p>
	</div>
	<div class="top-box" id="chat-list">
		<span id="chat-data-list"></span>
	</div>

	<div class="input-chat" style="display: none;">

		<form method="POST" chat_type="complain" id="form" onSubmit="return send_chat(this)">
			<textarea onKeyup="return typing_send()" class="form-input" style="width: 89%;border-radius: 3px;height:25px;" placeholder="Type Message ..."></textarea>

			<img src="<?php echo sourceUrl()?>/media/cam.png" width="40" style="margin-top:3px;cursor:pointer" onClick="click_upload('file-upload')">

			<button class="btn-white" style="float: right;margin-right:15px;margin-top:10px;background: #fe4c50;border:1px #fe4c50 solid;border-radius: 5px;padding: 5px;">
			Send Message
			</button>
		</form>

		

	</div>
	
</div>

<div id="preview-upload" class="upload-hover" style="left: 0px;display: none;background: #fff">
	<span style="font-size: 16px;margin-left:10px;margin-top:15px;position: absolute;font-weight: 600">Upload Image</span>
	<img class="img-thumbnail" src="<?php echo sourceUrl()?>/media/times.png" width="30" onClick="close_preview()" style="margin:10px;">

	<form method="POST" id="upload-image" enctype="multipart/form-data">
		
		<input type="file" id="file-upload" name="file-upload" style="display: none;">
		<div style="width: 100%;margin:auto;margin-top:50px">
			<img id="img-prev" src="<?php echo sourceurl()?>/chat/mark.jpg" style="width: 100%;max-height: 300px" class="show-img-prev">
		</div>
		<div style="">
			<input class="form-input input-img" name="chat" placeholder="Tambah Keterangan" style="width: 94%;border:transparent;border-bottom:1px #ccc solid;color:#434343" />
			<input class="uid" name="user_id" value="" style="display: none;" />
			<input class="room" name="room" value="" style="display: none;" />
			<input class="utp" name="type" value="send" style="display: none;" />
			<input class="chat_type" name="chat_type" value="complain" style="display: none;" />
			<button class="btn-white" style="margin-right:3px;margin-top:20px;cursor: pointer;background: #fe4c50;border:1px #fe4c50 solid;border-radius: 0px;padding: 10px;width: 100%;font-weight: 600" type="submit">Kirim Gambar</button>
		</div>
	</form>
</div>