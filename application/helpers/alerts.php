<?php 

function check_alert(){
	
	$command = "SELECT * FROM db_chats WHERE sender_id = '".userinfo()->user_id."' or user_id = '".userinfo()->user_id."'  GROUP BY room ORDER BY id DESC";
	$query = database()->query($command);
	$sigma_alert = 0;

	while($show = $query->fetch()){ 

	if($show['sender_id'] == userinfo()->user_id){
		$usr = "SELECT * FROM db_users WHERE id='".$show['user_id']."'";
		$usr = database()->query($usr);
		$usr = $usr->fetch();

		$sum_alert = database()->query("SELECT * FROM db_chats WHERE sender_id='".$usr['id']."' and room='".$show['room']."' and status='0' ");
		$sum_alert = $sum_alert->rowCount();
	}

	if($show['user_id'] == userinfo()->user_id){
		
		$usr = "SELECT * FROM db_users WHERE id='".$show['sender_id']."'";
		$usr = database()->query($usr);
		$usr = $usr->fetch();

		$sum_alert = database()->query("SELECT * FROM db_chats WHERE sender_id='".$usr['id']."' and room='".$show['room']."'  and status='0' ");
		$sum_alert = $sum_alert->rowCount();
	}

	$sigma_alert += $sum_alert;
	
	}

	return $sigma_alert;
}



function check_new_order(){

	$query = database()->query("SELECT * FROM db_orders WHERE status >= 0 and status < 2");

	return $query->rowCount();

}

function filter_alert($id){

	if(userinfo() == false) return 0;

	$alert = $id;

	$username = database()->query("SELECT * FROM db_users WHERE id='".$alert['user_id']."' ");
	$username = $username->fetch();

	$order = database()->query("SELECT * FROM db_orders WHERE sorting_id='".$alert['order_id']."' ");
	$order = $order->fetch();

	if(!isset($order['product_id'])) $order['product_id'] = null;
	$product = database()->query("SELECT * FROM db_product WHERE product_id='".$order['product_id']."' ");
	$product = $product->fetch();

	if(!isset($order['delivery_service'])) $order['delivery_service'] = null;
	$delivery = database()->query("SELECT * FROM db_delivery_service WHERE id='".$order['delivery_service']."' ");
	$delivery = $delivery->fetch();


	if(!isset($order['user_id'])) $order['user_id'] = null;
	$username2 = database()->query("SELECT * FROM db_users WHERE id='".$order['user_id']."' ");
	$username2 = $username2->fetch();

	if(!isset($username2['first_name'])) $username2['first_name'] = null;
	if(!isset($username2['last_name'])) $username2['last_name'] = null;

	if($username["level"] > 1){
		
		

		$name = ucwords($username2['first_name']." ".$username2['last_name']);
		$name2 = ucwords($username2['first_name']." ".$username2['last_name']);

	}else{
		
		$username2 = database()->query("SELECT * FROM db_users WHERE id='".$order['handle_by']."' ");
		$rowcount = $username2->rowCount();
		$username2 = $username2->fetch();

		$name = ucwords($username['first_name']." ".$username['last_name']);

		if($rowcount > 0)
		$name2 = ucwords($username2['first_name']." ".$username2['last_name']);
		else $name2 = null;

	}

	if(!isset($product['title'])) $product['title'] = null;
	if(!isset($order['invoice_id'])) $order['invoice_id'] = null;
	if(!isset($delivery['service_description'])) $delivery['service_description'] = null;
	if(!isset($order['resi_number'])) $order['resi_number'] = null;

	$msg = $alert['msg'];

	$data["username"] = "<b style='text-decoration:none;color:orangered;font-weight:400;;'>".$name."</b>";
	$data["product_title"] = "<b style='text-decoration:none;color:orangered;font-weight:400;;'>".$product['title']."</b>";
	$data["invoice"] = "<b style='text-decoration:none;color:orangered;font-weight:400;;'>".$order['invoice_id']."</b>";
	$data["delivery"] = "<b style='text-decoration:none;color:orangered;font-weight:400;;'>".$delivery['service_description']."</b>";
	$data["resi"] = "<b style='text-decoration:none;color:orangered;font-weight:400;;'>".$order['resi_number']."</b>";
	$data["from-user"] = "<b style='text-decoration:none;color:orangered;font-weight:400;;'>".$name2."</b>";

	foreach($data as $key => $val){

		$msg = str_replace("{".$key."}", $val, $msg);

	}

	return $msg;

}

function alert_notification(){

	if(userinfo() == false) return 0;
	
	$query = database()->query("SELECT * FROM db_alert WHERE user_id='".userinfo()->user_id."' and status='0'");
	return $query->rowCount();

}