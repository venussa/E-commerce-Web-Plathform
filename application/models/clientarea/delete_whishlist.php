<?php
	
	class delete_whishlist extends load{

		function __construct(){


			if($this->db()->query("DELETE FROM db_white_list WHERE id='".$this->get("id")."' and user_id='".userinfo()->user_id."' ")){

				echo "<script>window.location='".HomeUrl()."/clientarea/whishlist';</script>";

			}else{

				echo "<script>window.location='".HomeUrl()."/clientarea/whishlist';</script>";

			}

		}

	}