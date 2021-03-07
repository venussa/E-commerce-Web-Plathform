<?php

	class index extends load{

		function home(){

			if((setting()->status == 1) and (userinfo() == false)) {

				$this->view(device_checker()."/maintenance");
				exit;

			}else if((setting()->status == 1) and (userinfo()->level < 2)){
				
				$this->view(device_checker()."/maintenance");
				exit;
			}


			$this->view(device_checker()."/meta-data");
			$this->view(device_checker()."/header");
			$this->view(device_checker()."/home");
			$this->view(device_checker()."/footer");

		}

		function total_cart(){

			$query = $this->db()->query("SELECT * FROM db_cart WHERE user_id='".userinfo()->user_id."' ");
			return $query->rowCount();

		}

		function get_product(){

			return false;

		}

		function get_title(){


			$title = setting()->title." - ".setting()->tagline;
			

			return $title;

		}

		function get_description(){

			return setting()->description;

		}

		function get_thumbnail(){

			return setting()->thumbnail;

		}

	}

?>
