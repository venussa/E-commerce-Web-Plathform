<?php
	
	class verifikasi_order extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("order", "6");
			}

			if($this->post("verifikasi") == "pembayaran"){


				$query = $this->db()->query("SELECT * FROM db_cancel_order WHERE order_id='".$this->get("id")."' and status='0'");

				if($query->rowCount() > 0){

					echo "<script>alert('Pesanan ini memiliki permintaan pembatalan, Mohon tindak lanjuti terlebih dahulu');window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";
					exit;

				}

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

				$total = ($order['price'] * $order['total_order']) + $shipp['price'];

				$invoice = $order['invoice_id'];

				$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$order['user_id']."'");
				$user = $user->fetch();

				$url = HomeUrl()."/".url_title($category['title'],"-",true)."/".url_title($product['title'],"-",true)."?id=".$product['sorting_id'];

				$total = ($order['price'] * $order['total_order']) + $shipp['price'];

				$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE user_id='".$user['id']."' and invoice_id='".$order['invoice_id']."' ");
				$wallet = $wallet->fetch();
				$wallet['saldo'] = $wallet['saldo'] - $wallet['saldo'] - $wallet['saldo'];
				$range = $total - $wallet['saldo'];

				$show = $order;

				if($order['wallet'] == "1"){
					$new_total = $range;
				}

				ob_start();
				require_once(SERVER."/application/views/mail/payment_verification.php");
				$ob = ob_get_clean();

				PHPmailer($user['email'],"Checkout pesanan dengan Transfer ".$bank['bank_name']." dan berhasil pada tanggal ".date("d M Y"), $ob);

				save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Pembayaran untuk produk {product_title} dengan kode pembayaran {invoice} telah kami verifikasi, selanjutnya barang akan kami teruskan ke jasa pengiriman untuk dikirimkan ke anda.'",
						"icon"	=> "'verif'",
						"url" => "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

				save_activity("Memverifikasi pembayaran dari invoice id <b>".$this->data_order()['invoice_id']."</b>");
				$this->verfikasi(2,1);

				

			}elseif($this->post("verifikasi") == "pengiriman"){

				$query = $this->db()->query("SELECT * FROM db_cancel_order WHERE order_id='".$this->get("id")."' and status='0'");

				if($query->rowCount() > 0){

					echo "<script>alert('Pesanan ini memiliki permintaan pembatalan, Mohon tindak lanjuti terlebih dahulu');window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";
					exit;

				}

				if(!empty($this->post("no_resi"))){

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
					require_once(SERVER."/application/views/mail/item_send.php");
					$ob = ob_get_clean();

					PHPmailer($user['email'],"Pesanan dengan nomor ".$order['invoice_id']." sudah dikirim pada ".date("d M Y, H:i")." WIB", $ob);

					save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Pesanan anda {product_title} dengan kode pembayaran {invoice} telah kami kirim menggunakan jasa pengirimina {delivery} dengan nomor resi {resi}'",
						"icon"	=> "'send'",
						"url"	=> "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

					save_activity("Memverifikasi pengiriman barang dari invoice id <b>".$this->data_order()['invoice_id']."</b>");
					$this->verfikasi(3,2);

					$this->db()->query("UPDATE db_orders SET resi_number='".$this->post("no_resi")."' WHERE sorting_id='".$this->get("id")."' ");

				}

				

			}elseif($this->post("verifikasi") == "resolve"){

				save_activity("Memverifikasi resolve komplain dari invoice id <b>".$this->data_order()['invoice_id']."</b>");

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
				require_once(SERVER."/application/views/mail/resolve.php");
				$ob = ob_get_clean();

				PHPmailer($user['email'],"Resolve : Komplain pemesanan produk \"".$product['title']."\" [".$order['invoice_id']."] ", $ob);

				ob_start();
				require_once(SERVER."/application/views/mail/finish_order.php");
				$ob = ob_get_clean();

				PHPmailer($user['email'],"Pesanan Selesai : \"".stringLimit($product['title'],70," ...")."\" [".$order['invoice_id']."]", $ob);

				save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Pengajuan komplen anda untuk produk {product_title} dengan kode pembayaran {invoice} akan kami tangani ( Resolve ) sesuai kesepakatan yang telah di diskusikan sebelumnya.'",
						"icon"	=> "'resolve'",
						"url"	=> "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

				$this->verfikasi(6,5);
				$this->verfikasi(8,6);


				if(!empty($this->post("note"))) 
					$this->db()->query("UPDATE db_orders SET note_deal_complain='".strip_tags(str_replace("'",null,$this->post("note")))."' WHERE sorting_id='".$this->get("id")."'  ");

				$this->db()->query("UPDATE db_chats SET status='1' WHERE chat_object='".$this->get("id")."' ");

				

			}elseif($this->post("verifikasi") == "barang_sampai"){

				save_activity("Memverifikasi barang sampai dari invoice id <b>".$this->data_order()['invoice_id']."</b>");

				$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
				$order = $order->fetch();
				
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

				$this->verfikasi(4,3);

				


			}elseif($this->post("verifikasi") == "refund"){

				save_activity("Memverifikasi refund komplain dari invoice id <b>".$this->data_order()['invoice_id']."</b>");

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

				$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE invoice_id='".$order['invoice_id']."' ");
				
				if(wallet_system() == true){
					if($order['status'] == 5){

						$total = $order['price'] * $order['total_order'];
						$this->db()->query("insert into db_wallet (user_id, saldo, type, invoice_id, date_time) 
						values ('".$user['id']."','".$total."','0','".$order['invoice_id']."','".time()."')");

					}
				}

				
				$show = $order;

				ob_start();
				require_once(SERVER."/application/views/mail/resolve.php");
				$ob = ob_get_clean();

				PHPmailer($user['email'],"Refund : Komplain pemesanan produk \"".$product['title']."\" [".$order['invoice_id']."] ", $ob);

				ob_start();
				require_once(SERVER."/application/views/mail/finish_order.php");
				$ob = ob_get_clean();

				PHPmailer($user['email'],"Pesanan Selesai : \"".stringLimit($product['title'],70," ...")."\" [".$order['invoice_id']."]", $ob);

				save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Pengajuan komplen anda untuk produk {product_title} dengan kode pembayaran {invoice} akan kami refund sesuai kesepakatan yang telah di diskusikan sebelumnya.'",
						"icon"	=> "'refund'",
						"url"	=> "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

				$this->verfikasi(7,5);
				$this->verfikasi(8,7);


				if(!empty($this->post("note"))) 
					$this->db()->query("UPDATE db_orders SET note_deal_complain='".strip_tags(str_replace("'",null,$this->post("note")))."' WHERE sorting_id='".$this->get("id")."'  ");

				$this->db()->query("UPDATE db_chats SET status='1' WHERE chat_object='".$this->get("id")."' ");

				

			}elseif($this->post("verifikasi") == "tolak"){

				$check = $this->db()->query("SELECT * FROM db_orders WHERE status < 3 and sorting_id='".$this->get("id")."' ");
				if($check->rowCount() > 0){

					$this->db()->query("UPDATE db_orders SET rec_cancel='0' WHERE sorting_id='".$this->get("id")."' ");
					$this->db()->query("UPDATE db_cancel_order SET status='2' WHERE order_id='".$this->get("id")."' ");

					save_activity("Menolak pembatalan pesanan dari invoice id <b>".$this->data_order()['invoice_id']."</b>");

					$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
					$order = $order->fetch();

					$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
					$product = $product->fetch();

					$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$order['user_id']."'");
					$user = $user->fetch();

					$show = $order;

					ob_start();
					require_once(SERVER."/application/views/mail/reject_cancel_order.php");
					$ob = ob_get_clean();

					PHPmailer($user['email'],"[Pemberitahuan] : Pengajuan pembatalan pesanan ".$order['invoice_id']." ditolak", $ob);

					save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Pembatalan pesanan untuk produk {product_title} dengan kode pembayaran {invoice} tidak dapat kami proses, karena barang telah kami teruskan ke jasa pengiriman.'",
						"icon"	=> "'reject-cancel'",
						"url"	=> "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

					echo "<script>alert('Berhasil');window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";

				}

				

			}elseif($this->post("verifikasi") == "terima"){

				$check = $this->db()->query("SELECT * FROM db_orders WHERE status < 3 and sorting_id='".$this->get("id")."' ");
				if($check->rowCount() > 0){

					$old_order = $check->fetch();

					$this->db()->query("UPDATE db_orders SET rec_cancel='0', status='9' WHERE sorting_id='".$this->get("id")."' ");
					$this->db()->query("insert into db_log_order (order_id, type, time) values ('".$this->get("id")."','9','".time()."')");
					$this->db()->query("UPDATE db_cancel_order SET status='1' WHERE order_id='".$this->get("id")."' ");

					save_activity("Menerima pembatalan pesanan dari invoice id <b>".$this->data_order()['invoice_id']."</b>");

					$order = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' ");
					$order = $order->fetch();

					$shipp = $this->db()->query("SELECT * FROM db_delivery_service WHERE id='".$order['delivery_service']."'  ");
					$shipp = $shipp->fetch();

					$product = $this->db()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
					$product = $product->fetch();

					$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$order['user_id']."'");
					$user = $user->fetch();

					$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE invoice_id='".$order['invoice_id']."' ");
					$wallet = $wallet->fetch();

					$refund_msg = null;

					if(wallet_system() == true){
						
						if($old_order['status'] == 2){

							$total = $order['price'] * $order['total_order'] + $shipp['price'];
							$this->db()->query("insert into db_wallet (user_id, saldo, type, invoice_id, date_time) 
							values ('".$user['id']."','".$total."','0','".$order['invoice_id']."','".time()."')");
							$refund_msg = " Dana secara otomatis akan masuk ke dalam dompet digital anda";

						}

						if($old_order['status'] == 0){
							if($old_order['wallet'] == "1"){
								$total = $wallet['saldo'] - $wallet['saldo'] - $wallet['saldo'];
								$this->db()->query("insert into db_wallet (user_id, saldo, type, invoice_id, date_time) 
								values ('".$user['id']."','".$total."','0','".$order['invoice_id']."','".time()."')");
								$refund_msg = " Dana secara otomatis akan masuk ke dalam dompet digital anda";
							}

						}

					}else $refund_msg = " Dana akan di Transfer ke rekeking yang anda gunakan sebelumnya.";

					$show = $order;

					ob_start();
					require_once(SERVER."/application/views/mail/accept_cancel_order.php");
					$ob = ob_get_clean();

					PHPmailer($user['email'],"[Pemberitahuan] : Pengajuan pembatalan pesanan ".$order['invoice_id']." Berhasil", $ob);

					save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'".$order['sorting_id']."'",
						"msg" => "'Pembatalan pesanan untuk produk {product_title} dengan kode pembayaran {invoice} berhasil.".$refund_msg."'",
						"icon"	=> "'accept-cancel'",
						"url"	=> "'clientarea/detail_pesanan'",
						"date_time" => "'".time()."'"
					));

					echo "<script>alert('Berhasil');window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";



				}

			}elseif($this->post("verifikasi") == "set_price"){

				$query = $this->db()->query("SELECT * FROM db_cancel_order WHERE order_id='".$this->get("id")."' and status='0'");

				if($query->rowCount() > 0){

					echo "<script>alert('Pesanan ini memiliki permintaan pembatalan, Mohon tindak lanjuti terlebih dahulu');window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";
					exit;

				}

				$order = $this->db()->query("SELECT * FROM db_orders WHERE status < 1 and sorting_id='".$this->get("id")."' ");

				if($order->rowCount() > 0){

					$order = $order->fetch();

					$old_order = $order;

					$check = $this->db()->query("SELECT * FROM db_order_pending WHERE order_id='".$this->get("id")."' ");
					if($check->rowCount() == 0){

						if($order['wallet'] == "1"){

							$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".$order['user_id']."' and type != 1 ");
							$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".$order['user_id']."' and type = 1 and status = 1 ");
							$saldo = $saldo0['saldo'] + $saldo1['saldo'];

							$total = ($order['price'] * $order['total_order']) + $this->post("price");

							$range = $total - $saldo;

							$tf_id = "TRF/".date("dmY/His")."/".$order['user_id'];

							if($saldo >= $total){

								$this->db()->query("insert into db_log_order (order_id, type, time) values ('".$order['sorting_id']."', '1', '".time()."')");
								$this->db()->query("insert into db_log_order (order_id, type, time) values ('".$order['sorting_id']."', '2', '".time()."')");
								$this->db()->query("insert into db_wallet (tf_id, user_id, saldo, type,  invoice_id, date_time) values (
									'".$tf_id."',
									'".$order['user_id']."',
									'".($total - ($total * 2))."',
									'2',
									'".$order['invoice_id']."',
									'".time()."'
								)");

								$this->db()->query("insert into db_order_pending (order_id, user_id, delivery_id, weight, price) 
								values ('".$this->get("id")."','".$order['user_id']."','".$order['delivery_service']."','".$this->post("weight")."','".$this->post("price")."')
								");

								$this->db()->query("UPDATE db_delivery_service SET price='".$this->post("price")."' WHERE id='".$order['delivery_service']."' ");

								$this->db()->query("UPDATE db_orders SET start_time='".time()."', status='2' WHERE sorting_id='".$this->get("id")."'  ");

							}elseif($saldo < $total){

								if($range < 10000) $new_saldo = (($saldo - ($saldo * 2)) + ((10000 - $range)));
								else $new_saldo = $saldo - ($saldo * 2);

									$this->db()->query("insert into db_wallet (tf_id, user_id, saldo, type,  invoice_id, date_time) values (
										'".$tf_id."',
										'".$order['user_id']."',
										'".$new_saldo."',
										'2',
										'".$order['invoice_id']."',
										'".time()."'
									)");

									$this->db()->query("insert into db_order_pending (order_id, user_id, delivery_id, weight, price) 
									values ('".$this->get("id")."','".$order['user_id']."','".$order['delivery_service']."','".$this->post("weight")."','".$this->post("price")."')
									");

									$this->db()->query("UPDATE db_delivery_service SET price='".$this->post("price")."' WHERE id='".$order['delivery_service']."' ");

									$this->db()->query("UPDATE db_orders SET start_time='".time()."' WHERE sorting_id='".$this->get("id")."'  ");	

							}

						}else{

							$this->db()->query("insert into db_order_pending (order_id, user_id, delivery_id, weight, price) 
							values ('".$this->get("id")."','".$order['user_id']."','".$order['delivery_service']."','".$this->post("weight")."','".$this->post("price")."')
							");

							$this->db()->query("UPDATE db_delivery_service SET price='".$this->post("price")."' WHERE id='".$order['delivery_service']."' ");

							$this->db()->query("UPDATE db_orders SET start_time='".time()."' WHERE sorting_id='".$this->get("id")."'  ");

						}

						save_activity("Menetapkan harga ongkos kirim dari invoice id <b>".$this->data_order()['invoice_id']."</b>");


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

						if($old_order['wallet'] == "1"){

							if($saldo >= $total){

								$bank['icon'] = "wallet.png";
								$bank['bank_name'] = "Dompet Digital";
								$bank['bank_info'] = $tf_id;
								$bank['code_bank'] = "-";
								$res_wallet = true;

								ob_start();
								require_once(SERVER."/application/views/mail/payment_verification.php");
								$ob = ob_get_clean();

								PHPmailer($user['email'],"Pembayaran berhasil sepenuhnya menggunakan Digital Wallet - ".$tf_id, $ob);

								save_alert(array(
									"user_id" => "'".$order['user_id']."'",
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

									PHPmailer($user['email'],"Menunggu Pembayaran Bank ".$bank['bank_name']." Untuk Pembayaran ".$invoice, $ob);

									save_alert(array(
										"user_id" => "'".$order['user_id']."'",
										"order_id" => "'".$order['sorting_id']."'",
										"msg" => "'Pembayaran untuk produk {product_title} dengan kode pembayaran {invoice} Sebagain sudah dibayar dengan saldo Dompet Digital anda, Silahkan lakukan sisa pembayaran.'",
										"icon"	=> "'finish-order'",
										"url" => "'clientarea/detail_pesanan'",
										"date_time" => "'".time()."'"
									));
								
								
						}
						}else{

							ob_start();
							require_once(SERVER."/application/views/mail/pending_pay.php");
							$ob = ob_get_clean();

							PHPmailer($user['email'],"Menunggu Pembayaran Bank ".$bank['bank_name']." Untuk Pembayaran ".$show['invoice_id'], $ob);

							save_alert(array(
								"user_id" => "'".$user['id']."'",
								"order_id" => "'".$order['sorting_id']."'",
								"msg" => "'Rincian pembayaran untuk pemesanan produk {product_title} dengan kode pembayaran {invoice} telah kami update, segera cek pesanan anda dan lakukan pembayaran.'",
								"icon"	=> "'detail-price'",
								"url"	=> "'clientarea/konfirmasi_pembayaran'",
								"date_time" => "'".time()."'"
							));

						}


						echo "<script>alert('Berhasil');window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";

					}

				}

			}

		}

		function verfikasi($type,$check){

			if($this->check($check) == true){

				$data = array(
					"status" => "'".$type."'"
				);

				foreach($data as $key => $val){

					$build[] = $key."=".$val;

				}

				if($this->db()->query("UPDATE db_orders SET ".implode(",",$build)." WHERE sorting_id='".$this->get("id")."'")){

				$this->db()->query("INSERT INTO db_log_order (order_id, type, time) VALUES ('".$this->get("id")."','".$type."','".time()."')");

				echo "<script>alert('Berhasil');window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";

				}else

				echo "<script>alert('Gagal');window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";

			}else{

				echo "<script>window.location='".HomeUrl()."/adminpanel/lihatorder?id=".$this->get("id")."';</script>";

			}

		}

		function data_order(){

			$query = $this->db()->query("SELECT * FROM  db_orders WHERE sorting_id='".$this->get("id")."' ");

			$show = $query->fetch();

			return $show;
		}

		function check($check){

			$query = $this->db()->query("SELECT * FROM  db_orders WHERE sorting_id='".$this->get("id")."' ");

			$show = $query->fetch();

			if($show['status'] == $check){

				return true;

			}else{

				return false;

			}

		}

	}