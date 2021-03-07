<?php
	
	class add_to_cart extends load{

		function __construct(){

			if(userinfo() == false){

				header("location:".HomeUrl()."/login");
				exit;

			}

			if($this->check_product() == true){

				if($this->check_cart() == false){

					$this->add_cart();

					$response = "Produk ditambahkan ke keranjang";

				}else $response = "Produk ditambahkan ke keranjang";

			}else $response = "Produk tidak ditemukan";
			
			echo "<script>alert('$response'); window.history.back();</script>";

		}

		function check_cart(){

			$query = $this->db()->query("SELECT * FROM db_cart WHERE product_id='".$this->get("id")."' and user_id='".userinfo()->user_id."'");

			if($query->rowCount() == 0)
			return false;
			return true;


		}

		function check_product(){

			$query = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->get("id")."' ");

			if($query->rowCount() == 0)
			return false;
			return true;

		}

		function add_cart(){

			if($this->post("total") < 1) $total = 1;
			else $total = $this->post("total");

			$this->db()->query("INSERT into db_cart (user_id,product_id,total) VALUES ('".userinfo()->user_id."','".$this->get("id")."','".$total."')");

		}

	}