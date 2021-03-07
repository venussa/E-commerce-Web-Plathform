<?php
	
	class reply_mail extends load{

		function __construct(){

			if(userinfo() == false) die("Access Danied");
			if(userinfo()->level < 2) die("Access Danied");
			if((userinfo()->level >= 2) and (userinfo()->level < 3)) {
				role_access("opinion", "6");
			}

			if(!empty($this->get("id"))){

				$query = $this->db()->query("SELECT * FROM db_email WHERE id='".$this->get("id")."'");
				$show = $query->fetch();

				$text = strip_tags(str_replace("'",null,$this->post("reply")));


				if($this->check_room() == true){

					$this->db()->query("UPDATE db_email SET reply='".$text."', reply_time='".time()."'  WHERE id='".$show['id']."'  ");

					save_activity("Membalas email dari <b>".$show['email']."</b>");

					$msg  = "<p>From  : <b>".strip_tags(setting()->email)."</b></p>";
					$msg  = "<p>Question : <b>".strip_tags($show["msg"])."</b></p>";
					$msg .= "<p>Reply : <b>".strip_tags($text)."</b></p>";
					$msg .= "<p>Email dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini. Jika ingin membalasnya, silahkan gunakan menu <a href='".HomeUrl()."/hubungi-kami'>hubungi-kami</a></p>";

					PHPmailer($show['email'],"[Pemberitahuan] Anda mendapat email dari ".setting()->title." pada ".date("d M Y"), $msg);
				}


				echo "<script>window.location='".HomeUrl()."/adminpanel/replymail?id=".$this->get("id")."';</script>";

			}else echo "<script>window.location='".HomeUrl()."/adminpanel/replymail?id=".$this->get("id")."';</script>";

		}

		function check_room(){

			$query = $this->db()->query("SELECT * FROM db_email WHERE id='".$this->get("id")."'");
			
			if($query->rowCount() == 0 ) return false;

			return true;

		}

	}