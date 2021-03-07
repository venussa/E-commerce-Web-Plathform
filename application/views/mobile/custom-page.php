<?php 
$query = $this->db()->query("SELECT * FROM db_custom_page WHERE slug='".splice(1)."'");
$show = $query->fetch();

if($show['contact_form'] > 0){
	$class1 = "col-lg-7";
}else{
	$class1 = "col-lg-12";
}
?>
<div class="container" style="margin-top: 70px;background: #fff;padding: 0px;border:1px #ddd solid;margin-bottom: 20px;">

<div class="<?php echo $class1?>" style="padding:10px;">
			<h3 style="color:#434343;padding: 5px;font-size: 22px;"><?php echo $show['title']?></h3>
			<?php if(!empty($show['img'])){ ?>

				<p style="text-align: center;padding: 10px;margin:10px;">
				<img src="<?php echo sourceUrl()?>/website/<?php echo $show['img']?>" style="width: 100%;border-radius: 10px;border:1px #ddd solid;">
				</p>

			<?php } ?>
			<div style="padding: 5px;"><?php echo str_replace("../sources/",HomeUrl()."/sources/",$show['content']) ?></div>
		</div>

		<?php if($show['contact_form'] > 0){ ?>
		<div style="padding: 25px;margin-top:-20px">

			<form method="POST" action="<?php echo HomeUrl()?>/handler/mail_submit" style="padding: 15px;background: #f5f5f5;border:1px #ccc solid;">
				<h3 style="color:#434343;padding: 5px;margin-top:20px;">Kirim Pesan</h3>
				<input type="email" name="email" style="width: 100%;padding: 10px;border:1px #ddd solid;border-radius: 10px;margin-bottom: 10px;" placeholder="Email Anda" required>
				<input type="text" name="subject" style="width: 100%;padding: 10px;border:1px #ddd solid;border-radius: 10px;margin-bottom: 10px;" placeholder="Subject Pesan" required>

				<textarea name="msg" style="min-width: 100%;height:130px;max-width: 100%;padding: 10px;border:1px #ddd solid;border-radius: 10px;margin-bottom: 10px;" placeholder="Masukkan Pesan ..."></textarea>

				<img src="<?php echo create_captcha()->captcha_image_url?>" style="width: 200px;height:50px;margin-top:10px;margin-bottom:20px;border-radius: 5px;">

				<input type="text" name="chaptcha" autocomplete="off" placeholder="Masukkan Chaptcha" style="width: 100%;padding: 10px;border:1px #ddd solid;border-radius: 10px;margin-bottom: 10px;">

				<button style="padding: 10px;border:1px #fe4c50 solid;background: #fe4c50;color:#fff;font-weight: 600;border-radius: 5px;cursor: pointer;">Kirim Pesan</button>
			</form>
		</div>

	<?php } ?>

</div>