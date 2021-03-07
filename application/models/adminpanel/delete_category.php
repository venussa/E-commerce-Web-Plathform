<?php
	
	class delete_category extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("category", "3");
			}

			$query = $this->db()->query("SELECT * FROM db_category WHERE id='".$this->get("id")."' ");
			$show = $query->fetch();

			if($this->db()->query("DELETE FROM db_category WHERE id='".$this->get("id")."' ")){

				$this->db()->query("DELETE FROM db_category WHERE sublevel='".$this->get("id")."' ");

				save_activity("Menghapus data category yang benama <b>".$show['title']."</b>");

				echo "<script>alert('Berhasil di hapus');window.location='".HomeUrl()."/adminpanel/category';</script>";

			}else{

				echo "<script>alert('Gagal di hapus');window.location='".HomeUrl()."/adminpanel/category';</script>";

			}

		}

	}