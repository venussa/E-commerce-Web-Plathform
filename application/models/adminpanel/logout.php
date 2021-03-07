<?php
	
	class logout extends load{

		function __construct(){

			if(userinfo()->level >= 2)
			save_activity("Telah logout");
		
			session_destroy();
			setcookie("user", null, time() - 3600,"/");
			echo "<script>window.location='".HomeUrl()."/login';</script>";

		}

	}
