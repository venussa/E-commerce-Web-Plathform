<?php

	class handler extends load{

		function home(){

			echo "Forbidden Access";

		}	

		// menampilkan data lokasi
		function location(){

			$this->model("location");

		}

		// menambahkan produk ke whishlist
		function whitelist(){

			$this->model("whitelist");

		}

		// merubah status pemberitahuan
		function read(){

			$this->model("read");

		}
		
		// program cron job
		function cron_job(){

			$this->model("cron_job");

		}

		// submit mail dari user pada halaman contact us
		function mail_submit(){

			$this->model("mail_submit");

		}

	}