<?php
	
	class delete_cart extends load{

		function __construct(){


			if($this->db()->query("DELETE FROM db_cart WHERE id='".$this->get("id")."'  and user_id='".userinfo()->user_id."'  ")){

				echo "<script>window.location='".HomeUrl()."/clientarea/keranjang_belanja';</script>";

			}else{

				echo "<script>window.location='".HomeUrl()."/clientarea/keranjang_belanja';</script>";

			}

		}

	}