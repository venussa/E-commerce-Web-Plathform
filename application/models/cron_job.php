<?php
	
	class cron_job extends load{

		function __construct(){

			echo "Running In Background";

			$this->payment_verif();
			$this->receive_produk();
			$this->finish_order();

		}

		function finish_order(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE status = 4 ORDER BY sorting_id DESC");

			$time_limit = 86400 * 2;
					
			while($order = $query->fetch()){

				$log_order = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$order['sorting_id']."' and type = 4");
				$log_order = $log_order->fetch();

				$range_time = time() - $log_order['time']; 

				if($range_time > $time_limit){

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

					ob_start();
					require_once(SERVER."/application/views/mail/finish_order.php");
					$ob = ob_get_clean();

					PHPmailer($user['email'],"Pesanan Selesai : \"".stringLimit($product['title'],70," ...")."\" [".$order['invoice_id']."]", $ob);

					save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Karena sudah lebih dari 24 jam sejak pesanan {product_title} dengan kode pembayaran {invoice} diterima pembeli, maka pesanan kami nyatakan telah selesai.'",
						"icon"	=> "'finish-order'",
						"url"	=> "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

					$this->db()->query("UPDATE db_orders SET status=8 WHERE sorting_id='".$order['sorting_id']."' ");
					$this->db()->query("INSERT INTO db_log_order (order_id, type, time) VALUES ('".$order['sorting_id']."','8','".time()."') ");

				}

			}

		}

		function receive_produk(){

			$query = $this->db()->query("SELECT * FROM db_orders WHERE status = 3 ORDER BY sorting_id DESC");
					
			while($order = $query->fetch()){

				$service = $this->db()->query("SELECT * FROM db_delivery_service WHERE id='".$order['delivery_service']."' ");
				$service = $service->fetch();

				$log_order = $this->db()->query("SELECT * FROM db_log_order WHERE order_id='".$order['sorting_id']."' and type = 3");
				$log_order = $log_order->fetch();

				$time_limit = $service["time"] * 86400;

				$range_time = time() - $log_order['time'];

				if($range_time > $time_limit){

					$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$order['user_id']."'");
					$user = $user->fetch();

					save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Pesanan anda {product_title} dengan kode pembayaran {invoice} telah sampai di tempat tujuan'",
						"icon"	=> "'receive'",
						"url"	=> "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

					$this->db()->query("UPDATE db_orders SET status=4 WHERE sorting_id='".$order['sorting_id']."' ");
					$this->db()->query("INSERT INTO db_log_order (order_id, type, time) VALUES ('".$order['sorting_id']."','4','".time()."') ");

				}

			}

		}

		function payment_verif(){

			$time_limit = 86400;

			$query = $this->db()->query("SELECT * FROM db_orders WHERE status < 1 ORDER BY sorting_id DESC");
			
			while($order = $query->fetch()){

				$range_time = time() - $order['start_time']; 

				if($range_time > $time_limit){

					$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
					$product = $product->fetch();

					$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$order['user_id']."'");
					$user = $user->fetch();

					ob_start();
					require_once(SERVER."/application/views/mail/force_cancel.php");
					$ob = ob_get_clean();

					PHPmailer($user['email'],"Pesanan Dibatalkan : Pesanan Produk ".$product['title']." [".$order['invoice_id']."] dibatalkan.", $ob);

					save_alert(array(
						"user_id" => "'".$order['user_id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Pesanan anda untuk produk {product_title} dengan kode pembayaran {invoice} dibatalkan karena dalam jangka waktu 1 x 24 anda tidak mengupload bukti pembayaran / transfer ke kami.'",
						"icon"	=> "'force-cancel'",
						"url"	=> "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

					$this->db()->query("UPDATE db_orders SET status=9 WHERE sorting_id='".$order['sorting_id']."' ");
					$this->db()->query("INSERT INTO db_log_order (order_id, type, time) VALUES ('".$order['sorting_id']."','9','".time()."') ");

					if(wallet_system() == true){

						$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE invoice_id='".$order['invoice_id']."' ");
						$wallet = $wallet->fetch();

						$total = $wallet['saldo'] - $wallet['saldo'] - $wallet['saldo'];
							$this->db()->query("insert into db_wallet (user_id, saldo, type, invoice_id, date_time) 
						values ('".$user['id']."','".$total."','0','".$order['invoice_id']."','".time()."')");
					}

				}

			}

		}

	}