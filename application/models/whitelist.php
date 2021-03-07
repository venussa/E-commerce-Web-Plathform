<?php
	
	class whitelist extends load{

		function __construct(){

			if(userinfo() == false) return false;

			if($this->check_product() == true) $this->is_active();

		}

		function check_product(){

			$query = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->post("id",["'"])."' ");

			if($query->rowCount() == 0) return false;

			return true;

		}

		function is_active(){

			$query = $this->db()->query("SELECT * FROM db_white_list WHERE user_id='".userinfo()->user_id."' and product_id='".$this->post("id",["'"])."' ");

			if($query->rowCount() == 0){

				$this->db()->query("insert into db_white_list (user_id, product_id) values ('".userinfo()->user_id."','".$this->post("id",["'"])."')");

				echo "<add/>";

			}else{

				$this->db()->query("DELETE FROM db_white_list WHERE product_id='".$this->post("id",["'"])."' and user_id='".userinfo()->user_id."'");

				echo "<remove/>";

			}


		}


	}