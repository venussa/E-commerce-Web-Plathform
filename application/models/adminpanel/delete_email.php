<?php
	
	class delete_email extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("opinion", "6");
			}

			$query = $this->db()->query("SELECT * FROM db_email WHERE id='".$this->get("id")."' ");
			$show = $query->fetch();

			if($this->db()->query("DELETE FROM db_email WHERE id='".$this->get("id")."' ")){

				save_activity("Menghapus data email yang dikirim oleh <b>".$show['email']."</b>");

				echo "<script>alert('Berhasil di hapus');window.location='".HomeUrl()."/adminpanel/users_opinion';</script>";

			}else{

				echo "<script>alert('Gagal di hapus');window.location='".HomeUrl()."/adminpanel/users_opinion';</script>";

			}

		}

	}