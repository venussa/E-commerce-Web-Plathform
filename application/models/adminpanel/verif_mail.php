<?php

class verif_mail extends load{

	function __construct(){

		$code = rand(11111,55555);

		$_SESSION['verification_code'] = $code;

		if(empty($this->post("email"))) $mail = userinfo()->email;
		else $mail = $this->post("email");

		PHPmailer(str_replace("'","",strip_tags($mail)),"Verification Code","Okoifish verification Code. Kode verifikasi kamu adalah <b>".$code."</b>.<br><br><span style='font-size:12px;color:#666'>Expired in 5 Minutes</span>");

	}

}