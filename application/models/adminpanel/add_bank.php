<?php
	
	class add_bank extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("bank", "1");
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

				$post['icon'] = "''";

			}

			$field = implode(",",array_keys($post));
			$value = implode(",",($post));

			if($this->db()->query("insert into db_pay_info ($field) values ($value)")) {

				save_activity("melakukan penambahan data bank <b>".$post['bank_name']."</b> No Rek <b>".$post['bank_info']."</b>");
				
				echo "<script>alert('Berhasil di tambah');window.location='".HomeUrl()."/adminpanel/bank';</script>";


			}else{

				echo "<script>alert('Gagal menambah');window.location='".HomeUrl()."/adminpanel/bank';</script>";

			}


		}

	}