<?php 

class cancel_order extends load{

	function __construct(){

		if($this->check_status() == true){

			if($this->update_data() == true){
				echo "<script>window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";

			}else echo "<script>alert('Gagal membatalkan');window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";

		}else echo "<script>alert('Gagal membatalkan');window.location='".HomeUrl()."/clientarea/detail_pesanan?id=".$this->get("id")."';</script>";

	}

	function check_status(){

		$query = $this->db()->query("SELECT * FROM db_orders WHERE user_id='".userinfo()->user_id."' and sorting_id='".$this->get("id")."' and status < 3 ");

		if($query->rowCount() == 0) return false;
		return true;

	}

	function update_data(){

		$this->db()->query("UPDATE db_orders SET status='9' WHERE user_id='".userinfo()->user_id."' and sorting_id='".$this->get("id")."'");
		$this->db()->query("INSERT INTO db_log_order (order_id, type, time) VALUES ('".$this->get("id")."','9','".time()."')");

		return true;

	}

}