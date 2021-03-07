<?php
	
	class delete_address extends load{

		function __construct(){


			if($this->db()->query("DELETE FROM db_destination_address WHERE user_id='".userinfo()->user_id."' and id='".$this->get("id")."' ")){

				echo "<script>window.location='".HomeUrl()."/clientarea/alamat_pengiriman';</script>";

			}else{

				echo "<script>alert('Gagal di hapus');window.location='".HomeUrl()."/clientarea/alamat_pengiriman';</script>";

			}

		}

	}