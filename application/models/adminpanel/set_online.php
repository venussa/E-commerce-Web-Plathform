<?php
	
	class set_online extends load{

		function __construct(){

			if(userinfo() == false) {

				echo "<script>window.location='".HomeUrl()."/login';</script>";
				exit;

			}

			$query = $this->db()->query("UPDATE db_users SET online='".time()."' WHERE id='".userinfo()->user_id."' ");

			if(!empty($this->get("id"))){
				
				$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."' and status > 5");
				if(($query->rowCount() > 0) and ($this->get("splice") == "detail_komplein")) {

					echo "<script>window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";

				}

			}

		}

	}

?>