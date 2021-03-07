<?php

	class deposit_saldo extends load{

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

			$query = $this->db()->query("SELECT * FROM db_deposit_request WHERE user_id='".userinfo()->user_id."' and type='3' and status='0' ");
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
				
				if($key !== "code")
				$data[$key] = "'".$value."'";

			}

			$picture = null;

			if(isset($_FILES['picture'])){

				if(!empty($_FILES['picture']['name'])){

					$file = $_FILES['picture'];
					$allow_ext = ["jpg","png","jpeg"];
					$ext = get_extention($file['name']);
					$name = time()."-".userinfo()->user_id.".".$ext;
					$path = SERVER."/sources/bank/".$name;

					if(in_array($ext, $allow_ext)){

						if(move_uploaded_file($file['tmp_name'], $path)){

							$picture = $name;

						}else{

							echo "<script>alert('Data tidak lengkap');window.history.back();</script>";
							return false;

						}

					}else{

						echo "<script>alert('Data tidak lengkap');window.history.back();</script>";
						return false;

					}

				}else{

					echo "<script>alert('Data tidak lengkap');window.history.back();</script>";
					return false;

				}

			}else{

				echo "<script>alert('Data tidak lengkap');window.history.back();</script>";
				return false;

			}

			$data['saldo'] = $data['saldo'];
			$tf_id = "TRF/".date("dmY/His")."/".userinfo()->id;
			$data["user_id"] = "'".userinfo()->user_id."'";
			$data["status"] = "'0'";
			$data["type"] = "'3'";
			$data["date_time"] = "'".time()."'";
			$data["tf_id"] = "'".$tf_id."'";
			$data["picture"] = "'".$picture."'";

			$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_deposit_request WHERE user_id='".userinfo()->user_id."' and type != 1 ");
			$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_deposit_request WHERE user_id='".userinfo()->user_id."' and type=1 and status=1 ");
			$saldo = $saldo0['saldo'] + $saldo1['saldo'];

			if($this->clean_data()->saldo < 10000){
				echo "<script>alert('Minimal deposit Rp 10.000');window.history.back();</script>";
				exit;
			}

			$field = implode(",",array_keys($data));
			$value = implode(",",($data));


			$value = implode(",",($data));

			$this->db()->query("INSERT INTO db_deposit_request ($field) VALUES ($value)");

			$admin = $this->db()->query("SELECT * FROM db_users WHERE level >=2 ");

			while($show = $admin->fetch()){

				ob_start();
				require_once(SERVER."/application/views/mail/rec_deposit.php");
				$ob = ob_get_clean();

				PHPmailer($show['email'],"[Pemberitahuan] ".userinfo()->username." Mengajukan Deposit saldo dompet digital [ID Transaksi : ".$tf_id."]", $ob);

				save_alert(array(
						"user_id" => "'".$show['id']."'",
						"order_id" => "'0'",
						"msg" => "'<b style=\"text-decoration:none;color:orangered;font-weight:400;\">User Id : ".userinfo()->username."</b> mengajukan permintaan deposit saldo dompet digital dengan <b style=\"text-decoration:none;color:orangered;font-weight:400;\">ID Transaksi : ".$tf_id." </b>'",
						"icon"	=> "'deposit'",
						"url"	=> "'adminpanel/deposit_status?id=".$tf_id."'",
						"date_time" => "'".time()."'"
					));

			}
			unset($_SESSION);
			echo "<script>window.location='".HomeUrl()."/clientarea/riwayat_saldo';</script>";

		}

	}