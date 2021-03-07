<?php

	class clientarea extends load{

		function home(){

			if(userinfo() == false) {

				header("location:".HomeUrl()."/adminpanel/logout");
				exit;

			}

			if(userinfo()->level > 1){
				header("location:".HomeUrl()."/adminpanel/dashboard");
				exit;
			}

			if(empty(splice(2))){
				header("location:".HomeUrl()."/clientarea/dashboard");
				exit;
			}

			$data['navbar-menu']	= $this->view(device_checker()."/clientarea/component/navbar-menu",null,false);
			$data['sidebar-menu']	= $this->view(device_checker()."/clientarea/component/sidebar-menu",null,false);
			$data['navurl-menu']	= $this->view(device_checker()."/clientarea/component/navurl-menu",null,false);

			if(file_exists(SERVER."/application/views/".device_checker()."/clientarea/".splice(2).".php") == true)

				$data['home-content'] = $this->view(device_checker()."/clientarea/".splice(2),null,false);

			else if(empty(trim(splice(2))))

				$data['home-content'] = $this->view(device_checker()."/clientarea/dashboard",null,false);

			else 

				$data['home-content'] = $this->view(device_checker()."/404",null,false);


			$this->view(device_checker()."/clientarea/component/home-content",$data);


		}

		function total_cart(){

			$query = $this->db()->query("SELECT * FROM db_cart WHERE user_id='".userinfo()->user_id."' ");
			return $query->rowCount();

		}

		function pagination($return = true,$table,$slug){

			if(!empty($this->get('page')) and is_numeric($this->get("page"))) $data['page'] = $this->get('page');
			else $data['page'] = 1;

			$search = null;

			if(!empty($this->get("q"))){

				$condition = "WHERE user_id='".userinfo()->user_id."' and (title like '%".$this->get("q")."%' or product_id like '%".$this->get("q")."%')";

				$search = "?q=".$this->get("q");

			}elseif($table == "db_product"){
				

				$condition = "WHERE user_id='".userinfo()->user_id."'";


			}else{

				$search = null;

				$condition = null;

			}

			if($table == "db_cart"){

				$condition = "WHERE user_id='".userinfo()->user_id."' ";

			}

			if($table == "db_wallet"){

				$condition = "WHERE user_id='".userinfo()->user_id."' and (tf_id like '%".urldecode($this->get("q"))."%' or invoice_id like '%".urldecode($this->get("q"))."%')";

			}

			if($table == "db_white_list"){

				$condition = "WHERE user_id='".userinfo()->user_id."' ";
			}

			if($table == "db_alert"){

				$condition = "WHERE user_id='".userinfo()->user_id."' ";

			}
			

			if($table == "db_destination_address"){

				if(empty($this->get("q")))
				$condition = "WHERE user_id='".userinfo()->user_id."'";
				else{

					$keyword = strip_tags(str_replace("'",null, $this->get("q")));

					$condition = "WHERE (

						address like '%".$keyword."%' or
						state like '%".$keyword."%' or 
						district like '%".$keyword."%' or 
						province like '%".$keyword."%' or 
						zip_code like '%".$keyword."%' or 
						phone_number like '%".$keyword."%' or 
						nama_penerima like '%".$keyword."%'

					) and user_id='".userinfo()->user_id."'";
				}

			}

			if($table == "db_orders"){

				if(!empty($this->get("m")) and !empty($this->get("y")) and is_numeric($this->get("y"))) {

					$start_time = strtotime("01 ".$this->get("m")." ".$this->get("y"));
					$filter = "and start_time >= ".$start_time;
					$filter = $filter." and start_time <= ".strtotime(date("t M Y", $start_time));
					$filter = $filter." and (product_id like '%".urldecode($this->get("q"))."%' or invoice_id like '%".urldecode($this->get("q"))."%')";
					$time = "&m=".$this->get("m")."&y=".$this->get("y");

				}else{

					$filter = "and (product_id like '%".urldecode($this->get("q"))."%' or invoice_id like '%".urldecode($this->get("q"))."%') ";
					$time = null;
				}

				if(!empty($this->get("filter"))){

					$condition = "WHERE status='".$this->get("filter")."' $filter and user_id='".userinfo()->user_id."'";

				}else{

					$condition = "WHERE user_id='".userinfo()->user_id."' $filter";


				}

				$search = "?filter=".$this->get("filter")."".$time;

				if($slug == "pembayaran_tertunda"){

					$condition = "WHERE user_id='".userinfo()->user_id."' and status >= 0 and status < 9";
					$search = null;

				}

				if($slug == "komplain_pembelian"){

					$condition = "WHERE user_id='".userinfo()->user_id."' and status >= 5 and note_complain != ''";
					$search = null;

				}
				

			}

			$data['dataperpage'] = 10;

			$query = $this->db()->query("SELECT * FROM $table ".$condition);
			$count_data = $query->rowCount();

			$data['totaldata'] = $count_data;

			$data['url'] = HomeUrl()."/clientarea/".$slug.$search;

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

		function change_profile(){

			$this->model("clientarea/change_profile");

		}

		function delete_cart(){

			$this->model("clientarea/delete_cart");

		}

		function delete_whishlist(){

			$this->model("clientarea/delete_whishlist");

		}

		function delete_address(){

			$this->model("clientarea/delete_address");

		}

		function tambahalamat(){

			$this->model("clientarea/tambahalamat");

		}

		function rubahalamat(){

			$this->model("clientarea/rubahalamat");

		}

		function finish_order(){

			$this->model("clientarea/finish_order");

		}

		function add_to_cart(){

			$this->model("clientarea/add_to_cart");

		}

		function upload_pembayaran(){

			$this->model("clientarea/upload_pembayaran");

		}

		function complete_order(){

			$this->model("clientarea/complete_order");

		}

		function submit_complain(){

			$this->model("clientarea/submit_complain");

		}

		function submit_cancel(){

			$this->model("clientarea/submit_cancel");

		}

		function cancel_order(){

			$this->model("clientarea/cancel_order");

		}

		function get_region(){

			$this->model("clientarea/get_region");

		}


		function add_product(){

			$this->model("clientarea/add_product");

		}

		function edit_product(){

			$this->model("clientarea/edit_product");

		}

		function refund(){

			$this->model("clientarea/refund");

		}

		function deposit_saldo(){

			$this->model("clientarea/deposit_saldo");

		}

		function verif_refund(){

			$this->model("clientarea/verif_refund");

		}

	}

?>
