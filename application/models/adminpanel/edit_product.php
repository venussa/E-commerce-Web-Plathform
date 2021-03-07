<?php
	
	class edit_product extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("product", "2");
			}

			if($this->insert_data() == true){

				echo "<script>alert('Berhasil di edit');window.location='".HomeUrl()."/adminpanel/product';</script>";

			}else{

				echo "<script>alert('Gagal di edit');window.history.back();</script>";

			}

		}

		function is_data_exists(){

			$command = "SELECT * FROM db_product WHERE sorting_id='".$this->get("id")."'";
			$query = $this->db()->query($command);
			
			if($query->rowCount() !== 0) return true;

			else return false;
			

		}

		function get_category(){

			$command = "SELECT * FROM db_category WHERE title='".$this->post("category")."' ";
			$query = $this->db()->query($command);
			$fetch = $query->fetch();

			return $fetch;


		}

		function get_sub_category(){

			$command = "SELECT * FROM db_category WHERE title='".$this->post("subcategory")."' ";
			$query = $this->db()->query($command);
			$fetch = $query->fetch();

			return $fetch;

		}

		function set_diskon(){

			if(empty($this->post("discount"))) return false;

			$query = $this->db()->query("SELECT  * FROM db_product_discount WHERE product_id='".$this->get("id")."' ");

			if($query->rowCount() == 0){

				$start_time = strtotime($this->post("start_time"));
				$end_time = strtotime($this->post("end_time"));

				$this->db()->query("INSERT INTO db_product_discount (product_id, price, start_time, end_time) 
					VALUES ('".$this->get("id")."','".$this->post("discount")."','".$start_time."','".$end_time."')");

			}else{

				$start_time = strtotime($this->post("start_time"));
				$end_time = strtotime($this->post("end_time"));

				$this->db()->query("UPDATE db_product_discount SET price='".$this->post("discount")."', start_time='".$start_time."', end_time='".$end_time."' WHERE product_id='".$this->get("id")."' ");

			}

		}

		function insert_data(){

			$command = "SELECT * FROM db_product WHERE sorting_id='".$this->get("id")."'";
			$query = $this->db()->query($command);
			$show = $query->fetch();
			$img = json_decode($show['picture']);

			$allowed = array("jpg","png","gif","jpeg");

			if($this->is_data_exists() == true){

				for($i = 1; $i <= 5; $i++){

					if(isset($_FILES['img'.$i]) and !empty($_FILES['img'.$i]['name'])){

						$old_name = $_FILES['img'.$i]['name'];

						$tmp_file = $_FILES['img'.$i]['tmp_name'];

						$extention = get_extention($old_name);

						if(in_array($extention,$allowed)){

							$newname = time()."-".$i.".".$extention;

							$path = SERVER."/sources/content/".$newname;

							$old_path = SERVER."/sources/content/".$img[$i-1];

							if(move_uploaded_file($tmp_file, $path)){

								$img[$i-1] = $newname;
								unlink($old_path);

							}

						}else return false;

					}

				}


				$product_id = $this->get_category()['uniq_id']."/".$this->get_sub_category()['uniq_id']."/".date("dmYHis");

				$field = array(

						//"product_id" => "'".$product_id."'",
						"title" => "'".$this->post("title")."'",
						"description" => "'".$this->post("description")."'",
						"category" => "'".$this->get_category()['id']."'",
						"sub_category" => "'".$this->get_sub_category()['id']."'",
						"size" => "'".$this->post("size")."'",
						"weight" => "'".$this->post("weight")."'",
						"stock" => "'".$this->post("stock")."'",
						"price" => "'".$this->post("price")."'",
						"picture" => "'".json_encode($img)."'",
						"min_order" => "'".$this->post("min_order")."'",
						"transaction_scheme" => "'".$this->post("transaction_scheme")."'",
						"date_time" => "'".time()."'"

					);

				foreach($field as $key => $value){

					$data_query[] = $key."=".$value;

				}

				$command = "UPDATE db_product SET ".implode(",",$data_query)." WHERE sorting_id='".$this->get("id")."' ";

				if($this->db()->query($command)){
					$this->set_diskon();
					save_activity("Melakukan perubahan data produk bernama <b>".$show['title']."</b> dengan produk id <b>".$show['product_id']."</b>");
					return true;

				}else{

					return false;
				}
				

			}else return false;

		}

	}