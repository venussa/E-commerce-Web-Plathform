<?php

function check_online($id){

	$db = database()->query("SELECT * FROM db_users WHERE id='".$id."' ");
	
	if($db->rowCount() !== 0){

		$show = $db->fetch();

		$count = time() - $show['online'];
		
		if($count > 300){

			return "offline";

		}else{

			return "online";

		}

	}

}