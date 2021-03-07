<?php

class verif_mail_code extends load{

	function __construct(){

		if((string) $_SESSION['verification_code'] == $this->post("verifikasi")) echo "<true/>";

		else echo "<false/>";

	}

}