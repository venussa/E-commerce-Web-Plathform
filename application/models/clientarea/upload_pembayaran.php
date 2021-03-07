<?php

	class upload_pembayaran extends load{

		function __construct(){

			if($this->check_order() == true){

				if($this->update_data() == true){

					echo "<script>window.location='".HomeUrl()."/clientarea/konfirmasi_pembayaran?id=".$this->get("id")."';</script>";

				}else $response = true;

			}else $response = true;

			if(isset($response)){

				echo "<script>alert('Bukti pembayaran gagal di upload'); window.history.back();</script>";

			}

		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = str_replace("'",null,$value);

			}

			return json_decode(json_encode($data));

		}

		function check_order(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."' and status='0' ");

			if($query->rowCount() == 0) return false;
			return true;

		}

		function update_data(){

			foreach($this->clean_data() as $key => $val){

				$data[$key] = "'".$val."'";

			}


			if((isset($_FILES['screenshot'])) and (!empty($_FILES['screenshot']['name']))){

				$file = $_FILES['screenshot'];
				$ext = array("jpg","png","jpeg");
				$file_ext = get_extention($file['name']);
				$filename = "ss".userinfo()->user_id."-".time().".".$file_ext;

				if(in_array($file_ext, $ext)){

					if(move_uploaded_file($file['tmp_name'], SERVER."/sources/transfer/".$filename)){

						$data['screenshot'] = "'".$filename."'";

					} else return false;

				}else return false;


			}else return false;

			$data['status'] = "'1'";

			foreach ($data as $key => $value) {
					
				$build[] = $key."=".$value;

			}

			$this->db()->query("UPDATE db_orders SET ".implode(",", $build)." WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."' ");

			if($this->check_log() == false)
			$this->db()->query("INSERT INTO db_log_order (order_id,type,time) VALUES ('".$this->get("id")."','1','".time()."')");

			else
			$this->db()->query("UPDATE db_log_order SET time='".time()."' WHERE order_id='".$this->get("id")."' and type='1'");


			$admin = $this->db()->query("SELECT * FROM db_users WHERE level >=2 ");

			$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
			$order = $order->fetch();

			$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
			$product = $product->fetch();

			while($show = $admin->fetch()){

				ob_start();
				require_once(SERVER."/application/views/mail/upload_transfer_for_admin.php");
				$ob = ob_get_clean();

				PHPmailer($show['email'],"[Pemberitahuan] ".userinfo()->username." Mengupload Bukti Pembayaran \"".$product['title']."\" ".$order['invoice_id'], $ob);

				save_alert(array(
					"user_id" => "'".$show['id']."'",
					"order_id" => "'".$order['sorting_id']."'",
					"msg" => "'{username} mengirim bukti pembayaran untuk pesanan {product_title} dengan kode pembayaran {invoice}'",
					"icon"	=> "'bukti'",
					"url"	=> "'adminpanel/lihatorder'",
					"date_time" => "'".time()."'"
				));

			}

			return true;


		}

		function check_log(){

			$query = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$this->get("id")."' and type='1'");

			if($query->rowCount() == 0) return false;
			return true;

		}
	}