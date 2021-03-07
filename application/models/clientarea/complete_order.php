<?php

	class complete_order extends load{

		function __construct(){

			if($this->check_komplain() == false){

				if($this->check_order() == true){

					if($this->update_data() == true){

						echo "<script>alert('Pesanan Selesai');window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";

					}else echo "<script>alert('Gagal menyelesaikan');window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";

				}else echo "<script>alert('Gagal menyelesaikan');window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";

			}else echo "<script>alert('Gagal menyelesaikan');window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";
		

		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = str_replace("'",null,$value);

			}

			return json_decode(json_encode($data));

		}

		function check_order(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get('id')."' and status >= 3 and status < 8 and user_id='".userinfo()->user_id."' ");

			if($query->rowCount() == 0) return false;
			return true;

		}

		function update_data(){

			if($this->check_finish() == false)
			$this->db()->query("insert into db_log_order (order_id,type,time) values ('".$this->get('id')."','4','".time()."')");

			$this->db()->query("insert into db_log_order (order_id,type,time) values ('".$this->get('id')."','8','".time()."')");

			$this->db()->query("UPDATE db_orders SET status='8' WHERE sorting_id='".$this->get('id')."' and user_id='".userinfo()->user_id."' ");

			$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
			$order = $order->fetch();

			$shipp = $this->db()->query("SELECT * FROM db_delivery_service WHERE id='".$order['delivery_service']."'  ");
			$shipp = $shipp->fetch();

			$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$order['pay_with']."' ");
			$bank = $bank->fetch();

			$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
			$product = $product->fetch();

			$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$product['category']."'");
			$category = $category->fetch();

			$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($product['title'],"-",true)."?id=".$product['sorting_id'];

			$total = ($order['price'] * $order['total_order']) + $shipp['price'];

			$invoice = $order['invoice_id'];

			$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$order['user_id']."'");
			$user = $user->fetch();

			$show = $order;

			ob_start();
			require_once(SERVER."/application/views/mail/finish_order.php");
			$ob = ob_get_clean();

			PHPmailer($user['email'],"Pesanan Selesai : \"".stringLimit($product['title'],70," ...")."\" [".$order['invoice_id']."]", $ob);


			return true;

		}

		function check_finish(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."' and status = 4");

			if($query->rowCount() == 0) return false;

			return true;

		}

		function check_komplain(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get('id')."' and status = 5 and user_id='".userinfo()->user_id."' ");

			if($query->rowCount() == 0) return false;
			return true;

		}


	}
