<?php

	class change_profile extends load{

		function __construct(){

			if(($this->check_email() == true) and (!empty($this->post("email"))))
				$response = array("clientarea/pengaturan_profile", "Email tidak valid");

			elseif(($this->verifikasi() == false) and (!empty($this->post("email"))))
				$response = array("clientarea/pengaturan_profile", "Kode verifikasi salah");

			elseif(($this->check_oldpassword() == false) and (!empty($this->post("oldpassword"))))
				$response = array("clientarea/pengaturan_profile", "Password lama salah");

			elseif(($this->check_match_password() == false) and (!empty($this->post("oldpassword"))))
				$response = array("clientarea/pengaturan_profile", "Password baru tidak cocok");

			else{

				$response = array("clientarea/pengaturan_profile", "Berhasil");
				$this->input_data();

			}

			echo "<script>alert('".$response[1]."');window.location='".HomeUrl()."/".$response[0]."';</script>";

		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = strip_tags(str_replace("'",null,$value));

			}

			return json_decode(json_encode($data));

		}

		function query($field, $value){

			return $this->db()->query("SELECT * FROM db_users WHERE ".$field."='".$value."' ");

		}

		function input_data(){

			if(isset($_FILES['profile_pict']) and (!empty($_FILES['profile_pict']['name']))){

				$file = $_FILES['profile_pict'];
				$allow_ext = array("jpg","png","jpeg");
				$get_ext = get_extention($file['name']);
				$name = time()."_".date("His").".".$get_ext;
				$path = SERVER."/sources/usr_pict/".$name;
				$old_path = SERVER."/sources/usr_pict/".userinfo()->profile_pict;

				if(in_array($get_ext,$allow_ext)){

					if(move_uploaded_file($file['tmp_name'], $path)){

						$data['profile_pict'] = "'".$name."'";
						unlink($old_path);

					}

				}

			}

			if(!empty($this->post("email")))
			$data["email"] 			 = "'".$this->clean_data()->email."'";

			if(!empty($this->post("oldpassword")))
			$data["password"] 		 = "'".md5($this->clean_data()->newpassword)."'";

			$data["first_name"]		 = "'".$this->clean_data()->first_name."'";
			$data["last_name"] 		 = "'".$this->clean_data()->last_name."'";
			$data["gender"] 		 = "'".$this->clean_data()->gender."'";
			$data["phone_number"] 	 = "'".$this->clean_data()->phone_number."'";
			$data["address"]		 = "'".$this->clean_data()->address."'";
			$data["district"] 		 = "'".$this->clean_data()->district."'";
			$data["state"] 			 = "'".$this->clean_data()->state."'";
			$data["province"] 		 = "'".$this->clean_data()->province."'";
			$data["zip_code"] 		 = "'".$this->clean_data()->zip_code."'";

			foreach($data as $key => $val){

				$field[] = $key."=".$val;

			}

			$field = implode(",",$field);

			$this->db()->query("UPDATE db_users SET $field WHERE id='".userinfo()->user_id."' ");

			return true;

		}

		function check_email(){

			if($this->clean_data()->email !== $this->clean_data()->remail) return true;

			$query = $this->query("email",$this->clean_data()->email);

			if($query->rowCount() == 0) return false;

			else return true;

		}

		function check_oldpassword(){

			if(md5($this->clean_data()->oldpassword) !== userinfo()->password) return false;

			return true;

		}

		function check_match_password(){

			if($this->clean_data()->newpassword !== $this->clean_data()->renewpassword) return false;

			return true;
		}

		function verifikasi(){

			if($this->clean_data()->verifikasi == (String) $_SESSION['verification_code']) return true;

			else return false;

		}

	}
