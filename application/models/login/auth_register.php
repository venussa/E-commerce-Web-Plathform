<?php
	
	class auth_register extends load{

		function __construct(){

			if($this->get("type") == "0"){

				if($this->check_verification() == true) echo "<true/>";
				else echo "<false/>";

			}else{

				if($this->check_empty() == false)
					$response = array("login/register", "Mohon isi semua data");

				elseif($this->check_email() == true)
					$response = array("login/register", "username anda sudah dipakai");

				elseif($this->check_verification() == false)
					$response = array("login/register", "Kode Verifikasi Salah");

				elseif($this->check_username() == false)
					$response = array("login/register", "username sudah di gunakan");

				elseif($this->check_password() == false)
					$response = array("login/register", "Password tidak cocok");

				elseif($this->check_chaptcha() == false)
					$response = array("login/register", "chaptcha salah");

				elseif($this->save_user() == false)
					$response = array("login/register", "Gagal mendaftar, silahkan coba lagi");

				else
					$response = array("login", "Berhasil mendaftar, silakan login");
				

				unset($_SESSION);
				echo "<script>alert('".$response[1]."');window.location='".HomeUrl()."/".$response[0]."';</script>";

			}

		}

		function save_user(){

			$data = array(

				"first_name"	=> "'".$this->clean_data()->first_name."'",
				"last_name" 	=> "'".$this->clean_data()->last_name."'",
				"gender" 		=> "'".$this->clean_data()->gender."'",
				"email" 		=> "'".$this->clean_data()->email."'",
				"phone_number" 	=> "'".$this->clean_data()->phone_number."'",
				"address"		=> "'".$this->clean_data()->address."'",
				"district" 		=> "'".$this->clean_data()->district."'",
				"state" 		=> "'".$this->clean_data()->state."'",
				"province" 		=> "'".$this->clean_data()->province."'",
				"zip_code" 		=> "'".$this->clean_data()->zip_code."'",
				"username" 		=> "'".$this->clean_data()->username."'",
				"password" 		=> "'".md5($this->clean_data()->password)."'",
				"regis_date" 	=> "'".time()."'",
				"level" 		=> "'0'",
				"status" 		=> "'1'"

			);

			$field = implode(",",array_keys($data));
			$value = implode(",",($data));

			if($this->db()->query("INSERT INTO db_users ($field) VALUES ($value)")){

				$get_new_user = $this->db()->query("SELECT * FROM db_users WHERE username='".$this->clean_data()->username."' ");
				$get_new_user = $get_new_user->fetch();



				$data = array(
					"user_id" => "'".$get_new_user['id']."'",
					"address" => "'".$get_new_user['address']."'",
					"district" => "'".$get_new_user['district']."'",
					"state" => "'".$get_new_user['state']."'",
					"province" => "'".$get_new_user['province']."'",
					"zip_code" => "'".$get_new_user['zip_code']."'",
					"nama_penerima" => "'".ucwords($get_new_user['first_name']." ".$get_new_user['last_name'])."'",
					"phone_number" => "'".$get_new_user['phone_number']."'",
					"label"	=> "'Rumah'"
				);

				$field = implode(",",array_keys($data));
				$value = implode(",",($data));

				$this->db()->query("INSERT INTO db_destination_address ($field) VALUES ($value)");

				return true;

			}

				

			return false;

		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = str_replace("'",null,$value);

			}

			return json_decode(json_encode($data));

		}

		function check_empty(){

			foreach($this->post() as $key => $value){

				if(empty(trim($value))) return false;

			}

			return true;

		}

		function query($field, $value){

			return $this->db()->query("SELECT * FROM db_users WHERE ".$field."='".$value."' ");

		}

		function check_email(){

			$query = $this->query("email",$this->clean_data()->email);

			if($query->rowCount() == 0) return false;

			else return true;

		}


		function check_username(){

			$query = $this->query("username",$this->clean_data()->username);

			if((strlen($this->clean_data()->username) < 6) or (strlen($this->clean_data()->username) > 12)) return false;

			if($query->rowCount() == 0) return true;

			else return false;

		}

		function check_password(){

			if($this->clean_data()->password !== $this->clean_data()->repassword) return false;
			if((strlen($this->clean_data()->password) < 6 ) or (strlen($this->clean_data()->password) > 12)) return false;

			return true;

		}

		function check_verification(){

			if($this->clean_data()->verifikasi == (String) $_SESSION['verification_code']) return true;

			else return false;

		}


		function check_chaptcha(){

			if($this->clean_data()->chaptcha !== $_SESSION["captcha_code"]) return false;

			else return true;

		}

	}