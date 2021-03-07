<?php

	class tambahalamat extends load{

		function __construct(){

			
			if($this->input_data() == true)

			echo "<script>window.location='".HomeUrl()."/clientarea/alamat_pengiriman';</script>";

		}

		function clean_data(){

			foreach($this->post() as $key => $value){

				$data[$key] = strip_tags(str_replace("'",null,$value));

			}

			return json_decode(json_encode($data));

		}

		function query($field, $value){

			return $this->db()->query("SELECT * FROM db_users WHERE ".$field."='".$value."' ");

		}

		function input_data(){

			foreach ($this->clean_data() as $key => $value) {
					
				$data[$key] = "'".$value."'";

			}

			$data["user_id"] = "'".userinfo()->user_id."'";

			$field = implode(",",array_keys($data));
			$value = implode(",",($data));

			if($this->db()->query("INSERT INTO db_destination_address ($field) VALUES ($value)")){

				return true;

			}

			return false;


		}

	}