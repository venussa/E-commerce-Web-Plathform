<?php
	
	class delete_product extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("product", "3");
			}

			$query = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->get("id")."' ");

			$show = $query->fetch();

			if($this->db()->query("DELETE FROM db_product WHERE sorting_id='".$this->get("id")."' ")){

				save_activity("Menghapus data produk yang bernama <b>".$show['title']."</b> dengan produk id <b>".$show['product_id']."</b>");

				foreach(json_decode($show['picture']) as $key => $value){

					$path = SERVER."/sources/content/".$value;
					unlink($path);

				}

				echo "<script>alert('Berhasil di hapus');window.location='".HomeUrl()."/adminpanel/product';</script>";

			}else{

				echo "<script>alert('Gagal di hapus');window.location='".HomeUrl()."/adminpanel/product';</script>";

			}

		}

	}