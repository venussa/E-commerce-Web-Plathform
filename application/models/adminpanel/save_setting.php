<?php
	
	class save_setting extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				die("Access Danied");
			}

			if($this->save_data() == true){

				echo "<script>alert('Berhasil di simpan');window.location='".HomeUrl()."/adminpanel/settings';</script>";

			}

		}

		function check_allow_extention($data = null){

			$data = get_extention($data);

			$allow = array("jpg","png","jpeg");

			if(!empty($data)){

				if(in_array($data,$allow)){

					return true;

				}

			}

			return false;

		}

		function save_data(){

			foreach($this->set_data() as $key => $val){

				$this->db()->query("UPDATE db_settings SET conf=".$val." WHERE name='".$key."' ");

			}

			save_activity("Melakukan perubahan pengaturan dasar website");

		return true;

		}

		function set_data(){

			foreach($this->post() as $key => $val){

				$post[$key] = strip_tags(str_replace("'",null,$val));

			}

			foreach($_FILES as $key => $val){

				if(!empty($val['name']) and ($key !== "slider")){

					$generate_name = md5($key."".time()).".".get_extention($val['name']);

					$path = SERVER."/sources/image/".$generate_name;

					if($this->check_allow_extention($val['name']) == true) {

						if(move_uploaded_file($val['tmp_name'], $path)) {

							$post[$key] = "'".$generate_name."'";
							$data0[$key] = "'".$generate_name."'";

						}

					}

				}

			}



			$loc = $this->db()->query("SELECT * FROM db_location WHERE name='".$post['state']."' and type='kabupaten' ");
			$loc = $loc->fetch();

			if(strtolower($post['status']) == "active") $status = 1;
			else $status = 0;

			$data1 = array(

				"title"			=> "'".$post['title']."'",
				"tagline"		=> "'".$post['tagline']."'",
				"description"	=> "'".$post['description']."'",
				"address"		=> "'".$post['address']."'",
				"contact"		=> "'".$post['contact']."'",
				"email"			=> "'".$post['email']."'",
				"facebook"		=> "'".$post['facebook']."'",
				"twitter"		=> "'".$post['twitter']."'",
				"instagram"		=> "'".$post['instagram']."'",
				"api"			=> "'".$post['api']."'",
				"province"		=> "'".$post['province']."'",
				"district"		=> "'".$post['district']."'",
				"state"			=> "'".$post['state']."'",
				"zip_code"		=> "'".$post['zip_code']."'",
				"distributor_location" => "'".$loc['loc_id']."'",
				"smtp_host"		=> "'".$post['smtp_host']."'",
				"smtp_port"		=> "'".$post['smtp_port']."'",
				"smtp_user"		=> "'".$post['smtp_user']."'",
				"smtp_pass"		=> "'".$post['smtp_pass']."'",
				"status"		=> "'".$status."'"

			);

			$data = $data1;

			if(isset($data0)) $data = array_merge($data0,$data);

			else $data = $data1;

			return $data;
		}

}