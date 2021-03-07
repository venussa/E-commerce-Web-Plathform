<?php
	
	class send_code extends load{

		function __construct(){

			$code = rand(11111,55555);

			$_SESSION['verification_code'] = $code;
			$_SESSION['time_limit'] = time();

			PHPmailer($this->post("email"),"Verification Code","Okoifish verification Code. Kode verifikasi kamu adalah <b>".$code."</b>.<br><br><span style='font-size:12px;color:#666'>Expired in 5 Minutes</span>");

		}

	}