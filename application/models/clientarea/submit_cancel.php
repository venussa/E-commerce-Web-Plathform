<?php

	class submit_cancel extends load{

		function __construct(){


			if($this->check_order() == true){

				if($this->input_data() == true){

					echo "<script>window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";


				}else echo "<script>alert('Gagal'); window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";

			}else echo "<script>alert('Gagal'); window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";


		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = strip_tags(str_replace("'",null,$value));

			}

			return json_decode(json_encode($data));

		}

		function check_order(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' and (status = 0 or status = 2) and user_id='".userinfo()->user_id."' ");

			if($query->rowCount() == 0) return false;

			return true;

		}

		function input_data(){

			$query = $this->db()->query("SELECT * FROM db_cancel_order WHERE status > 0 and order_id='".$this->get("id")."' ");

			if($query->rowCount() == 0){

			$this->db()->query("insert into db_cancel_order (order_id, note, status, date_time ) values ('".$this->get("id")."','".$this->clean_data()->note."','0','".time()."') ");
			
			$this->db()->query("UPDATE db_orders SET rec_cancel='1' WHERE sorting_id='".$this->get('id')."' ");

			$admin = $this->db()->query("SELECT * FROM db_users WHERE level >=2 ");
			
			$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
			$order = $order->fetch();

			$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
			$product = $product->fetch();
			
			while($show = $admin->fetch()){

				ob_start();
				require_once(SERVER."/application/views/mail/cancel_order_for_admin.php");
				$ob = ob_get_clean();

				PHPmailer($show['email'],"[Pemberitahuan] ".userinfo()->username." Mengajukan permintaan pembatalan pesanan ".$order['invoice_id'], $ob);

				save_alert(array(
					"user_id" => "'".$show['id']."'",
					"order_id" => "'".$order['sorting_id']."'",
					"msg" => "'{username} mengajukan pembatalan untuk pesanan {product_title} dengan kode pembayaran {invoice}'",
					"icon"	=> "'req-cancel'",
					"url"	=> "'adminpanel/lihatorder'",
					"date_time" => "'".time()."'"
				));

			}

			return true;

			} return false;


		}

	}