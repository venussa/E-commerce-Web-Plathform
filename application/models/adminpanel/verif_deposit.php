<?php
	
	class verif_deposit extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("deposit", "6");
			}
			if(userinfo() !== false) $this->input_data();

		}

		function check_data(){

			$query = $this->db()->query("SELECT * FROM db_deposit_request WHERE tf_id='".urldecode($this->get("id",["'"]))."' and type='3' and status='0' ");

			if($query->rowCount() > 0) return true;
			
			return false;

		}

		function input_data(){

			if($this->check_data() == true){

				$query = $this->db()->query("SELECT * FROM db_deposit_request WHERE tf_id='".urldecode($this->get("id",["'"]))."' and type='3' and status='0' ");
				$show = $query->fetch();

				$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."' ");
				$user = $user->fetch();

				$this->db()->query("UPDATE db_deposit_request SET status='1' WHERE type='3' and tf_id='".urldecode($this->get("id",["'"]))."' ");

				$this->db()->query("INSERT INTO db_wallet (tf_id, user_id, saldo, bank_name, rekening_number, card_name, picture, type, date_time) VALUES (
				'".$show['tf_id']."',
				'".$show['user_id']."',
				'".$show['saldo']."',
				'".$show['bank_name']."',
				'".$show['rekening_number']."',
				'".$show['card_name']."',
				'".$show['picture']."',
				'".$show['type']."',
				'".time()."'
				)");

				ob_start();
				require_once(SERVER."/application/views/mail/deposit_alert.php");
				$ob = ob_get_clean();

				PHPmailer($user['email'],"Deposit saldo dompet digital Berhasil [ ID Transaksi : ".$show['tf_id']." ]", $ob);

				save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'0'",
						"msg" => "'Deposit saldo dompet digital anda telah kami proses <b style=\"text-decoration:none;color:orangered;font-weight:400;\">[ ".$show['tf_id']." ]</b>, Dana sudah terdeposit ke dompet digital anda.'",
						"icon"	=> "'deposit'",
						"url"	=> "'clientarea/riwayat_saldo'",
						"date_time" => "'".time()."'"
					));

				echo "<script>window.location='".HomeUrl()."/adminpanel/request_deposit';</script>";

			}

		}

	}

?>