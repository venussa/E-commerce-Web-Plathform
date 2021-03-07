<?php
	
	class mail_submit extends load{

		function __construct(){

			foreach ($this->post() as $key => $value) {
				if(empty(strip_tags($value))){

					echo "<script>alert('Mohon lengkapi seluruh isian form.');window.history.back();</script>";
					exit;	
				}
			}

			if(strip_tags($this->post("chaptcha")) !== $_SESSION["captcha_code"]){
			echo "<script>alert('Chaptcha salah.');window.history.back();</script>";
			exit;
			}

			foreach($this->post() as $key => $val){

				if($key !== "chaptcha")
				$data[$key] = "'".strip_tags($val)."'";

			}

			$data['date_time'] = "'".time()."'";

			$field = implode(",",array_keys($data));
			$value = implode(",",($data));

			$this->db()->query("INSERT INTO db_email ($field) VALUES ($value)");

			$email = strip_tags($this->post("email"));

			$new_email = $this->db()->query("SELECT * FROM db_email WHERE email='".$email."' ORDER By id DESC limit 1 ");
			$new_email = $new_email->fetch();

			$text  = "<p>Dari : <b>".$email."</b></p>";
			$text .= "<p>Subject : <b>".strip_tags($this->post("subject"))."</b></p>";
			$text .= "<p>Message : <b>".strip_tags($this->post("msg"))."</b></p>";
			$text .= "<p>Email dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini. Jika ingin membalasnya, silahkan gunakan menu <a href='".HomeUrl()."/adminpanel/replymail?id=".$new_email['id']."'>User Opinion</a></p>";

			$admin = $this->db()->query("SELECT * FROM db_users WHERE level >=2 ");
			while($show = $admin->fetch()){
				
				PHPmailer($show['email'],"[Pemberitahuan] $email mengirim pesan baru pada tanggal ".date("d M Y"), $text);

				save_alert(array(
						"user_id" => "'".$show['id']."'",
						"order_id" => "'".$new_email['id']."'",
						"msg" => "'<span style=\"color:orangered\">$email</span> mengirim pesan kepada anda, segera tanggapi pesan tersebut.'",
						"icon"	=> "'mail'",
						"url" => "'adminpanel/replymail'",
						"date_time" => "'".time()."'"
					));
			}

			echo "<script>alert('Terimakasih, Kami akan membalasnya ke email yang anda masukkan');window.history.back();</script>";
			exit;


		}

	}

?>
