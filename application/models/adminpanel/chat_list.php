<?php
	
	class chat_list extends load{

		function __construct(){



			if($this->post("type") == "send_typing") {

				$query = $this->db()->query("SELECT * FROM db_chat_typing WHERE user_id='".userinfo($this->get_real_user_data())->user_id."' and room='".$this->post("room")."' ");

				if($query->rowCount() == 0){

					$this->db()->query("INSERT INTO db_chat_typing (user_id,room,status) VALUES ('".userinfo($this->get_real_user_data())->user_id."','".$this->post("room")."','".$this->post("typing")."')");

				}else{

					$this->db()->query("UPDATE db_chat_typing SET status='".$this->post("typing")."' WHERE user_id='".userinfo($this->get_real_user_data())->user_id."' and room='".$this->post("room")."' ");

				}


			}elseif($this->post("type") == "typing") {

				$query = $this->db()->query("SELECT * FROM db_chat_typing WHERE status='1' and room='".$this->post("room")."' and user_id != ".userinfo($this->get_real_user_data())->user_id);

				while($show = $query->fetch()){

					$el[] = "typing-".$show['user_id']."|finish-typing-".$show['user_id'];

				}

				if(isset($el))
				echo implode("/",$el);
				else echo "<false/>";



			}elseif($this->post("type") == "hide_typing") {

				$query = $this->db()->query("SELECT * FROM db_chat_typing WHERE status='0' and room='".$this->post("room")."' and user_id != ".userinfo($this->get_real_user_data())->user_id);

				while($show = $query->fetch()){

					$el[] = "typing-".$show['user_id']."|finish-typing-".$show['user_id'];

				}

				if(isset($el))
				echo implode("/",$el);
				else echo "<false/>";



			}elseif($this->post("type") == "reload") {

				$query = $this->db()->query("SELECT * FROM db_chats WHERE 
				(
					(user_id = '".$this->user()['id']."' and sender_id = '".userinfo($this->get_real_user_data())->user_id."') or 
					(user_id = '".userinfo($this->get_real_user_data())->user_id."' and sender_id = '".$this->user()['id']."')
				)
				 and room='".$this->post('room')."' and status='0' ORDER BY id DESC");

				

				if($this->user()['id'] !== userinfo($this->get_real_user_data())->user_id){

				if(!isset($_SESSION['chat_status'])) $_SESSION['chat_status'] = 0;

				if($_SESSION['chat_status'] !== $query->rowCount()){
					echo $this->get_chat_data("and sender_id != ".userinfo($this->get_real_user_data())->user_id." and status='0' ORDER BY id ASC")."<reload/>";

				}}

				

			}elseif($this->post("type") == "send") {

				if(isset($_FILES['file-upload']) and !empty($_FILES['file-upload']['name'])){

					echo $this->send();

				}elseif(empty($_FILES['file-upload']['name']) and (!empty($this->post("chat")))){

					echo $this->send();

				}
		
			}else echo $this->get_chat_data();

		}

		function get_real_user_data(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->post('status')."' ");
			$show = $query->fetch();

			if($query->rowCount() > 0){

				$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['handle_by']."' ");
				$user = $user->fetch();

				if(!isset($user['username'])) $user['username'] = null;

				return $user['username'];
			
			}

			return null;

		}
		

		function send(){

			if(isset($_FILES['file-upload']) and !empty($_FILES['file-upload']['name'])){

				$extention = array("jpg","png","gif","jpeg");

				$file = $_FILES['file-upload'];

				$get_ext = get_extention($file['name']);

				$generate_name = time().".".$get_ext;

				$path = SERVER."/sources/chat/".$generate_name;

				if(in_array($get_ext,$extention)){

					if(move_uploaded_file($file['tmp_name'], $path)){

						$img_data = $generate_name;

					}else $img_data = null;

				}else $img_data = null;

			}else $img_data = null;



			$text = strip_tags(str_replace("'",null,$this->post("chat")));

			$data= array(

				"user_id" => "'".$this->user()['id']."'",
				"sender_id" => "'".userinfo($this->get_real_user_data())->user_id."'",
				"img" => "'".$img_data."'",
				"chat" => "'".$text."'",
				"status" => "'0'",
				"date_time" => "'".time()."'",
				"room" => "'".$this->post("room")."'"

			);

			if(!empty($this->post("chat_type"))){

				if($this->post("chat_type") == "complain"){

					if(empty($this->post("order_id"))) $or_id = $this->get("id");
					else $or_id = $this->post("order_id");
						
					$qscan = $this->db()->query("SELECT * FROM db_orders WHERE user_id='".$this->user()['id']."' and sorting_id='".$or_id."' and status='5' ");
					$scan = $qscan->fetch();

					if(($scan['handle_by'] < 1) and (userinfo()->level >= 2)){
					
						if(userinfo() == false) die("Access Danied");
							if(userinfo()->level < 2) die("Access Danied");
							if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
								role_access("order", "6");
							}
					}

					if(!isset($scan['handle_by'])) $scan['handle_by'] = null;

					if((time() - $this->user()['online']) > 10){

						if(userinfo()->level >= 2){

							save_alert(array(
								"user_id" => "'".$this->user()['id']."'",
								"order_id" => "'".$this->post('order_id')."'",
								"msg" => "'{from-user} mengirimkan pesan kepada anda prihal komplen produk {product_title} dengan kode pembayaran {invoice}.'",
								"icon"	=> "'chat-send'",
								"url"	=> "'clientarea/detail_komplein'",
								"date_time" => "'".time()."'"
							));

							PHPmailer($this->user()['email'],"[".date("d/m/Y H:i")."] Pesan baru : Anda memiliki pesan yang belum dibaca prihal komplen pemesanan.", "<p style=\"font-family:Arial;color:#434343;\">Anda memiliki pesan yang belum di baca perihal komplein, segera <a href=\"".HomeUrl()."/clientarea/komplain_pembelian\" style=\"text-decoration:none;color:orangered;\">Balas</a> pesan tersebut.</p>");

						}elseif(userinfo()->level < 2){

							$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
							$order = $order->fetch();

							$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$order['handle_by']."'");
							$user = $user->fetch();

							save_alert(array(
								"user_id" => "'".$order['handle_by']."'",
								"order_id" => "'".$order['sorting_id']."'",
								"msg" => "'{from-user} mengirimkan pesan kepada anda prihal komplen produk {product_title} dengan kode pembayaran {invoice}.'",
								"icon"	=> "'chat-send'",
								"url"	=> "'adminpanel/message?chat_to=".userinfo()->username."&action=complain{id}#".userinfo()->username."'",
								"date_time" => "'".time()."'"
							));

							PHPmailer($user['email'],"[".date("d/m/Y H:i")."] Pesan baru : Anda memiliki pesan yang belum dibaca prihal komplen pemesanan.", "<p style=\"font-family:Arial;color:#434343;\">Anda memiliki pesan yang belum di baca perihal komplein, segera <a href=\"".HomeUrl()."/adminpanel/message\" style=\"text-decoration:none;color:orangered;\">Balas</a> pesan tersebut.</p>");

						}

					}

					if(($scan['handle_by'] < 1) and (userinfo()->level >= 2)){

						$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->post("order_id")."' ");
						$order = $order->fetch();

						$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
						$product = $product->fetch();

						ob_start();
						require_once(SERVER."/application/views/mail/alert_start_complain.php");
						$ob = ob_get_clean();

						PHPmailer($this->user()['email'],"[Pemberitahuan] Memulai diskusi prihal komplain ".$order['invoice_id'], $ob);

						save_alert(array(
							"user_id" => "'".$this->user()['id']."'",
							"order_id" => "'".$order['sorting_id']."'",
							"msg" => "'Pengajuan komplen untuk produk {product_title} dengan kode pembayaran {invoice} telah kami respon. Segeralah buka menu komplein pembelian guna mendiskusikan prihal tersebut.'",
							"icon"	=> "'listen-komplein'",
							"url"	=> "'clientarea/detail_komplein'",
							"date_time" => "'".time()."'"
						));

					}

					if($qscan->rowCount() !== 0){

						$data['privacy'] = "'1'";
						$data['chat_type'] = "'1'";
						$data['chat_object'] = "'".$scan['sorting_id']."'";

						$this->db()->query("UPDATE db_orders SET handle_by='".userinfo($this->get_real_user_data())->user_id."' WHERE sorting_id='".$scan['sorting_id']."' ");

					}

					if(userinfo()->level < 2){

						$data['privacy'] = "'1'";
						$data['chat_type'] = "'1'";
						$data['chat_object'] = "'".$this->get("id")."'";

					}

				}

			}

			$field = implode(",",array_keys($data));
			$value = implode(",",$data);

			$query = $this->db()->query("SELECT * FROM db_chats WHERE 
				(user_id = '".$this->user()['id']."' and sender_id = '".userinfo($this->get_real_user_data())->user_id."') or 
				(user_id = '".userinfo($this->get_real_user_data())->user_id."' and sender_id = '".$this->user()['id']."')
				ORDER BY id DESC");

			$show = $query->fetch();

			if(!isset($show['user_id'])) $show['user_id'] = null;
			if(!isset($show['date_time'])) $show['date_time'] = null;

			$usr = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."' ");
			$usr = $usr->fetch();

			if($this->db()->query("INSERT INTO db_chats ($field) VALUES ($value)")){

				$time_history = date("d M Y",$show['date_time']);

				if(($time_history !== date("d M Y")) and ($query->rowCount() !== 0)) {

					$date = date("d M Y",$show['date_time']);
					$date = "<div style='height:27px;background-color: rgba(255, 255, 255, 0.5);float:left;width:100%;text-align:center;margin-top:10px;padding-top:3px'>
								<span style='border:1px #ddd solid;padding:3px;color:#434343;border-radius:4px;background:#d9ecff;font-size:12px;'>".$date."</span>
							  </div>";

				}else{

					$date = null;

				}

				if(!isset($show['chat'])) $show['chat'] = null;
				if(!isset($show['chat_type'])) $show['chat_type'] = null; 
				if(!isset($usr['id'])) $usr['id'] = null;
				if(!isset($usr['username'])) $usr['username'] = null;

				if(empty($show['chat'])){
			
					$new_prev_chat = "<span class='typing-".$usr['id']."' style='color:#22ba54'></span>
					<span class='finish-typing-".$usr['id']."'><img src='".sourceurl()."/img/img-icon.png' width='20' style='box-shadow:none;position:absolute;margin-top:-2px;'><span style='margin-left:25px;'>Send picture</span></span>";				
				
					}else{

					$new_prev_chat = "<span class='typing-".$usr['id']."' style='color:#22ba54'></span>
					<span class='finish-typing-".$usr['id']."'>".stringLimit($text,27," ...")."</span>";

				}

				if($show['chat_type'] == 0) $click_id = $usr['username'];
				if($show['chat_type'] == 1) $click_id = $usr['username']."-".$show['chat_object'];

				return $date." ".$this->chat_layout($text, time(), userinfo($this->get_real_user_data())->user_id,$img_data);

			}

		}

		function user(){

			$user_id = $this->post("user_id");

			$query = $this->db()->query("SELECT * FROM db_users WHERE id='$user_id' ");

			if($query->rowCount() == 0){

				return ["id" => 0];

			}else{

				return $query->fetch();

			}

		}

		function get_chat_data($where = "ORDER BY id ASC"){

			$query = $this->db()->query("SELECT * FROM db_chats WHERE 
				(
					(user_id = '".$this->user()['id']."' and sender_id = '".userinfo($this->get_real_user_data())->user_id."') or 
					(user_id = '".userinfo($this->get_real_user_data())->user_id."' and sender_id = '".$this->user()['id']."')
				)
				 and room='".$this->post('room')."' $where ");

			$query1 = $this->db()->query("SELECT * FROM db_chats WHERE 
				(
					(user_id = '".$this->user()['id']."' and sender_id = '".userinfo($this->get_real_user_data())->user_id."') or 
					(user_id = '".userinfo($this->get_real_user_data())->user_id."' and sender_id = '".$this->user()['id']."')
				)
				 and room='".$this->post('room')."' and status='0' ");

			$_SESSION['chat_status'] = $query1->rowCount();

			$switch = false;

			$date = date("d M Y");

			while($show = $query->fetch()){

				$time_history = date("d M Y",$show['date_time']);

				if($time_history !== $date){

					$date = date("d M Y",$show['date_time']);
					$data[] = "<div style='height:27px;background-color: rgba(255, 255, 255, 0.5);float:left;width:100%;text-align:center;margin-top:10px;padding-top:3px'>
								<span style='border:1px #ddd solid;padding:3px;color:#434343;border-radius:4px;background:#d9ecff;font-size:12px;'>".$date."</span>
							  </div>";

				}

;

				$data[] = $this->chat_layout(strip_tags($show['chat']),$show['date_time'],$show['sender_id'],trim($show['img']));

			}

			if(isset($data))
			return implode(null,$data);

			return null;

		}

		function chat_layout($text = null,$time = null,$sender_id,$img = null){

			if($sender_id !== userinfo($this->get_real_user_data())->user_id) {

				$this->db()->query("UPDATE db_chats SET status='1' WHERE sender_id='$sender_id' ");

			}

			$time_history = timeHistory($time,true,"hour");

			$time = date("H:i",$time);

			if(($img !== "") and ($img !== null)) {

				$img = sourceUrl()."/chat/".$img;
				$url_img = "<a href='".($img)."' onClick=\"MyWindow=window.open('".($img)."','MyWindow','width=1000,height=1000'); return false;\">
				<img src='".($img)."' width='100%'></a>";
			
			}else $url_img = null;

			if($this->user()["id"] !== false){
				
				if($sender_id == userinfo($this->get_real_user_data())->user_id){

					$data = '<div class="my-chat">
								<div class="data">
									'.$url_img.$text.' <div class="time"><span>'.$time.'</span></div>
								</div>
							</div>';

				}else{

					$data = '<div class="target-chat">
								<div class="data">
									'.$url_img.$text.' <div class="time"><span>'.$time.'</span></div>
								</div>
							</div>';

				}

			} else $data = false;
				
			return $data;

		}

	}