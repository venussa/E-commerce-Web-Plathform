<?php

	class blog extends load{

		function home(){

			// mode maintenance
			if((setting()->status == 1) and (userinfo() == false)) {

				$this->view(device_checker()."/maintenance");
				exit;

			}else if((setting()->status == 1) and (userinfo()->level < 2)){
				
				$this->view(device_checker()."/maintenance");
				exit;
			}


			// 404 result
			if(!empty(splice(2)) and is_numeric(splice(3))){

				if($this->check_content() == 0) header("HTTP/1.0 404 Not Found"); 
			
			}elseif(!empty(splice(2)) and empty(splice(3))) header("HTTP/1.0 404 Not Found"); 



			// load meta element
			$this->view(device_checker()."/meta-data");

			// load header
			$this->view(device_checker()."/header");

			// load manm page
			if(!empty(splice(2)) and is_numeric(splice(3))){

				if($this->check_content() > 0) $this->view(device_checker()."/blog-view");
				else $this->view(device_checker()."/404");
			
			}elseif(!empty(splice(2)) and empty(splice(3))) $this->view(device_checker()."/404");
			else $this->view(device_checker()."/blog");

			// load footer
			$this->view(device_checker()."/footer");

		}

		// check keberadaan kontent blog
		function check_content($response = false){

			$query = $this->db()->query("SELECT * FROM db_custom_page WHERE id='".splice(3)."' and level='2' and status='1' ");

			if($response == true) return $query->fetch();

			return $query->rowCount();

		}

		// mendapatkan judul blog
		function get_title(){

			if($this->check_content() > 0){

				$title = $this->check_content(true)['title']." | Blog ".setting()->title;

			}else{

				if(!empty(splice(2)) and empty(splice(3))) $title = "Oop's , Halaman Tidak Ditemukan";
				elseif(empty(splice(3))) $title = "Blog ".setting()->title . " | Info Terkini di ".setting()->title;
				else $title = "Oop's , Halaman Tidak Ditemukan";
				

			}

			return $title;

		}


		// mendapatkan deskripsi dari blog
		function get_description(){

			if($this->check_content() > 0){

				$desc = $this->check_content(true)['description'];

			}else $desc = setting()->description;

			return $desc;

		}

		// mendapatkan gambar thumbnail dari blog
		function get_thumbnail(){

			if($this->check_content() > 0){

				$img = sourceUrl()."/website/".$this->check_content(true)['img'];

			}else  $img = setting()->thumbnail;

			return $img;

		}

		// menghitung total belanja dalam keranjang
		function total_cart(){

			$query = $this->db()->query("SELECT * FROM db_cart WHERE user_id='".userinfo()->user_id."' ");
			return $query->rowCount();

		}

		// memunculkan pagination
		function pagination($return = true,$table,$slug){

			if(!empty($this->get('page'))) $data['page'] = $this->get('page');
			else $data['page'] = 1;

			$condition = "WHERE status=1 and level=2";
			
			$q = urldecode($this->get("q"));
				
			$search = null;

			if(!empty($this->get("q"))){

				$condition = $condition." and (title like '%".$q."%' or content like '%".$q."%')";
				$search = "?q=".$this->get("q");

			}
		


			$data['dataperpage'] = 24;

			$query = $this->db()->query("SELECT * FROM $table ".$condition);
			$count_data = $query->rowCount();

			$data['totaldata'] = $count_data;

			$data['url'] = HomeUrl()."/".$slug.$search;

			$data['container_class'] = "pagination";

			$data['li_class'] = null;

			$data['a_class'] = null;

			$data['pjax_class'] = "web-content";

			$data['active_class'] = "active";

			$data['add_attribute'] = "data-title=''";

			$data['condition'] = $condition;

			if($return == false) return json_decode(json_encode($data));

			return pagination(
				$data['page'],
				$data['dataperpage'],
				$data['totaldata'],
				$data['url'],
				$data['container_class'],
				$data['li_class'],
				$data['a_class'],
				$data['pjax_class'],
				$data['active_class'],
				$data['add_attribute']
			);

		}

	}

?>
