<?php
	
	class read extends load{

		function __construct(){
			if(userinfo() == false) return false;
			$id = (int) strip_tags(splice(3));
			$url = urldecode(base64_decode(splice(4)));
			$this->db()->query("UPDATE db_alert SET status='1' WHERE id='".$id."' ");
			header("location:".$url);

		}
	}