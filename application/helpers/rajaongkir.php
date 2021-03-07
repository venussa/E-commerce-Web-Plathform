<?php 

function delivery_cost($from, $send_to, $weight){

	$courier = array("jne","tiki","pos");

	foreach($courier as $key => $value){

		$curl = curl_init();

		curl_setopt_array($curl, array(

		  	CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 30,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "POST",
		  	CURLOPT_POSTFIELDS => "origin=".$from."&destination=".$send_to."&weight=".$weight."&courier=".$value,
		  	CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded",
			    "key: ".setting()->api
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		$json = json_decode($response);

		$data[] = $json->rajaongkir->results;

	}

	$index = 0;

	foreach($data as $key => $value){

		foreach($value[0]->costs as $key1 => $value1){

			$delivery_data[$index]["icon"] = $value[0]->code.".png";
			$delivery_data[$index]["code"] = $value[0]->code;
			$delivery_data[$index]["company_name"] = $value[0]->name;
			$delivery_data[$index]["service_name"] = $value1->service;
			$delivery_data[$index]["service_description"] = $value1->description;
			$delivery_data[$index]["price"] = $value1->cost[0]->value;
			$delivery_data[$index]["time"] = $value1->cost[0]->etd;

			$index++;
		}

	}


	return json_decode(json_encode($delivery_data));

}