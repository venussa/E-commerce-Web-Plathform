<?php
	
	class auth_forgot_password extends load{

		function __construct(){

			if($this->check_email() == false) 
			$response = array("login/forgot_password", "Email tidak terdaftar");

			elseif($this->check_chaptcha() == false)
			$response = array("login/forgot_password", "Chaptcha salah");


			else{

				$_SESSION['reset_time'] = time();

				$url = HomeUrl()."/login/reset/".encrypt($this->post("email"))."/".$_SESSION['reset_time'];

				PHPmailer($this->post("email"),"Reset Password","<p><b>Klick this url to reset your password</b></p>
				<p>Link : <a href='".$url."'>".$url."</a>, It will expired in 5 minutes.</p>");

				if(($this->db()->query("select * from db_reset_pass where email='".$this->clean_data()->email."' and status='0' "))->rowCount() == 0 ){

					$this->db()->query("insert into db_reset_pass (email, status) values ('".$this->clean_data()->email."','0')");
				}

				$response = array("login", "Berhasil, silahkan check email anda");

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

			$query = $this->query("email",$this->clean_data()->email);

			if($query->rowCount() == 0) return false;

			else return true;

		}


		function check_chaptcha(){

			if($this->clean_data()->chaptcha !== $_SESSION["captcha_code"]) return false;

			else return true;

		}

	}