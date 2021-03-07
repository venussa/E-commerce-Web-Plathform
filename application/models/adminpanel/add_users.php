<?php
	
	class add_users extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("user", "1");
			}

			switch (strtolower($this->post("level"))) {
				case 'customer':
					$level = 0;
					break;
				
				case 'suplier':
					$level = 1;
					break;

				case 'admin':
					$level = 2;
					break;

			}

			if($level >= userinfo()->level){

				echo "<script>alert('Anda tidak bisa membuat user berlevel seatara/diatas anda');window.location='".HomeUrl()."/adminpanel/users';</script>";

			}elseif($this->save_data() == "sukses"){

				echo "<script>alert('User berhasil di tambhakan');window.location='".HomeUrl()."/adminpanel/users';</script>";

			}else{

				echo "<script>alert('".$this->save_data()."');window.history.back();</script>";

			}

		}

		function check_data(){

			foreach($this->post() as $key => $val){

				$post[$key] = strip_tags(str_replace("'",null,$val));

			}

			$query = $this->db()->query("SELECT * FROM db_users WHERE email='".$post['email']."' or username='".$post['username']."' or phone_number='".$post['phone_number']."' ");

			if($query->rowCount() !== 0){

				return false;

			}else{

				return true;

			}

		}

		function save_data(){

			if($this->check_data() == true){

				foreach($this->post() as $key => $val){

					$post[$key] = strip_tags(str_replace("'",null,$val));

				}


				if($post['password'] !== $post['retype_password'])
				return "Password Tidak Cocok";

				if((strlen($post['username']) < 8) or (strlen($post['username']) > 12))
				return "Username Minimal 8 dan maksimal 12 karakter";

				if((strlen($post['password']) < 8) or (strlen($post['password']) > 12))
				return "Password Minimal 8 dan maksimal 12 karakter";

				switch (strtolower($post['level'])) {
					case 'customer':
						$post['level'] = 0;
						break;
					
					case 'suplier':
						$post['level'] = 1;
						break;

					case 'admin':
						$post['level'] = 2;
						break;

				}


				$data = array(

					"first_name" => "'".$post['first_name']."'",
					"last_name" => "'".$post['last_name']."'",
					"gender" => "'".$post['gender']."'",
					"address" => "'".$post['address']."'",
					"state" => "'".$post['state']."'",
					"district" => "'".$post['district']."'",
					"province" => "'".$post['province']."'",
					"zip_code" => "'".$post['zip_code']."'",
					"phone_number" => "'".$post['phone_number']."'",
					"email" => "'".$post['email']."'",
					"regis_date" => "'".time()."'",
					"username" => "'".$post['username']."'",
					"password" => "'".md5($post['password'])."'",
					"level" => "'".$post['level']."'",
					"status" => "'1'"

				);

				$field = implode(",",array_keys($data));
				$value = implode(",",($data));

				$this->db()->query("INSERT INTO db_users ($field) VALUES ($value)");

				$get_new_user = $this->db()->query("SELECT * FROM db_users WHERE username='".$post['username']."' ");
				$get_new_user = $get_new_user->fetch();

				if($post['level'] <= 2){

					$data = array(
						"user_id" => "'".$get_new_user['id']."'",
						"address" => "'".$get_new_user['address']."'",
						"district" => "'".$get_new_user['district']."'",
						"state" => "'".$get_new_user['state']."'",
						"province" => "'".$get_new_user['province']."'",
						"zip_code" => "'".$get_new_user['zip_code']."'",
						"nama_penerima" => "'".ucwords($get_new_user['first_name']." ".$get_new_user['last_name'])."'",
						"phone_number" => "'".$get_new_user['phone_number']."'",
						"label" => "'Rumah'"
					);

					$field = implode(",",array_keys($data));
					$value = implode(",",($data));

					$this->db()->query("INSERT INTO db_destination_address ($field) VALUES ($value)");

				}

				save_activity("Melakukan penambahan data pengguna dengan username <b>".$post['username']."</b>");

				return "sukses";

			}else return "Username/ Email/ Nomor Telephone Sudah Terpakai";

		}

	}