<?php

	class finish_order extends load{

		function __construct(){

			

			if(($this->check_product() == true) and ($this->check_stock() == true)){

				if($this->input_log_order() == true){

					$response = array("clientarea/detail_pesanan?id=".$_SESSION['order_id'], "Berhasil");

				}else $response = array("clientarea/keranjang_belanja", "Gagal");

			}else $response = array("clientarea/keranjang_belanja", "Stok tidak tersedia");

			echo "<script>alert('".$response[1]."');window.location='".HomeUrl()."/".$response[0]."';</script>";

		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = str_replace("'",null,$value);

			}

			return json_decode(json_encode($data));

		}

		function query($field, $value){

			return $this->db()->query("SELECT * FROM db_users WHERE ".$field."='".$value."' ");

		}

		function insert_delivery($invoice_id, $product_id){

			if(!in_array($this->post("shipping_price",["'"]),$_SESSION['shipping'])) die("JANGAN NYOBA MANIPULASI DATA YA BOY"); 

			$data = array(

				"code" => "'".$this->post("code",["'"])."'",
				"company_name" => "'".$this->post("company_name",["'"])."'",
				"service_name" => "'".$this->post("service_name",["'"])."'",
				"service_description" => "'".$this->post("service_description",["'"])."'",
				"price" => "'".$this->post("shipping_price",["'"])."'",
				"time" => "'".((int) $this->post("time",["'"]) + 4)."'",
				"invoice_id" => "'".$invoice_id."'",
				"product_id" => "'".$product_id."'"

			);

			$field = implode(",", array_keys($data));
			$value = implode(",", ($data));

			$this->db()->query("insert into db_delivery_service ($field) values ($value)");

			$query = $this->db()->query("SELECT id FROM db_delivery_service WHERE invoice_id='".$invoice_id."' and product_id='".$product_id."' ");
			$show = $query->fetch();
			
			return $show["id"];

		}

		function input_log_order(){

			$time = time();

			$order_id = $this->input_orders($time);

			$data = array(

				"type" => "'0'",
				"order_id" => "'".$order_id."'",
				"time" => "'".$time."'"
			);

			$field = implode(",", array_keys($data));
			$value = implode(",", ($data));

			$this->db()->query("insert into db_log_order ($field) values ($value)");

			$this->db()->query("DELETE FROM db_cart WHERE id='".$this->post('cart_id')."'");

			$_SESSION['order_id'] = $order_id;

			return true;

		}

		function input_orders($time){

			$query = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->post("product_id")."'");
			$show = $query->fetch();
			$product = $show;

			$scheme = $show['transaction_scheme'];

			$invoice = "INV/".date("dmY/His")."/".userinfo()->id;

			$delivery = $this->insert_delivery($invoice, $show['product_id']);

			$get_address = $this->db()->query("SELECT * FROM db_destination_address WHERE id='".$this->post("address_id")."' and user_id='".userinfo()->user_id."'");
			$get_address = $get_address->fetch();

			$get_discount = $this->db()->query("SELECT * FROM db_product_discount WHERE product_id='".$show['sorting_id']."' ");

			$show_discount = $get_discount->fetch();

			$product_price = $show['price'];

			if($get_discount->rowCount() > 0){

				if((time() >= $show_discount['start_time']) and (time() < $show_discount['end_time'])){

					$product_price = $show['price'] - $show_discount['price'];
					
				}
			}

			$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type != 1 ");
			$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type=1 and status=1 ");
			$shipp = $this->db()->query("SELECT * FROM db_delivery_service WHERE id='".$delivery."'  ");
			$shipp = $shipp->fetch();
			$saldo = $saldo0['saldo'] + $saldo1['saldo'];
			$total = ($product_price * $_SESSION['jumlah']) + $shipp['price'];
			$old_total = $total;
			$range = $total - $saldo;

			$status = 0;

			if($show['transaction_scheme'] == "0"){

			if($this->post("wallet") == "1"){

				if($saldo < $total){

					if($saldo <= 0){

						$this->db()->query("DELETE FROM db_delivery_service WHERE id='".$delivery."' ");
						echo "<script>alert('Anda tidak memiliki saldo pada wallet. Silakan ganti metode pembayaran atau melakukan topup.'); window.location='".HomeUrl()."/clientarea/keranjang_belanja';</script>";
						exit;

					}

				}

				if($saldo >= $total) $status = 2;
			}

			}


			$data = array(

				"price" => "'".$product_price."'",
				"invoice_id" => "'".$invoice."'",
				"product_id" => "'".$show['product_id']."'",
				"user_id" => "'".userinfo()->user_id."'",
				"total_order" => "'".$_SESSION['jumlah']."'",
				"pay_with" => "'".$this->post("bank")."'",
				"destination" => "'".$this->post("address_id")."'",
				"address" => "'".$get_address['address']."'",
				"province" => "'".$get_address['province']."'",
				"state" => "'".$get_address['state']."'",
				"district" => "'".$get_address['district']."'",
				"zip_code" => "'".$get_address['zip_code']."'",
				"phone_number" => "'".$get_address['phone_number']."'",
				"nama_penerima" => "'".$get_address['nama_penerima']."'",
				"delivery_service" => "'".$delivery."'",
				"note_order" => "'".$this->post("note",["'"])."'",
				"start_time" => "'".$time."'",
				"wallet"	=> "'".((int) $this->post("wallet"))."'",
				"status" => "'".$status."'"
			);

			$field = implode(",", array_keys($data));
			$value = implode(",", ($data));

			$this->db()->query("insert into db_orders ($field) values ($value)");

			if($show['transaction_scheme'] == "0"){
				
				if($this->post("wallet") == "1"){

					if($saldo >= $total) $new_saldo = $total - $total - $total;;
					if($saldo < $total){
						
						if($range < 10000)	$new_saldo = (($saldo - ($saldo * 2)) + ((10000 - $range)));
						else $new_saldo = $saldo - $saldo - $saldo;

					}
					$tf_id = "TRF/".date("dmY/His")."/".userinfo()->user_id;

					$wallet = $this->db()->query("INSERT INTO db_wallet (tf_id, user_id, saldo, type, invoice_id, date_time) VALUES (
					'".$tf_id."',
					'".userinfo()->user_id."',
					'".$new_saldo."',
					'2',
					'".$invoice."',
					'".time()."'
					)");

				}

			}

			


			$query = $this->db()->query("SELECT * FROM db_orders WHERE invoice_id='".$invoice."' and product_id='".$show['product_id']."' ");
			$show = $query->fetch();

			$admin = $this->db()->query("SELECT * FROM db_users WHERE level >=2 ");

			$order = $show;

			if($product['transaction_scheme'] == "0"){
				if($this->post("wallet") == "1"){

					if($saldo >= $total) {
						$this->db()->query("insert into db_log_order (order_id, type, time) values ('".$order['sorting_id']."','1','".time()."')");
						$this->db()->query("insert into db_log_order (order_id, type, time) values ('".$order['sorting_id']."','2','".time()."')");
					}
				}
			}

			$shipp = $this->db()->query("SELECT * FROM db_delivery_service WHERE id='".$order['delivery_service']."'  ");
			$shipp = $shipp->fetch();

			$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$order['pay_with']."' ");
			$bank = $bank->fetch();

			$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
			$product = $product->fetch();

			$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$product['category']."'");
			$category = $category->fetch();

			$total = ($order['price'] * $order['total_order']) + $shipp['price'];

			$invoice = $order['invoice_id'];

			$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$order['user_id']."'");
			$user = $user->fetch();
			
			while($show = $admin->fetch()){

				ob_start();
				require_once(SERVER."/application/views/mail/new_order.php");
				$ob = ob_get_clean();

				PHPmailer($show['email'],"[Pemberitahuan] ".userinfo()->username." Melakukan Order \"".$product['title']."\" ", $ob);


				save_alert(array(
					"user_id" => "'".$show['id']."'",
					"order_id" => "'".$order['sorting_id']."'",
					"msg" => "'{username} melakukan order {product_title} dengan kode pembayaran {invoice}'",
					"icon"	=> "'order'",
					"url" => "'adminpanel/lihatorder'",
					"date_time" => "'".time()."'"
				));

			}

			if($scheme == 0){

				if($this->post("wallet") !== "1"){

					$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($product['title'],"-",true)."?id=".$product['sorting_id'];

					$total = ($product_price * $order['total_order']) + $shipp['price'];
					$order['price'] = $product_price;

					ob_start();
					require_once(SERVER."/application/views/mail/pending_pay.php");
					$ob = ob_get_clean();

					PHPmailer(userinfo()->email,"Menunggu Pembayaran Bank ".$bank['bank_name']." Untuk Pembayaran ".$invoice, $ob);

				}else{

					if($product['transaction_scheme'] == "0"){

						if($saldo >= $total){

							$bank['icon'] = "wallet.png";
							$bank['bank_name'] = "Dompet Digital";
							$bank['bank_info'] = $tf_id;
							$bank['code_bank'] = "-";
							$res_wallet = true;

							ob_start();
							require_once(SERVER."/application/views/mail/payment_verification.php");
							$ob = ob_get_clean();

							PHPmailer(userinfo()->email,"Pembayaran berhasil sepenuhnya menggunakan Digital Wallet - ".$tf_id, $ob);

							save_alert(array(
								"user_id" => "'".userinfo()->user_id."'",
								"order_id" => "'".$order['sorting_id']."'",
								"msg" => "'Pembayaran untuk produk {product_title} dengan kode pembayaran {invoice} berhasil sepenuhnya menggunakan Saldo Dompet Digital.'",
								"icon"	=> "'finish-order'",
								"url" => "'clientarea/detail_pesanan'",
								"date_time" => "'".time()."'"
							));

						}elseif($saldo < $total){

							if($range < 10000)
							$new_total = 10000;
							else
							$new_total = $range;

							ob_start();
							require_once(SERVER."/application/views/mail/pending_pay.php");
							$ob = ob_get_clean();

							PHPmailer(userinfo()->email,"Menunggu Pembayaran Bank ".$bank['bank_name']." Untuk Pembayaran ".$invoice, $ob);

							save_alert(array(
								"user_id" => "'".userinfo()->user_id."'",
								"order_id" => "'".$order['sorting_id']."'",
								"msg" => "'Pembayaran untuk produk {product_title} dengan kode pembayaran {invoice} Sebagain sudah dibayar dengan saldo Dompet Digital anda, Silahkan lakukan sisa pembayaran.'",
								"icon"	=> "'finish-order'",
								"url" => "'clientarea/detail_pesanan'",
								"date_time" => "'".time()."'"
							));


						}

					}

				}

			}

			return $order['sorting_id'];

		}

		function check_product(){

			$query = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->post('product_id')."' ");

			if($query->rowCount() == 0) return false;

			return true;

		}

		function check_stock(){

			$total_stock = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->post('product_id')."' ");
			$total_stock = $total_stock->fetch();

			$orders = $this->db()->query("SELECT sum(total_order) as TotalOrder FROM db_orders WHERE product_id='".$total_stock['product_id']."' and status >= 0 and status != 9");
	
			$order = $orders->fetch();

			$stock = $total_stock['stock'] - $order['TotalOrder'];

			if($stock <= 0){

				return false;

			}

			return true;

		}

		function send_mail(){

			

		}


	}
