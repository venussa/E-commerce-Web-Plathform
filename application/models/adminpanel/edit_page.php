<?php
	
	class edit_page extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				if(empty($this->post("level"))) role_access("blog", "2");
				if(!empty($this->post("level"))) role_access("custom", "2");
			}

			if($this->check_page() == true){

				if($this->insert_data() !== false){

					if(empty($this->post("level"))) {
						save_activity("Melakukan perubahan kontent blogs berjudul <b>".$this->post("title")."</b>");
						echo "<script>window.location='".HomeUrl()."/adminpanel/blogs';</script>";
					}else{
						save_activity("Melakukan perubahan custom pages berjudul <b>".$this->post("title")."</b>");
						echo "<script>window.location='".HomeUrl()."/adminpanel/page_content';</script>";
					}

				}

				else echo "<script>alert('Gagal');window.history.back();</script>";

			}else echo "<script>alert('Gagal');window.history.back();</script>";

		}

		function check_page(){

			$old_slug = $this->db()->query("SELECT * FROM db_custom_page WHERE id='".$this->get("id")."' ");
			$old_show = $old_slug->fetch();

			$query = $this->db()->query("SELECT * FROM db_custom_page WHERE slug='".$this->post("slug")."' ");
			$show = $query->fetch();


			if($this->post("slug") !== $old_show['slug']){

				if($query->rowCount() > 0 ) return false;

			}

	
			return true;

		}

		function insert_data(){

			foreach ($this->post() as $key => $value) {
					
				$data[] = $key."='".$value."'";

			}

			if(empty($this->post("description"))) $data[] = "description='".stringLimit(strip_tags($this->post('content')),160)."'";

			if(!empty($this->post("contact_form"))) $data[] = "contact_form='1'";
			if(empty($this->post("contact_form"))) $data[] = "contact_form='0'";

			if($this->post("level") == "Normal") $data[] = "level='0'";
			if($this->post("level") == "Slider") $data[] = "level='1'";
			if(empty($this->post("level"))) $data[] = "level='2'";

			if(empty($this->post("level"))) {
				
				$data[] = "date_time='".time()."'";

			}


			if(isset($_FILES['img']) and !empty($_FILES['img']['name'])){

				$file = $_FILES['img'];
				$allow = array("jpg","jpeg","png");
				$ext = get_extention($file['name']);
				$generate_name = time().".".$ext;
				$path = SERVER."/sources/website/".$generate_name;

				if(in_array($ext, $allow)){

					if(move_uploaded_file($file['tmp_name'], $path)){

						$data[] = "img='".$generate_name."'";;

					}

				}

			}

			$value = implode(",",$data);

			$this->db()->query("UPDATE db_custom_page SET $value WHERE id='".$this->get("id")."' ");

			return true;

		}


	}

?>