<?php

function save_activity($msg,$url = null){
	
	$query = database()->query("INSERT INTO 
		db_activity (user_id, msg, url, date_time)
		VALUES ('".userinfo()->user_id."','".$msg."','".$url."','".time()."')
		");

}

function save_alert($data){

	$field = implode(",",array_keys($data));
	$value = implode(",",$data);

	$query = database()->query("insert into db_alert ($field) values ($value)");

}

// save_alert(array(
// 	"user_id" => "'".."'",
// 	"order_id" => "'".."'",
// 	"msg" => "'".."'",
// 	"date_time" => "'".time()."'"
// ));