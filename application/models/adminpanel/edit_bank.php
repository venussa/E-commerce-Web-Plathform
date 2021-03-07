<?php
	
	class edit_bank extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("bank", "2");
			}

			foreach($this->post() as $key => $val){

				$post[$key] = "'".strip_tags(str_replace("'",null,$val))."'";

			}

			if(isset($_FILES['icon']) and !empty($_FILES['icon']['name'])){

				$file = $_FILES['icon'];
				$ext = array("jpg","jpeg","png");
				$get_ext = get_extention($file['name']);
				$generate_name = time().".".$get_ext;
				$path = SERVER."/sources/bank/".$generate_name;
				if(move_uploaded_file($file['tmp_name'], $path)){

					$post['icon'] = "'".$generate_name."'";

				}

			}else{

				$post['icon'] = "icon";

			}

			foreach($post as $key => $value){

				$data[] = $key."=".$value;

			}

			$data = implode(",",$data);

			$old_data = ($this->db()->query("SELECT * FROM db_pay_info WHERE id='".$this->get("id")."' "))->fetch();

			if($this->db()->query("UPDATE db_pay_info SET ".$data." WHERE id='".$this->get("id")."' ")) {

				save_activity("Melakukan perubahan data bank bernama <b>".str_replace("'",null,$old_data['bank_name'])."</b> menjadi <b>".str_replace("'",null,$old_data['bank_name'])."</b>");

				echo "<script>alert('Berhasil di rubah');window.location='".HomeUrl()."/adminpanel/bank';</script>";
				

			}else{

				echo "<script>alert('Gagal menarubah');window.location='".HomeUrl()."/adminpanel/bank';</script>";

			}


		}

	}