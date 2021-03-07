<?php
	
	class delete_users extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("user", "3");
			}

			$query = $this->db()->query("SELECT level,username FROM db_users WHERE id='".$this->get("id")."'");
			$show = $query->fetch();

			if($show['level'] >= userinfo()->level){

				save_activity("berusaha menghapus username <b>".$show['username']."</b> namun gagal");
				echo "<script>alert('Anda tidak bisa menghaspus user ".$show['username']."');window.location='".HomeUrl()."/adminpanel/users';</script>";

			}elseif($this->db()->query("DELETE FROM db_users WHERE id='".$this->get("id")."' ")){

				save_activity("Mengahapus username <b>".$show['username']."</b>");

				echo "<script>alert('Berhasil di hapus');window.location='".HomeUrl()."/adminpanel/users';</script>";

			}else{
				
				echo "<script>alert('Gagal di hapus');window.location='".HomeUrl()."/adminpanel/users';</script>";

			}

		}

	}