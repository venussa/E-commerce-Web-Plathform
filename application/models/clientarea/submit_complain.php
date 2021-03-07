<?php

	class submit_complain extends load{

		function __construct(){

			if($this->check_order() == true){

				if($this->input_data() == true){

					echo "<script>window.location='".HomeUrl()."/clientarea/komplain_pembelian';</script>";

				}else echo "<script>alert('Gagal');window.location='".HomeUrl()."/clientarea/komplain_produk';</script>";

			}else echo "<script>alert('Gagal');window.location='".HomeUrl()."/clientarea/komplain_produk';</script>";


		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = strip_tags(str_replace("'",null,$value));

			}

			return json_decode(json_encode($data));

		}


		function input_data(){

			if($this->check_finish() == false)
			$this->db()->query("INSERT INTO db_log_order (order_id, type, time) VALUES ('".$this->get("id")."','4','".time()."')");

			$this->db()->query("INSERT INTO db_log_order (order_id, type, time) VALUES ('".$this->get("id")."','5','".time()."')");

			$this->db()->query("UPDATE db_orders SET status='5', note_complain='".$this->clean_data()->note."' WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."' ");

			$admin = $this->db()->query("SELECT * FROM db_users WHERE level >=2 ");
				
			$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
			$order = $order->fetch();

			$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
			$product = $product->fetch();

			while($show = $admin->fetch()){

				ob_start();
				require_once(SERVER."/application/views/mail/komplain.php");
				$ob = ob_get_clean();

				PHPmailer($show['email'],"[Pemberitahuan] ".userinfo()->username." Mengajukan komplain [".$order['invoice_id']."]", $ob);

				save_alert(array(
						"user_id" => "'".$show['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'{username} mengajukan komplen atas pembelian produk {product_title} dengan kode pembayaran {invoice}'",
						"icon"	=> "'komplain'",
						"url"	=> "'adminpanel/message?chat_to=".userinfo()->username."&action=complain{id}#".userinfo()->username."'",
						"date_time" => "'".time()."'"
					));

			}

			return true;

		}

		function check_finish(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."' and status >= 4");

			if($query->rowCount() == 0) return false;

			return true;

		}

		function check_order(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."' and status >= 3 and status < 5");

			if($query->rowCount() == 0) return false;

			return true;

		}

	}
