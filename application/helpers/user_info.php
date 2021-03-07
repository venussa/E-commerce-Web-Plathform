<?php

function userinfo($user_id = null){


	if(empty($user_id)){

		if(!isset($_SESSION['user'])) return false;
		
		$value = $_SESSION['user'];

	}else 
	
		$value = $user_id;

	
	$query = database()->query("SELECT * FROM db_users WHERE username='".$value."' ");
	$show = $query->fetch();
	$show['user_id'] = $show['id'];


	if($query->rowCount() !== 0){

		return json_decode(json_encode($show));

	}

	return false;

}

function role_access($slug = null, $role = 0){

	if(empty($slug) and ($role == 0)) return false; 

	$administrator = ["setting","filemanager"];

	$data = json_decode(userinfo()->role);

	if(in_array($slug, $administrator)) die("Access Danied");
	
	if(!in_array($role, $data->$slug))	die("Access Danied");

}