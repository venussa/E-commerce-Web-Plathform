<?php

function setting(){

	$query = database()->query("SELECT * FROM db_settings");

	while($show = $query->fetch()){

		$data[$show['name']] = $show['conf'];

	}

	$data['icon'] = sourceUrl()."/image/".$data['icon'];
	$data['logo'] = sourceUrl()."/image/".$data['logo'];
	$data['thumbnail'] = sourceUrl()."/image/".$data['thumbnail'];

	return json_decode(json_encode($data));

}


function wallet_system(){

	$data = new application\config\routes;

	if($data->load_controller()['wallet_system'] == 0) return false;

	return true;

}