<?php

	class login extends load{

		function home(){

			if(userinfo() !== false) {

				if(userinfo()->level < 2){

					header("location:".HomeUrl()."/clientarea");
					exit;				

				}else{

					header("location:".HomeUrl()."/adminpanel");
					exit;				

				}

			}

			if(file_exists(SERVER."/application/views/".device_checker()."/login/".splice(2).".php") == true)

				$this->view(device_checker()."/login/".splice(2));

			else if(empty(trim(splice(2))))

				$this->view(device_checker()."/login/login");

			else 

				$this->view(device_checker()."/404");


		}

		function auth(){

			$this->model("login/auth");

		}

		function auth_register(){
			
			$this->model("login/auth_register");

		}

		function auth_reset(){

			$this->model("login/auth_reset");

		}

		function auth_forgot_password(){

			$this->model("login/auth_forgot_password");

		}

		function send_code(){

			$this->model("login/send_code");

		}



	}

?>
