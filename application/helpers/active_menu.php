<?php 


// fungsi untuk mengubal element pada class list menu menjadi active class
function setActiveMenu($data){

	if(is_array($data)){
			
		if(in_array(splice(2),$data)) return "class='active'";

	}else{

		if(splice(2) == $data) return "class='active'";

	}

}

function client_sidebar_menu(){

	return array(
		"dashboard" => array(
			"title"	=> "Dashboard",
			"icon"	=> "media/home.png",
			"slug"	=> array("dashboard"),
			"level"	=> 0
		),
		"pemberitahuan" => array(
			"title"	=> "Pemberitahuan",
			"icon"	=> "media/bell.png",
			"slug"	=> array("pemberitahuan"),
			"level"	=> 0
		),
		"riwayat_saldo" => array(
			"title"	=> "Riwayat Saldo",
			"icon"	=> "media/wallet.png",
			"slug"	=> array("riwayat_saldo","penarikan_saldo","deposit"),
			"level"	=> 0
		),
		"produk_saya" => array(
			"title"	=> "Produk Saya",
			"icon"	=> "media/barang.png",
			"slug"	=> array("produk_saya","tambah_produk","rubah_produk"),
			"level"	=> 1
		),
		"pembayaran_tertunda" => array(
			"title"	=> "Pembayaran Tertunda",
			"icon"	=> "media/pending.png",
			"slug"	=> array("pembayaran_tertunda","konfirmasi_pembayaran"),
			"level"	=> 0
		),
		"komplain_pembelian" => array(
			"title"	=> "Komplain Pembelian",
			"icon"	=> "/media/complain-icon.png",
			"slug"	=> array("komplain_pembelian","detail_komplein"),
			"level"	=> 0
		),
		"daftar_transaksi" => array(
			"title"	=> "Daftar Transaksi",
			"icon"	=> "media/tf.png",
			"slug"	=> array("daftar_transaksi","detail_pesanan","komplain_produk","batalkan_pesanan"),
			"level"	=> 0
		),
		"keranjang_belanja" => array(
			"title"	=> "Keranjang",
			"icon"	=> "img/cart.png",
			"slug"	=> array("keranjang_belanja","konfirmasi_pembelian"),
			"level"	=> 0
		),
		"whishlist" => array(
			"title"	=> "Whislist",
			"icon"	=> "media/love.png",
			"slug"	=> array("whishlist"),
			"level"	=> 0
		),
		"alamat_pengiriman" => array(
			"title"	=> "Alamat Pengiriman",
			"icon"	=> "media/mark.png",
			"slug"	=> array("alamat_pengiriman","tambah_alamat","rubah_alamat"),
			"level"	=> 0
		)

	);

}

function admin_sidebar_menu(){

	return array(
		"dashboard" => array(
			"title"	=> "Dashboard",
			"icon"	=> "media/home.png",
			"slug"	=> array("dashboard"),
			"role"	=> "dashboard",
			"level"	=> 2
		),
		"notification" => array(
			"title"	=> "Notification",
			"icon"	=> "media/bell.png",
			"slug"	=> array("notification"),
			"role"	=> "notification",
			"level"	=> 2
		),
		"blogs" => array(
			"title"	=> "Blog's",
			"icon"	=> "media/blogs.png",
			"slug"	=> array("blogs","addblog","editblog"),
			"role"	=> "blog",
			"level"	=> 2
		),
		"page_content" => array(
			"title"	=> "Custom Page",
			"icon"	=> "media/blog.png",
			"slug"	=> array("page_content","editpage","addpage"),
			"role"	=> "custom",
			"level"	=> 2
		),
		"galery_manager" => array(
			"title"	=> "Galery",
			"icon"	=> "media/galery.png",
			"slug"	=> array("galery_manager"),
			"role"	=> "blog",
			"level"	=> 2
		),
		"product" => array(
			"title"	=> "Product",
			"icon"	=> "media/barang.png",
			"slug"	=> array("product","addproduct","editproduct"),
			"role"	=> "product",
			"level"	=> 2
		),
		"orders" => array(
			"title"	=> "Orders",
			"icon"	=> "media/tf.png",
			"slug"	=> array("orders","lihatorder"),
			"role"	=> "order",
			"level"	=> 2
		),
		"money" => array(
			"title"	=> "Income Prediction",
			"icon"	=> "media/pending.png",
			"slug"	=> array("money"),
			"role"	=> "income",
			"level"	=> 3
		),
		"request_refund" => array(
			"title"	=> "Request Refund",
			"icon"	=> "media/wallet.png",
			"slug"	=> array("request_refund","refund_status"),
			"role"	=> "refund",
			"level"	=> 2
		),
		"request_deposit" => array(
			"title"	=> "Request Deposit",
			"icon"	=> "media/deposit.png",
			"slug"	=> array("request_deposit","deposit_status"),
			"role"	=> "deposit",
			"level"	=> 2
		),
		"customer_funds" => array(
			"title"	=> "Customer Funds",
			"icon"	=> "media/deposite.png",
			"slug"	=> array("customer_funds","view_funds"),
			"role"	=> "funds",
			"level"	=> 2
		),
		"category" => array(
			"title"	=> "Categories",
			"icon"	=> "media/kategori.png",
			"slug"	=> array("category","editcategory"),
			"role"	=> "category",
			"level"	=> 2
		),
		"bank" => array(
			"title"	=> "Bank Information",
			"icon"	=> "media/bank1.png",
			"slug"	=> array("bank","addbank","editbank"),
			"role"	=> "bank",
			"level"	=> 2
		),
		"message" => array(
			"title"	=> "Message",
			"icon"	=> "media/cb.png",
			"slug"	=> array("message"),
			"role"	=> "order",
			"level"	=> 2
		),
		"users_opinion" => array(
			"title"	=> "Users Opinion",
			"icon"	=> "media/surat.png",
			"slug"	=> array("users_opinion","replymail"),
			"role"	=> "opinion",
			"level"	=> 2
		),
		"users" => array(
			"title"	=> "Users",
			"icon"	=> "media/users.png",
			"slug"	=> array("users","editusers","addusers"),
			"role"	=> "user",
			"level"	=> 2
		),
		"settings" => array(
			"title"	=> "Settings",
			"icon"	=> "media/cog.png",
			"slug"	=> array("settings"),
			"role"	=> "setting",
			"level"	=> 3
		),
		"mugencode" => array(
			"title"	=> "Filemanager",
			"icon"	=> "media/fm.png",
			"slug"	=> array("mugencode"),
			"role"	=> "filemanager",
			"level"	=> 3
		),
	);

}

function check_role($id, $role_data){

	echo (in_array($id,$role_data)) ? "checked" : null;

}