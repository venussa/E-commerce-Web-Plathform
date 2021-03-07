<?php
	
	class edit_product extends load{

		function __construct(){

			if($this->insert_data() == true){

				echo "<script>window.location='".HomeUrl()."/clientarea/produk_saya';</script>";

			}else{

				echo "<script>alert('Gagal di edit');window.history.back();</script>";

			}

		}

		function is_data_exists(){

			$command = "SELECT * FROM db_product WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."'";
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

		function insert_data(){

			if(userinfo()->level < 1) return false;

			$command = "SELECT * FROM db_product WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."'";
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
						// "category" => "'".$this->get_category()["id"]."'",
						// "sub_category" => "'".$this->get_sub_category()["id"]."'",
						"size" => "'".$this->post("size")."'",
						"weight" => "'".$this->post("weight")."'",
						"stock" => "'".$this->post("stock")."'",
						"price" => "'".$this->post("price")."'",
						"picture" => "'".json_encode($img)."'",
						"min_order" => "'".$this->post("min_order")."'",
						// "transaction_scheme" => "'".$this->post("transaction_scheme")."'",
						"date_time" => "'".time()."'"

					);

				foreach($field as $key => $value){

					$data_query[] = $key."=".$value;

				}

				$command = "UPDATE db_product SET ".implode(",",$data_query)." WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."' ";

				if($this->db()->query($command)){

					save_activity("Melakukan perubahan data produk bernama <b>".$this->post("title")."</b> dengan produk id <b>".$product_id."</b>");

					return true;

				}else{

					return false;
				}
				

			}else return false;

		}

	}