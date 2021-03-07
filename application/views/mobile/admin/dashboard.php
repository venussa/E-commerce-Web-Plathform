
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Selamat datang <b><?php echo ucwords(userinfo()->first_name." ".userinfo()->last_name) ?></b> di halaman khusus admin, anda memiliki level akses 
<?php switch(userinfo()->level){

	case "0":
		echo "<b>Customer</b>";
	break;

	case "1":
		echo "<b>Suplier</b>";
	break;

	case "2":
		echo "<b>Admin</b> yang mana anda dapat mengakses seluruh menu pada halaman ini. namun memiliki wewenang di bawah level administrator";
	break;

	case "3":
		echo "<b>Administrator</b> yang mana anda dapat mengakses seluruh menu pada halaman ini dan juga mempunya wewenang penuh atas kontrol website";
	break;

}?>
</p>

<?php 
$time = 300;
$post = $this->db()->query("SELECT * FROM db_product");
$customer = $this->db()->query("SELECT * FROM db_users WHERE (".time()." - online) < $time ");
$category = $this->db()->query("SELECT * FROM db_category WHERE level=0 and sublevel=0");
$pending = $this->db()->query("SELECT * FROM db_orders WHERE status > 0 and status < 2");
$finish = $this->db()->query("SELECT * FROM db_orders WHERE status = 8 ");
$complain = $this->db()->query("SELECT * FROM db_orders WHERE status = 5 ");
$cancel = $this->db()->query("SELECT * FROM db_cancel_order WHERE status=0");
$reqship = $this->db()->query("SELECT * FROM db_orders WHERE status=2");
$inship = $this->db()->query("SELECT * FROM db_orders WHERE status=3");
?>



<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;height:60px;margin-bottom: 10px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t1';">
	<img src="<?php echo HomeUrl()?>/sources/media/order.png">
	<p class="title">PAYMENT REQUEST</p>
	<p class="description"><?php echo number_format($pending->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;height:60px;margin-bottom: 10px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t5';">
	<img src="<?php echo HomeUrl()?>/sources/media/complain.png">
	<p class="title">COMPLAIN ORDER</p>
	<p class="description"><?php echo number_format($complain->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;height:60px;margin-bottom: 10px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t8';">
	<img src="<?php echo HomeUrl()?>/sources/media/cart2.png">
	<p class="title">FINISH ORDER</p>
	<p class="description"><?php echo number_format($finish->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;height:60px;margin-bottom: 10px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=request_cancel';">
	<img src="<?php echo HomeUrl()?>/sources/media/cancel.png">
	<p class="title">CANCEL ORDER</p>
	<p class="description"><?php echo number_format($cancel->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;height:60px;margin-bottom: 10px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t2';">
	<img src="<?php echo HomeUrl()?>/sources/media/reqship.png">
	<p class="title">DELIVERY REQUEST</p>
	<p class="description"><?php echo number_format($reqship->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;height:60px;margin-bottom: 10px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/orders?q=t3';">
	<img src="<?php echo HomeUrl()?>/sources/media/inship.png">
	<p class="title">IN SHIPPING</p>
	<p class="description"><?php echo number_format($inship->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;height:60px;margin-bottom: 10px;" onClick="window.location='<?php echo Homeurl()?>/adminpanel/product';">
	<img src="<?php echo HomeUrl()?>/sources/media/post.png">
	<p class="title">TOTAL PRODUCT</p>
	<p class="description"><?php echo number_format($post->rowCount())?></p>
</div>

<div class="panel-box" style="cursor: pointer;box-shadow:none;border:1px #ddd solid;border-radius:0px;height:60px;margin-bottom: 10px;">
	<img src="<?php echo HomeUrl()?>/sources/media/online.png">
	<p class="title">USER ONLINE</p>
	<p class="description"><?php echo number_format($customer->rowCount())?></p>
</div>

