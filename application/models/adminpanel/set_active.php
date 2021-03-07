<?php
	
	class set_active extends load{

		function __construct(){

			if(userinfo()->level < 2) return false;

			if($this->post("type") == "users")
			echo $this->users();

			if($this->post("type") == "product")
			echo $this->product();

			if($this->post("type") == "page")
			echo $this->page();

			if($this->post("type") == "post")
			echo $this->set_post();

		}

		function users(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("user", "2");
			}

			$query = $this->db()->query("SELECT * FROM db_users WHERE id='".$this->post("id")."' ");

			$fetch = $query->fetch();

			if($fetch['status'] == 1) {

				$this->db()->query("UPDATE db_users SET status='0' WHERE id='".$this->post("id")."' ");
				save_activity("Suspend username <b>".$fetch['username']."</b>");
				return "<false/>";

			}else{

				$this->db()->query("UPDATE db_users SET status='1' WHERE id='".$this->post("id")."' ");
				save_activity("Unuspend username <b>".$fetch['username']."</b>");
				return "<true/>";

			}

		}

		function product(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("product", "2");
			}

			$query = $this->db()->query("SELECT * FROM db_product WHERE sorting_id='".$this->post("id")."' ");

			$fetch = $query->fetch();

			if($fetch['status'] == 1) {

				$this->db()->query("UPDATE db_product SET status='0' WHERE sorting_id='".$this->post("id")."' ");
				save_activity("Suspend produk <b>".$fetch['title']."</b> dengan produk id <b>".$fetch['product_id']."</b>");

				return "<false/>";

			}else{

				$this->db()->query("UPDATE db_product SET status='1' WHERE sorting_id='".$this->post("id")."' ");
				save_activity("Unsuspend produk <b>".$fetch['title']."</b> dengan produk id <b>".$fetch['product_id']."</b>");

				return "<true/>";

			}

			

		}

		function page(){

			$query = $this->db()->query("SELECT * FROM db_custom_page WHERE id='".$this->post("id")."' ");

			$fetch = $query->fetch();

			if(userinfo() == false) return false;
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				if($fetch['level'] >= 2) role_access("blog", "2");
				if($fetch['level'] < 2) role_access("custom", "2");
			}

			if($fetch['status'] == 1) {

				$this->db()->query("UPDATE db_custom_page SET status='0' WHERE id='".$this->post("id")."' ");

				if($fetch['level'] == 2){

					save_activity("Suspend blog berjudul <b>".$fetch['title']."</b>");

				}else{
	
					save_activity("Suspend custom page berjudul <b>".$fetch['title']."</b>");

				}
				
				return "<false/>";

			}else{

				$this->db()->query("UPDATE db_custom_page SET status='1' WHERE id='".$this->post("id")."' ");
				if($fetch['level'] == 2){

					save_activity("Unsuspend blog berjudul <b>".$fetch['title']."</b>");

				}else{
	
					save_activity("Unsuspend custom page berjudul <b>".$fetch['title']."</b>");

				}
				return "<true/>";

			}

		}

		function set_post(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("custom", "2");
			}

			$query = $this->db()->query("SELECT * FROM db_custom_page WHERE id='".$this->post("id")."' ");

			$fetch = $query->fetch();

			$this->db()->query("UPDATE db_custom_page SET position='".$this->post("vals")."' WHERE id='".$this->post("id")."' ");
			save_activity("Merubah posisi custom page bernama <b>".$fetch['title']."</b> dari <b>".$fetch['position']."</b> menjadi <b>".$this->post("vals")."</b>"); 

		}

			


	}