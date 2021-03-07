<?php

	class defaults extends load{

		function home(){

			if((setting()->status == 1) and (userinfo() == false)) {

				$this->view(device_checker()."/maintenance");
				exit;

			}else if((setting()->status == 1) and (userinfo()->level < 2)){

				$this->view(device_checker()."/maintenance");
				exit;
			}

			if(!in_array(splice(1),$this->allow_page()))

			if(
				!in_array(splice(1),$this->get_category_list()['url']) or 
				( (!empty(splice(2))) and ($this->get_product(true) == false))
			){

				$response = "404";
				header("HTTP/1.0 404 Not Found");

			}

			if((splice(1) == "search") and (empty($this->get("q")))){
			
				header("location:".HomeUrl()."/");
				exit;

			}

			if(in_array(splice(1),$this->get_category_list()['url']) and (!empty(splice(2))))
			$this->page_view();

			$this->view(device_checker()."/meta-data");
			$this->view(device_checker()."/header");

			if(in_array(splice(1),$this->get_category_list()['url']) and (!empty(splice(2)))) $data = "product";
			if(in_array(splice(1),$this->get_category_list()['url']) and (empty(splice(2)))) $data = "category";
			if(splice(1) == "search") $data = "category";
			if((splice(1) !== "search") and (in_array(splice(1), $this->allow_page()))) $data="custom-page";

			if(isset($response)) $data = $response;

			$this->view(device_checker()."/".$data);
			$this->view(device_checker()."/footer");

		}

		function allow_page(){

			$data[] = "search";

			$query = $this->db()->query("SELECT * FROM db_custom_page WHERE status='1' ");

			if($query->rowCount() > 0){

				while($show = $query->fetch()){

					$data[] = $show["slug"];

				}

			}

			return $data;

		}

		function get_category_list($where = null){

			$query = $this->db()->query("SELECT * FROM db_category WHERE level >= 0 $where ");
			
			$sum = 0;

			while($show = $query->fetch()){

				$data['url'][$sum] = url_title($show['title'],"-",true);
				$data['title'][url_title($show['title'],"-",true)] = $show['title'];
				$data['doc_uri'][url_title($show['title'],"-",true)] = url_title($show['title'],"-",true);
				$data['id'][url_title($show['title'],"-",true)] = $show['id'];
				$sum++;
			}

			return $data;

		}

		function get_title(){

			if(splice(1) == "search") $title = "Mencari Produk ".ucwords(strip_tags(urldecode($this->get("q"))))." | ".setting()->title;

			if(in_array(splice(1),$this->get_category_list()['url']) and (!empty(splice(2))))

				$title = $this->get_product()->title." | ".setting()->title;

			if(in_array(splice(1),$this->get_category_list()['url']) and (empty(splice(2))))

				$title = "Jual Berbagai Jenis ".$this->get_category_list()['title'][splice(1)]." | ".setting()->title;

			if(!in_array(splice(1),$this->allow_page()))

			if(
				!in_array(splice(1),$this->get_category_list()['url']) or 
				( (!empty(splice(2))) and ($this->get_product(true) == false))
			){

				$title = "Oop's , Halaman Tidak Ditemukan";

			}

			if((splice(1) !== "search") and (in_array(splice(1), $this->allow_page()))){

				$query = $this->db()->query("SELECT * FROM db_custom_page WHERE slug='".splice(1)."'");
				$show = $query->fetch();

				$title = $show['title']." | ". setting()->title;

			}

			

			return $title;

		}

		function get_description(){

			if(in_array(splice(1),$this->get_category_list()['url']) and (!empty(splice(2))))
				$desc = "Beli Produk ".$this->get_product()->title." Dengan Kualitas Terjamin di ".setting()->title;
			else $desc = setting()->description;

			return $desc;

		}

		function get_thumbnail(){

			if(in_array(splice(1),$this->get_category_list()['url']) and (!empty(splice(2))))
			$img = sourceUrl()."/content/".json_decode($this->get_product()->picture)[0];
			else $img = setting()->thumbnail;

			return $img;

		}

		function get_product($check = false){

			$query = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->get("id",["'"])."' and status='1'");
			$show = $query->fetch();
			$json = json_encode($show);
			$json = json_decode($json);

			if($check == true)
				if($query->rowCount() == 0)
					return false;

			return $json;


		}

		function get_category_data($id = 0){

			$query = $this->db()->query("SELECT * FROM db_category WHERE id='".$id."' ");

			if($query->rowCount() == 0) return false;

			$show = $query->fetch();
			$json = json_encode($show);
			$json = json_decode($json);
			return $json;

		}

		function get_category(){

			if($this->get_product(true) == false) return false;

			$query = $this->db()->query("SELECT * FROM db_category WHERE id='".$this->get_product()->category."' ");
			$show = $query->fetch();
			$json = json_encode($show);
			$json = json_decode($json);
			return $json;

		}

		function get_sub_category(){

			if($this->get_product(true) == false) return false;

			$query = $this->db()->query("SELECT * FROM db_category WHERE id='".$this->get_product()->sub_category."' ");
			$show = $query->fetch();
			$json = json_encode($show);
			$json = json_decode($json);
			return $json;

		}

		function show_product_picture(){
			
			$pict = json_decode($this->get_product()->picture);

			return $pict;

		}

		function show_location($search = null){

			if(!empty($search)) $q = " and (name like '%".$search."%')";
			else $q = null;

			$query = $this->db()->query("SELECT * FROM db_location WHERE type='kabupaten' $q");

			while ($show = $query->fetch()) {

				$parent = $this->db()->query("SELECT * FROM db_location WHERE loc_id='".$show['parrent']."' ");
				$parent = $parent->fetch();

				$data[] = '<li class="type_sorting_btn" onClick="return get_price(this)" style="text-align:left;font-size:12px;height:30px;" name="'.$show['name'].'" loc_id="'.$show['loc_id'].'">
				<span>'.$show['name'].'<p style="font-size:8px;color:#fe4c50;margin-top:-13px">'.$parent['name'].'</p></span>
				
				</li>';
			}

			return implode(null,$data);

		}

		function get_client_ip() {

		    $ipaddress = '';
		    if (getenv('HTTP_CLIENT_IP'))
		        $ipaddress = getenv('HTTP_CLIENT_IP');
		    else if(getenv('HTTP_X_FORWARDED_FOR'))
		        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		    else if(getenv('HTTP_X_FORWARDED'))
		        $ipaddress = getenv('HTTP_X_FORWARDED');
		    else if(getenv('HTTP_FORWARDED_FOR'))
		        $ipaddress = getenv('HTTP_FORWARDED_FOR');
		    else if(getenv('HTTP_FORWARDED'))
		       $ipaddress = getenv('HTTP_FORWARDED');
		    else if(getenv('REMOTE_ADDR'))
		        $ipaddress = getenv('REMOTE_ADDR');
		    else
		        $ipaddress = 'UNKNOWN';
		    return $ipaddress;

		}

		function page_view($result = true){

			$query = $this->db()->query("SELECT * FROM db_page_view WHERE product_id='".$this->get_product()->sorting_id."' and ip='".$this->get_client_ip()."' and date_time='".date("dmY")."' ");

			$query1 = $this->db()->query("SELECT * FROM db_page_view WHERE product_id='".$this->get_product()->sorting_id."' ");

			if($result == false)
			return $query1->rowCount();

			if($query->rowCount() == 0){

				$this->db()->query("INSERT INTO db_page_view (product_id, ip ,date_time) VALUES ('".$this->get_product()->sorting_id."','".$this->get_client_ip()."','".date("dmY")."')");

			}

		}

		function total_cart(){

			$query = $this->db()->query("SELECT * FROM db_cart WHERE user_id='".userinfo()->user_id."' ");
			return $query->rowCount();

		}



		function pagination($return = true,$table,$slug){

			if(!empty($this->get('page'))) $data['page'] = $this->get('page');
			else $data['page'] = 1;

			if(!empty($this->get("q"))){

				$condition = "WHERE title like '%".$this->get("q")."%' or description like '%".$this->get("q")."%'";

				$search = "?q=".$this->get("q");

			}else{

				$search = null;

				$condition = null;

			}

			if(is_array($this->get())){

				foreach ($this->get() as $key => $value) {
					
					if($key !== "page")
					$search_q[] = $key."=".$value;

				}

				$search = "?".implode("&",$search_q);

			}


			if(!empty($this->get("sub_category"))){

				$q[] = "sub_category='".$this->get_category_list()['id'][$this->get("sub_category")]."' ";

			}elseif(!in_array(splice(1),$this->allow_page())) {

				$q[] = "category='".$this->get_category_list()['id'][splice(1)]."' ";

			}

			if(!empty($this->get("size")) and (urldecode($this->get("size")) !== "Semua Ukuran")) $q[] = "size='".$this->get("size")."'";
			if(!empty($this->get("start_price"))) $q[] = "price >= '".$this->get("start_price")."'";
			if(!empty($this->get("end_price"))) $q[] = "price <= '".$this->get("end_price")."'";

			if(!empty($this->get("list"))){

				switch(str_replace("_"," ",$this->get("list"))){

					case "Terbaru": $conds = " ORDER BY sorting_id DESC"; break;
					case "Harga Tertinggi": $conds = " ORDER BY price DESC"; break;
					case "Harga Terendah": $conds = " ORDER BY price ASC"; break;
					default: $conds = " ORDER BY sorting_id DESC"; break;

				}

			}else $conds = " ORDER BY sorting_id DESC";

			$sq = strip_tags(urldecode($this->get("q")));
			if(!empty($this->get("q"))) $q[] = "( title like '%".$sq."%' or description like '%".$sq."%' )";
			$q[] = "status=1";
			$q = implode(" and ", $q);

			$condition = "WHERE $q $conds ";
			


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
