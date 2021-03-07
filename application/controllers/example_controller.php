<?php

	class index extends load{

		function home(){

			$data['set_data'] = "value";

			$this->view("example_view",$data);

		}

		function call_model(){

			$this->model("example_model");

		}

	}

?>
