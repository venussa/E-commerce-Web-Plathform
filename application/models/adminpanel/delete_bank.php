<?php
	
	class delete_bank extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("bank", "3");
			}

			$query = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$this->get("id")."' ");
			$show = $query->fetch();

			if($this->db()->query("DELETE FROM db_pay_info WHERE id='".$this->get("id")."' ")){

				save_activity("Menghapus data bank yang bernama <b>".$show['bank_name']."</b>");
				echo "<script>alert('Berhasil di hapus');window.location='".HomeUrl()."/adminpanel/bank';</script>";

			}else{

				echo "<script>alert('Gagal di hapus');window.location='".HomeUrl()."/adminpanel/bank';</script>";

			}

		}

	}