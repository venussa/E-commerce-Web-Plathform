<?php

function provinsi(){

	$path = SERVER."/application/plugin/IndonesianTerritory/provinsi.json";

	$get_data = implode(null,file($path));

	return json_decode($get_data);

}

function kabupaten($id = "p1"){

	$path = SERVER."/application/plugin/IndonesianTerritory/kabupaten/".$id.".json";

	$get_data = implode(null,file($path));

	return json_decode($get_data);

}

function kecamatan($id = "k1"){

	$path = SERVER."/application/plugin/IndonesianTerritory/kecamatan/".$id.".json";

	$get_data = implode(null,file($path));

	$data = json_decode($get_data);

	foreach($data as $key => $val){

		$kecamatan[$val->kodepos] = $val->kecamatan;

	}

	$kecamatan = array_unique($kecamatan);

	return $kecamatan;

}

function kodepos($id = "k1", $kecamatan = null){

	$path = SERVER."/application/plugin/IndonesianTerritory/kecamatan/".$id.".json";

	$get_data = implode(null,file($path));

	$data = json_decode($get_data);

	foreach($data as $key => $val){

		if($kecamatan == $val->kecamatan) return $val->kodepos;

	}

}

