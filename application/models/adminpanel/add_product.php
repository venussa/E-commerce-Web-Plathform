<?php
	
	class add_product extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("product", "1");
			}
			
			if($this->insert_data() == true){

				echo "<script>alert('Berhasil di tambah');window.location='".HomeUrl()."/adminpanel/product';</script>";

			}else{

				echo "<script>alert('Gagal di Tambahkan');window.history.back();</script>";

			}

		}

		function is_data_exists(){

			$command = "SELECT * FROM db_product WHERE product_id='".$this->post("product_id")."'";
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

		function set_diskon($product_id){

			if(empty($this->post("discount"))) return false;

			$product = $this->db()->query("SELECT sorting_id FROM db_product WHERE product_id='".$product_id."' ");
			$product = $product->fetch();

			$start_time = strtotime($this->post("start_time"));
			$end_time = strtotime($this->post("end_time"));

			$this->db()->query("INSERT INTO db_product_discount (product_id, price, start_time, end_time) 
				VALUES ('".$product['sorting_id']."','".$this->post("discount")."','".$start_time."','".$end_time."')");

		}

		function insert_data(){

			$allowed = array("jpg","png","gif","jpeg");

			if($this->is_data_exists() == false){

				for($i = 1; $i <= 5; $i++){

					if(isset($_FILES['img'.$i]) and !empty($_FILES['img'.$i]['name'])){

						$old_name = $_FILES['img'.$i]['name'];

						$tmp_file = $_FILES['img'.$i]['tmp_name'];

						$extention = get_extention($old_name);

						if(in_array($extention,$allowed)){

							$newname = time()."-".$i.".".$extention;

							$path = SERVER."/sources/content/".$newname;

							if(move_uploaded_file($tmp_file, $path)){

								$data[] = $newname;

							}

						}else return false;

					}

				}


				$product_id = $this->get_category()['uniq_id']."/".$this->get_sub_category()['uniq_id']."/".date("dmYHis");

				$field = array(

						"product_id" => "'".$product_id."'",
						"user_id" => "'".userinfo()->user_id."'",
						"title" => "'".$this->post("title")."'",
						"description" => "'".$this->post("description")."'",
						"category" => "'".$this->get_category()['id']."'",
						"sub_category" => "'".$this->get_sub_category()['id']."'",
						"size" => "'".$this->post("size")."'",
						"weight" => "'".$this->post("weight")."'",
						"stock" => "'".$this->post("stock")."'",
						"price" => "'".$this->post("price")."'",
						"picture" => "'".json_encode($data)."'",
						"date_time" => "'".time()."'",
						"min_order" => "'".$this->post("min_order")."'",
						"transaction_scheme" => "'".$this->post("transaction_scheme")."'",
						"status" => "'1'"

					);

				$column = implode(",",array_keys($field));

				$value = implode(",",$field);

				$command = "INSERT INTO db_product ($column) VALUES ($value)";

				if($this->db()->query($command)){

					$this->set_diskon($product_id);
					save_activity("Melakukan penambahan data produk bernama <b>".$this->post("title")."</b> dengan produk id <b>".$product_id."</b>");
					return true;

				}else{

					return false;
				}
				

			}else return false;

		}

	}