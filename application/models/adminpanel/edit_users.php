<?php
	
	class edit_users extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("user", "2");
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

				echo "<script>alert('User berhasil di rubah');window.history.back();</script>";

			}else{

				echo "<script>alert('".$this->save_data()."');window.history.back();</script>";

			}

		}


		function save_data(){

			foreach($this->post() as $key => $val){

				$post[$key] = strip_tags(str_replace("'",null,$val));

			}


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

			foreach($_POST as $index => $value){

				if(is_array($_POST[$index])){

					$catch[$index] = $_POST[$index];

				}

			}

			if(isset($catch)) $post['role'] = json_encode($catch);
			else $post['role'] = null;


			$data = array(

				"first_name" => "'".$post['first_name']."'",
				"last_name" => "'".$post['last_name']."'",
				"gender" => "'".$post['gender']."'",
				"address" => "'".$post['address']."'",
				"state" => "'".$post['state']."'",
				"district" => "'".$post['district']."'",
				"province" => "'".$post['province']."'",
				"zip_code" => "'".$post['zip_code']."'",
				"level" => "'".$post['level']."'",
				"role"	=> "'".$post['role']."'"

			);

			foreach ($data as $key => $value) {
				
				$query[] = $key."=".$value;

			}
			$old_data = ($this->db()->query("SELECT * FROM db_users WHERE id='".$this->get("id")."' "))->fetch();

			$this->db()->query("UPDATE db_users SET ".implode(",",$query)." WHERE id='".$this->get("id")."' ");

			save_activity("Melakukan perubahan data pengguna pada username <b>".$old_data['username']."</b>");

			return "sukses";



		}

	}