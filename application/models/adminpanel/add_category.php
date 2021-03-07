<?php
	
	class add_category extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("category", "1");
			}

			if($this->check_category() == true){

				$data['title'] = "'".$this->post("title")."'";
				$data['description'] = "'".$this->post("description")."'";
				$data['uniq_id'] = "'".$this->post("uniq_id")."'";
				

				
				if($this->type_category() == 0){

					$data['level'] = "'0'";
					$data['sublevel'] = "'0'";
					$data['transaction_scheme'] = "'".$this->post("transaction_scheme")."'";

				}else{

					$query = $this->db()->query("SELECT * FROM db_category WHERE title='".$this->post("category")."' ");
					$fetch = $query->fetch();

					$data['level'] = "'1'";
					$data['sublevel'] = "'".$fetch['id']."'";
					$data['transaction_scheme'] = "'".$fetch['transaction_scheme']."'";

				}

				if(isset($_FILES['img']) and !empty($_FILES['img']['name'])){

					$file = $_FILES['img'];

					$allow = array("jpg","png","jpeg");
					$ext = get_extention($file['name']);
					$name = time().".".$ext;
					$path = SERVER."/sources/website/".$name;

					if(in_array($ext,$allow)){

						if(move_uploaded_file($file['tmp_name'], $path)){

							$data['img'] = "'".$name."'";

						}

					}


				}

			

				$field = implode(",",array_keys($data));
				$value = implode(",",$data);

				if($this->db()->query("INSERT INTO db_category ($field) VALUES ($value)")){

					save_activity("melakukan penambahan data category <b>".$this->post("title")."</b>");

					echo "<script>alert('Berhasil di tambah');window.location='".HomeUrl()."/adminpanel/category';</script>";

				}else{

					echo "<script>alert('Gagal di tambah');window.location='".HomeUrl()."/adminpanel/category';</script>";

				}

			}else echo "<script>alert('Gagal di tambah');window.location='".HomeUrl()."/adminpanel/category';</script>";
			

		}

		function check_category($object = false){

			$query = $this->db()->query("SELECT * FROM db_category WHERE title='".$this->post("title")."' ");

			if($object == true) return $query->fetch();

			if($query->rowCount() !== 0){

				return false;

			}else return true;

		}

		function type_category(){

			if($this->post("category") == "None"){

				return 0;

			}else{

				return 1;

			}

		}

	}