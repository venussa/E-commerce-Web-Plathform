<?php
	
	class auth_reset extends load{

		function __construct(){

			if($this->check_email() == false) 
			$response = array("login/reset/".splice(3)."/".time(), "Email tidak terdaftar");

			elseif($this->check_password() == false)
			$response = array("login/reset/".splice(3)."/".time(), "Password baru tidak cocok");

			elseif($this->check_chaptcha() == false)
			$response = array("login/reset/".splice(3)."/".time(), "Chaptcha salah");


			else{


				if(($this->db()->query("select * from db_reset_pass where email='".decrypt(splice(3))."' and status='0' "))->rowCount() !== 0 ){

					$this->db()->query("UPDATE db_reset_pass SET status='1' WHERE email='".decrypt(splice(3))."'  ");
				}

				$this->db()->query("UPDATE db_users SET password='".md5($this->clean_data()->password)."' WHERE email='".decrypt(splice(3))."' ");

				$response = array("login", "Berhasil, silahkan login");

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


		function check_email(){

			$query = $this->query("email",decrypt(splice(3)));

			if($query->rowCount() == 0) return false;

			else return true;

		}
		
		function check_password(){

			if((strlen($this->clean_data()->password) < 6) or (strlen($this->clean_data()->password) > 12)) return false;

			elseif($this->clean_data()->password !== $this->clean_data()->repassword) return false;

			else return true;

		}


		function check_chaptcha(){

			if($this->clean_data()->chaptcha !== $_SESSION["captcha_code"]) return false;

			else return true;

		}

	}