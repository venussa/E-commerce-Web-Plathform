<?php
	
	class delete_page extends load{

		function __construct(){

			$query = $this->db()->query("SELECT * FROM db_custom_page WHERE id='".$this->get("id")."' ");
			$show = $query->fetch();

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				if($show['level'] >= 2) role_access("blog", "3");
				if($show['level'] < 2) role_access("custom", "3");
			}


			if($this->db()->query("DELETE FROM db_custom_page WHERE id='".$this->get("id")."' ")){

				if(!empty($this->get("page"))){
				save_activity("Menghapus konten  blog yang berjudul <b>".$show['title']."</b>");
				echo "<script>alert('Berhasil di hapus');window.location='".HomeUrl()."/adminpanel/blogs';</script>";
				}else{
				save_activity("Menghapus custom page yang berujudul <b>".$show['title']."</b>");
				echo "<script>alert('Berhasil di hapus');window.location='".HomeUrl()."/adminpanel/page_content';</script>";
				}

			}else{

				echo "<script>alert('Gagal di hapus');window.location='".HomeUrl()."/adminpanel/page_content';</script>";

			}

		}

	}