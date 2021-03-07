<?php

if(!empty(trim($_COOKIE['user']))) {

	$_SESSION['user'] = decrypt($_COOKIE['user']);

}else{

	if(isset($_SESSION['user'])){

		setcookie("user", encrypt($_SESSION['user']), time() + 31000000,"/");

	}
}

if(isset($_SESSION['user']) and !empty($_SESSION['user'])){

	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 9999999999999999)) {

	    session_unset();
	    session_destroy();

	}

	$_SESSION['LAST_ACTIVITY'] = time();

}


function device_checker(){

	if(is_mobile()) return "mobile";
	return "desktop";

}