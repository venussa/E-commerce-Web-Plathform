<?php
	
	class add_page extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				if(empty($this->post("level"))) role_access("blog", "1");
				if(!empty($this->post("level"))) role_access("custom", "1");
			}

			if($this->check_page() == false){

				if($this->insert_data() !== false)

					if(empty($this->post("level"))) {
						save_activity("Melakukan penambahan kontent blog berjudul <b>".$this->post("title")."</b>");
						echo "<script>window.location='".HomeUrl()."/adminpanel/blogs';</script>";
					}else{
						save_activity("Melakukan penambahan data custom page berjudul <b>".$this->post("title")."</b>");
						echo "<script>window.location='".HomeUrl()."/adminpanel/page_content';</script>";
					}

				else echo "<script>alert('Gagal');window.history.back();</script>";

			}else echo "<script>alert('Gagal');window.history.back();</script>";

		}

		function check_page(){

			$query = $this->db()->query("SELECT * FROM db_custom_page WHERE slug='".$this->post("slug")."' ");
			if($query->rowCount() == 0) return false;
			return true;

		}

		function insert_data(){

			foreach ($this->post() as $key => $value) {
					
				$data[$key] = "'".$value."'";

			}

			if(empty($this->post("description"))) $data["description"] = stringLimit(strip_tags($data['content']),160);

			$data['status'] = "'1'";

			$data['level'] = "'2'";
			if($this->post("level") == "Normal") $data['level'] = "'0'";
			if($this->post("level") == "Slider") $data['level'] = "'1'";

			if(empty($this->post("level"))) {
			
				$data['date_time'] = "'".time()."'";
				$data['user_id'] = "'".userinfo()->user_id."'";


			}


			if(isset($_FILES['img']) and !empty($_FILES['img']['name'])){

				$file = $_FILES['img'];
				$allow = array("jpg","jpeg","png");
				$ext = get_extention($file['name']);
				$generate_name = time().".".$ext;
				$path = SERVER."/sources/website/".$generate_name;

				if(in_array($ext, $allow)){

					if(move_uploaded_file($file['tmp_name'], $path)){

						$data["img"] = "'".$generate_name."'";;

					}

				}

			}


			$field = implode(",",array_keys($data));
			$value = implode(",",($data));

			$this->db()->query("INSERT INTO db_custom_page ($field) VALUES ($value)");

			return true;

		}


	}

?>