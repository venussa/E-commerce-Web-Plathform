<?php
	
	class auth extends load{

		function __construct(){

			if($this->check_username() == false){
				$response = array("login", "username anda salah");
			}elseif($this->check_password() == false){
				$response = array("login", "password anda salah");
			}elseif($this->check_chaptcha() == false){
				$response = array("login", "chaptcha tidak valid");
			}else{

				$_SESSION['user'] = ($this->clean_data()->username);
				setcookie("user", encrypt($this->clean_data()->username), time() + 31000000,"/");

				if(userinfo()->level < 2)
				$response = array("clientarea/dashboard", "Login berhasil, selamat datang");
				if(userinfo()->level >= 2){
					
					save_activity("Telah Login");
					$response = array("adminpanel/dashboard", "Login berhasil, selamat datang");

				}

			}
			unset($_SESSION);
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


		function check_username(){

			$query = $this->query("username",$this->clean_data()->username);

			if($query->rowCount() == 0) return false;

			else return true;

		}

		function check_password(){

			$query = $this->query("username",$this->clean_data()->username);
			$show = $query->fetch();

			if(md5($this->clean_data()->password) !== $show['password']) return false;

			else return true;

		}


		function check_chaptcha(){

			if($this->clean_data()->chaptcha !== $_SESSION["captcha_code"]) return false;

			else return true;

		}

	}

	