<?php
	
	class verif_refund extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("refund", "6");
			}
			if(userinfo() !== false) $this->input_data();

		}

		function check_data(){

			$query = $this->db()->query("SELECT * FROM db_wallet WHERE tf_id='".urldecode($this->get("id",["'"]))."' and type='1' and status='0' ");

			if($query->rowCount() > 0) return true;
			
			return false;

		}

		function input_data(){

			if($this->check_data() == true){

				$query = $this->db()->query("SELECT * FROM db_wallet WHERE tf_id='".urldecode($this->get("id",["'"]))."' and type='1' and status='0' ");
				$show = $query->fetch();

				$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."' ");
				$user = $user->fetch();

				$this->db()->query("UPDATE db_wallet SET status='1' WHERE type='1' and tf_id='".urldecode($this->get("id",["'"]))."' ");

				ob_start();
				require_once(SERVER."/application/views/mail/refund_order.php");
				$ob = ob_get_clean();

				PHPmailer($user['email'],"Penarikan saldo dompet digital Berhasil [ ID Transaksi : ".$show['tf_id']." ]", $ob);

				save_alert(array(
						"user_id" => "'".$user['id']."'",
						"order_id" => "'0'",
						"msg" => "'Penarikan saldo dompet digital anda telah kami proses <b style=\"text-decoration:none;color:orangered;font-weight:400;\">[ ".$show['tf_id']." ]</b>, Dana sudah kami transfer ke rekening sesuai data yang anda masukkan.'",
						"icon"	=> "'refund'",
						"url"	=> "'clientarea/riwayat_saldo'",
						"date_time" => "'".time()."'"
					));

				echo "<script>window.location='".HomeUrl()."/adminpanel/request_refund';</script>";

			}

		}

	}

?>