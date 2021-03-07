<?php

	class refund extends load{

		function __construct(){

			if(userinfo() == false){

				header("location:".HomeUrl()."/login");
				exit;

			}

			if(!isset($_SESSION['verification_code'])){
				echo "<script>alert('Kode salah');window.history.back();</script>";
				exit;
			}

			if($this->post("code") !== strval($_SESSION['verification_code'])) {
				echo "<script>alert('Kode salah');window.history.back();</script>";
				exit;
			}


			if((time() - $_SESSION['time_limit']) > 300){
				echo "<script>alert('Kode sudah kadaluarsa');window.history.back();</script>";
				exit;
			}

			if($this->check_data()) $this->input_data();


		}

		function check_data(){

			$query = $this->db()->query("SELECT * FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type='1' and status='0' ");
			$show = $query->fetch();

			if($query->rowCount() == 0) return true;
			if(empty($show['rekening_number'])) return true;
			return false;

		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = strip_tags(str_replace("'",null,$value));

			}

			return json_decode(json_encode($data));

		}

		function input_data(){

			foreach ($this->clean_data() as $key => $value) {
				
				if(($key !== "code") and ($key !== "bank_info"))
				$data[$key] = "'".$value."'";

			}

			if(!empty($this->clean_data()->bank_info)){

				$bank_data = explode("/",$this->clean_data()->bank_info);
				$data['card_name'] = "'".trim($bank_data[2])."'";
				$data['bank_name'] = "'".trim($bank_data[0])."'";
				$data['rekening_number'] = "'".trim($bank_data[1])."'";


			}

			$data['saldo'] = $this->clean_data()->saldo - ($this->clean_data()->saldo * 2);
			$data['saldo'] = "'".$data['saldo']."'";
			$tf_id = "TRF/".date("dmY/His")."/".userinfo()->id;
			$data["user_id"] = "'".userinfo()->user_id."'";
			$data["status"] = "'0'";
			$data["type"] = "'1'";
			$data["date_time"] = "'".time()."'";
			$data["tf_id"] = "'".$tf_id."'";

			$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type != 1 ");
			$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type=1 and status=1 ");
			$saldo = $saldo0['saldo'] + $saldo1['saldo'];

			if($this->clean_data()->saldo > $saldo){
				echo "<script>alert('Melebihi saldo yang anda miliki');window.history.back();</script>";
				exit;
			}

			if($this->clean_data()->saldo < 50000){
				echo "<script>alert('Minimum saldo yang dapat ditarik sebesar RP 50.000 ');window.history.back();</script>";
				exit;
			}

			$field = implode(",",array_keys($data));
			$value = implode(",",($data));


			$value = implode(",",($data));

			$user_bank = $this->db()->query("SELECT * FROM db_user_bank WHERE user_id='".userinfo()->user_id."' and rekening_number='".$this->clean_data()->rekening_number."' ");

			if($user_bank->rowCount() > 0){

				$this->db()->query("UPDATE db_user_bank SET 
					card_name='".$this->clean_data()->card_name."',
					bank_name='".$this->clean_data()->bank_name."',
					rekening_number='".$this->clean_data()->rekening_number."'

					WHERE user_id='".userinfo()->user_id."'
				");

			}else{

				if(empty($this->clean_data()->bank_info)){
					$this->db()->query("INSERT INTO db_user_bank (user_id, card_name, bank_name, rekening_number) VALUES (
					'".userinfo()->user_id."',
					'".$this->clean_data()->card_name."',
					'".$this->clean_data()->bank_name."',
					'".$this->clean_data()->rekening_number."'
					)");
				}

			}

			$this->db()->query("INSERT INTO db_wallet ($field) VALUES ($value)");

			$admin = $this->db()->query("SELECT * FROM db_users WHERE level >=2 ");

			while($show = $admin->fetch()){

				ob_start();
				require_once(SERVER."/application/views/mail/rec_refund.php");
				$ob = ob_get_clean();

				PHPmailer($show['email'],"[Pemberitahuan] ".userinfo()->username." Mengajukan penarikan saldo dompet digital [ID Transaksi : ".$tf_id."]", $ob);

				save_alert(array(
						"user_id" => "'".$show['id']."'",
						"order_id" => "'0'",
						"msg" => "'<b style=\"text-decoration:none;color:orangered;font-weight:400;\">User Id : ".userinfo()->username."</b> mengajukan permintaan penarikan saldo dompet digital dengan <b style=\"text-decoration:none;color:orangered;font-weight:400;\">ID Transaksi : ".$tf_id." </b>'",
						"icon"	=> "'wallet'",
						"url"	=> "'adminpanel/refund_status?id=".$tf_id."'",
						"date_time" => "'".time()."'"
					));

			}
			unset($_SESSION);
			echo "<script>window.location='".HomeUrl()."/clientarea/riwayat_saldo';</script>";

		}

	}