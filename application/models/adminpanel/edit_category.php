<?php
	
	class edit_category extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("category", "2");
			}

			$data['title'] = "'".$this->post("title")."'";
			$data['description'] = "'".$this->post("description")."'";
			$data['uniq_id'] = "'".$this->post("uniq_id")."'";
			


			if($this->post("category") == "None"){

				$data['transaction_scheme'] = "'".$this->post("transaction_scheme")."'";
				$data['level'] = "'0'";
				$data['sublevel'] = "'0'";

			}else{

				$data['transaction_scheme'] = "'".$this->get_category()['transaction_scheme']."'";
				$data['level'] = "'1'";
				$data['sublevel'] = "'".$this->get_category()['id']."'";

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

			foreach($data as $key => $val){

				$build[] = $key."=".$val;

			}

			$old_data = ($this->db()->query("SELECT * FROM db_category WHERE id='".$this->get("id")."' "))->fetch();

			if($this->db()->query("UPDATE db_category SET ".implode(",",$build)."WHERE id='".$this->get("id")."'")){

				if($this->post("category") == "None"){
				$this->db()->query("UPDATE db_category SET transaction_scheme='".$this->post("transaction_scheme")."' WHERE sublevel='".$this->get("id")."' ");
				}

				save_activity("melakukan perubahan data category bernama <b>".$old_data['title']."</b> menjadi <b>".$this->post("title")."</b>");

				echo "<script>alert('Berhasil di edit');window.location='".HomeUrl()."/adminpanel/category';</script>";

			}else{

				echo "<script>alert('Gagal di edit');window.location='".HomeUrl()."/adminpanel/category';</script>";

			}
		}

		


		function get_category(){

			$query = $this->db()->query("SELECT * FROM db_category WHERE title='".$this->post("category")."' ");

			return $query->fetch();

		}


	}