<?php

	class adminpanel extends load{

		function home(){

			// cek login 
			if(userinfo() == false) {

				header("location:".HomeUrl()."/adminpanel/logout");
				exit;

			}

			// check level akses pengguna
			if(userinfo()->level < 2){

				header("location:".HomeUrl()."/clientarea");
				exit;				

			}
								
			// parse empty slug
			if(empty(splice(2))){

				header("location:".HomeUrl()."/adminpanel/dashboard");
				exit;

			}

			// load bagian-bagian bagian website


			// load navigation bar menu
			$data['navbar-menu']	= $this->view(device_checker()."/admin/component/navbar-menu",null,false);
			// load sidebar menu
			$data['sidebar-menu']	= $this->view(device_checker()."/admin/component/sidebar-menu",null,false);
			// load navigation bar
			$data['navurl-menu']	= $this->view(device_checker()."/admin/component/navurl-menu",null,false);

			// load default menu
			if(file_exists(SERVER."/application/views/".device_checker()."/admin/".splice(2).".php") == true)

				$data['home-content'] = $this->view(device_checker()."/admin/".splice(2),null,false);

			else if(empty(trim(splice(2))))

				$data['home-content'] = $this->view(device_checker()."/admin/dashboard",null,false);

			else 

				$data['home-content'] = $this->view(device_checker()."/404",null,false);


			// rebuild data content
			$this->view(device_checker()."/admin/component/home-content",$data);

		}


		// mengecek device yang digunakan user
		function device_checker(){

			if(is_mobile()) return "desktop";
			return "mobile";

		}

		// menghitung total produk dalam keranjang
		function total_cart(){

			$query = $this->db()->query("SELECT * FROM db_cart WHERE user_id='".userinfo()->user_id."' ");
			return $query->rowCount();

		}


		// memunculkan pagination
		function pagination($return = true,$table,$slug){

			// mengecek nomor halaman
			if(!empty($this->get('page')) and is_numeric($this->get("page"))) $data['page'] = $this->get('page');
			else $data['page'] = 1;

			// mengecek keberadaan paramater q sebagai paramater untuk melakukan pencarian
			// $condition adalah variabel decision
			// $search adalah variable paramater
			if(!empty($this->get("q"))){

				$condition = "WHERE title like '%".urldecode($this->get("q"))."%' or product_id like '%".urldecode($this->get("q"))."%'";

				$search = "?q=".$this->get("q");

			}else{

				$search = null;

				$condition = null;

			}

			// query untuk table db_product_discount
			// fungsi table : menyimpan data diskon produk
			if($table == "db_product_discount"){

				if(!empty($this->get("discount"))){

					$condition = "WHERE start_time < ".time()." and end_time > ".time();

					$search = "?discount=true";

				}

			}

			// query untuk table db_deposite_request
			// fungsi table : menyimpan data perintaan deposite saldo
			if($table == "db_deposit_request"){

				$condition = "WHERE type='3' and (tf_id like '%".urldecode($this->get("q"))."%' )";

			}

			// query untuk table db_wallet
			// fungsi table : menyimpan data saldo wallet pada user
			if($table == "db_wallet"){

				if($slug == "request_refund")
				$condition = "WHERE type='1' and (tf_id like '%".urldecode($this->get("q"))."%' )";

				if($slug == "view_funds"){
					
					$condition = "WHERE user_id='".$this->get("id",["'"])."' and (tf_id like '%".urldecode($this->get("q",["'"]))."%' or invoice_id like '%".urldecode($this->get("q",["'"]))."%') ";
					$search = "?id=".$this->get("id",["'"])."&q=".urldecode($this->get("q",["'"]));
				}

			}

			// query untuk table db_category
			// fungsi table : untuk menyimpan data category produk pada website
			if($table == "db_category") $condition = "WHERE level='0'";


			// query untuk table db_pay_info
			// fungsi table : untuk menyimpan data babnk yang digunakan perusaan
			if($table == "db_pay_info") $condition = "WHERE bank_name like '%".$this->get("q")."%'";

			// query untuk table db_alert
			// fungsi table : untuk menyimpan data pemberitahuan berbagai aktifitas
			if($table == "db_alert") $condition = "WHERE user_id='".userinfo()->user_id."' ";

			// query untuk table db_order
			// fungsi table : untuk menyimpan data order produk
			if($table == "db_orders"){

				// filter data berdasarkan waktu, m = bulan , y = tahun
				if(!empty($this->get("m")) and !empty($this->get("y"))) {

					$first = strtotime("01 ".$this->get("m")." ".$this->get("y"));
					$last = strtotime(date("t M Y", $first));

				}else{

					$first = null;
					$last = null;
				}

				// filter data berdasarkan pencarian kata kunci
				if(empty($this->get("q"))){
					if(!empty($first) and !empty($last))
					$condition = "WHERE start_time >= $first and start_time <= $last";

					else 
					$condition = "";


					$search = "";

				}else{

					// restrukturisasi data untuk digunakan sebagai query paramater
					if(!empty($first) and !empty($last))
					$condition = "WHERE (status='".str_replace("t",null,$this->get("q"))."' or product_id='".urldecode($this->get("q"))."' or invoice_id='".urldecode($this->get("q"))."') and start_time >= $first and start_time <= $last  ";

					else
					$condition = "WHERE (status='".str_replace("t",null,$this->get("q"))."' or product_id='".urldecode($this->get("q"))."' or invoice_id='".urldecode($this->get("q"))."')";

					if($this->get("q") == "request_cancel"){
						if(!empty($first) and !empty($last)) $condition = "WHERE rec_cancel='1' and start_time >= $first and start_time <= $last";
						else $condition = "WHERE rec_cancel='1' ";
					}

					$search = "?q=".$this->get("q");
				}

			}


			// query untuk table db_user
			// fungsi table : untuk menyimpan data pengguna yang terdaftar
			if($table == "db_users"){

				// filter pengguna berdasarkan hak akses
				if($slug == "customer_funds"){
				$search1 = "WHERE level <= 1 and (first_name like '%".$this->get("q",["'"])."%' or username like '%".$this->get("q",["'"])."%')";

				}elseif(strtolower($this->get("q")) == "customer") 
				$search1 = "WHERE id != ".userinfo()->user_id." and level=0";

				elseif(strtolower($this->get("q")) == "suplier") 
				$search1 = "WHERE id != ".userinfo()->user_id." and level=1";

				elseif(strtolower($this->get("q")) == "admin") 
				$search1 = "WHERE id != ".userinfo()->user_id." and level=2";

				elseif(strtolower($this->get("q")) == "administrator") 
				$search1 = "WHERE id != ".userinfo()->user_id." and level=3";

				// restrukturisasi data untuk melakukan query
				else $search1 = "WHERE 
				(first_name like '%".urldecode($this->get("q"))."%' or 
				last_name like '%".urldecode($this->get("q"))."%' or
				address like '%".urldecode($this->get("q"))."%' or
				province like '%".urldecode($this->get("q"))."%' or
				state like '%".urldecode($this->get("q"))."%' or
				zip_code like '%".urldecode($this->get("q"))."%' or
				phone_number like '%".urldecode($this->get("q"))."%' or
				email like '%".urldecode($this->get("q"))."%' or
				username like '%".urldecode($this->get("q"))."%') and id != ".userinfo()->user_id."";

				
				$condition = $search1;

			}


			// query untuk table db_custom_page
			// fungsi table : untuk menyimpan data halaman tambahan & data blog
			if(($table == "db_custom_page") and ($slug == "page_content")){

				$condition = "WHERE level < 2";

			}

			// query untuk table db_activity
			// fungsi table : untuk menyimpan data catatan aktifitas saat mengakses webiste
			// data yang di catat adalah data dari user admin dan administrator
			if($table == "db_activity"){

				if(!empty($this->get("month")) and !empty($this->get("years")) and !empty($this->get("q"))) {

					$strtime1 = strtotime("1 ".$this->get("month")." ".$this->get("years")." 00:01");
					$strtime2 = date("t M Y",$strtime1);
					$strtime2 = strtotime($strtime2." 23:59");
					$condition = "WHERE date_time >= $strtime1 and date_time <= $strtime2 and (msg like '%".urldecode($this->get("q"))."%')";
				}

				if(!empty($this->get("month")) and !empty($this->get("years")) and empty($this->get("q"))) {

					$strtime1 = strtotime("1 ".$this->get("month")." ".$this->get("years")." 00:01");
					$strtime2 = date("t M Y",$strtime1);
					$strtime2 = strtotime($strtime2." 23:59");
					$condition = "WHERE date_time >= $strtime1 and date_time <= $strtime2 ";
				}

				if((empty($this->get("month")) or empty($this->get("years"))) and !empty($this->get("q"))) {

					$condition = "WHERE msg like '%".urldecode($this->get("q"))."%' ";

				}

				if(empty($this->get("month")) and empty($this->get("years")) and empty($this->get("q"))) {

					$condition = null;

				}

			}

			// query untuk table db_custom_page
			// fungsi table : untuk menyimpan data halaman tambahan & data blog

			if(($table == "db_custom_page") and ($slug == "blogs")){

				if(!empty($this->get("q")))
				$condition = "WHERE (title like '%".urldecode($this->get("q"))."%') and level > 1";
				else
				$condition = "WHERE level  > 1";

			}

			// query untuk table db_email
			// fungsi table : utnuk menyimpan data email dari pengguna

			if($table == "db_email"){

				$condition = "";

			}

			// data maksimal yang di tablpikan pada tiap halaman
			$data['dataperpage'] = 10;

			// total keseluruhan data yang akan di tampilkan 
			$query = $this->db()->query("SELECT * FROM $table ".$condition);
			$count_data = $query->rowCount();

			$data['totaldata'] = $count_data;

			// url peralihan halaman
			$data['url'] = HomeUrl()."/adminpanel/".$slug.$search;

			// css class untuk pagination
			$data['container_class'] = "pagination";

			// css class untuk list pagination
			$data['li_class'] = null;

			// css class untuk hyperlink pada pagination
			$data['a_class'] = null;

			// element untuk fitur Single Page Application
			$data['pjax_class'] = "web-content";

			// css class saat halaman sedang aktif
			$data['active_class'] = "active";

			// element untuk fitur Single Page Application
			$data['add_attribute'] = "data-title=''";

			// query condition dalam penyeleksian data
			$data['condition'] = $condition;

			// mengembalikan nilai dalam bentuk object
			if($return == false) return json_decode(json_encode($data));

			// mengembalikan nilai dalam bentuk html element
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

		// menambah data produk
		function add_product(){

			$this->model("adminpanel/add_product");

		}


		// merubah data produk
		function edit_product(){

			$this->model("adminpanel/edit_product");

		}

		// menghapus data produk
		function delete_product(){

			$this->model("adminpanel/delete_product");

		}

		// menghapus data halaman
		function delete_page(){

			$this->model("adminpanel/delete_page");

		}

		// menambah data kategori
		function add_category(){

			$this->model("adminpanel/add_category");

		}

		// menghapus data kategori
		function delete_category(){

			$this->model("adminpanel/delete_category");

		}
		
		// menghapus data user
		function delete_users(){

			$this->model("adminpanel/delete_users");

		}

		// merubah data kategori
		function edit_category(){

			$this->model("adminpanel/edit_category");

		}

		// menampilkan data sub category
		function subcategory(){

			$this->model("adminpanel/subcategory");

		}

		// menampilkan data chat yang pernah di lakukan
		function chat_list(){

			$this->model("adminpanel/chat_list");

		}

		// menyimpan data pengaturan website
		function save_setting(){

			$this->model("adminpanel/save_setting");

		}

		// menyimpan data user
		function add_users(){

			$this->model("adminpanel/add_users");

		}

		// menambahkan data halaman baru
		function add_page(){

			$this->model("adminpanel/add_page");

		}

		// merubah data user
		function edit_users(){

			$this->model("adminpanel/edit_users");

		}

		// merubah data halaman
		function edit_page(){

			$this->model("adminpanel/edit_page");

		}

		// membalaas email
		function reply_mail(){

			$this->model("adminpanel/reply_mail");

		}

		// menghapus email
		function delete_email(){

			$this->model("adminpanel/delete_email");

		}

		// merubah status data
		function set_active(){

			$this->model("adminpanel/set_active");

		}

		// menambahkan data informasi bank
		function add_bank(){

			$this->model("adminpanel/add_bank");

		}

		// menghapus data bank
		function delete_bank(){

			$this->model("adminpanel/delete_bank");

		}

		// memverifikasi order status
		function verifikasi_order(){

			$this->model("adminpanel/verifikasi_order");

		}

		// memverifikasi email saat pendaftaran
		function verif_mail(){

			$this->model("adminpanel/verif_mail");

		}

		// memverifikasi email saat pendaftaran
		function verif_mail_code(){

			$this->model("adminpanel/verif_mail_code");

		}

		// merubah data bank
		function edit_bank(){

			$this->model("adminpanel/edit_bank");

		}

		// merubah data profile pengguna
		function change_profile(){

			$this->model("adminpanel/change_profile");

		}

		// logout dari session
		function logout(){

			$this->model("adminpanel/logout");

		}

		// memperbaharui session pengguna
		function set_online(){

			$this->model("adminpanel/set_online");

		}

		// memverifikasi permintaan refund dana ari wallet
		function verif_refund(){
			$this->model("adminpanel/verif_refund");
		}

		// memverifikasi permintaan deposit saldo pengguna ke wallet
		function verif_deposit(){
			$this->model("adminpanel/verif_deposit");
		}

	}

?>
