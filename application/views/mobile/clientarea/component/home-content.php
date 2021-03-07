<!DOCTYPE html>
<html>
<head>
	<title><?php echo strip_tags(ucwords(str_replace(["_","'"]," ",splice(2))))?> | <?php echo ucwords(setting()->title)?></title>
	<link rel="stylesheet" href="<?php echo HomeUrl() ?>/css/clientarea-mobile.css" />
	<link rel="base-url" id="base-url" href="<?php echo HomeUrl()?>" />
	<link rel="shortcut icon" href="<?php echo setting()->icon?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	
	{navbar-menu}

	<div class="container" style="padding: 0px;">
		
		{sidebar-menu}

		{home-content}

	</div>



	<div class="newsletter" style="background: #fff;border-top:1px #ccc solid;border-bottom:1px #ccc solid;padding-top:10px;margin-top: 20px;padding-bottom:20px;">
		
			
			
					<div>
						<p style="font-size: 15px;font-weight: 600;text-align: center;">Bank Transfer</p>
						<p style="margin-top: 15px;margin-bottom: 10px;text-align: center;">
							<?php 
							$query = $this->db()->query("SELECT * FROM db_pay_info");
							while($show = $query->fetch()){?>
								<img src="<?php echo HomeUrl()."/bank/".$show['icon']?>" style="width: 50px;height:25px;border-radius: 3px;border:1px #ddd solid;margin-right: 10px;background: #fff;">
							<?php } ?>
						</p>
					</div>
	
		
	
	
	</div>

	<!-- Footer -->

	<div class="footer" style="margin-bottom:80px;background: #fff;margin-top: -10px;padding:0px;">
			
				
					<div >
						<ul class="footer_nav" style="width: 100%;padding:0px;text-align: center;">
							<?php

							$query = $this->db()->query("SELECT * FROM db_custom_page WHERE status=1 and level=0 ORDER BY position ASC");

							while($show = $query->fetch()){	?>
							
								<li style="margin-right: 15px;border-bottom: 1px #ddd solid;width: 100%;list-style-type: none;padding-top:5px;padding-bottom: 5px;"><a style="font-size: 13px;color:#434343" href="<?php echo HomeUrl()?>/<?php echo $show['slug']?>"><?php echo $show['title']?></a></li>

							<?php } ?>
							<li style="margin-right: 15px;border-bottom: 1px #ddd solid;width: 100%;list-style-type: none;padding-top:5px;padding-bottom: 5px;"><a style="font-size: 13px;color:#434343" href="<?php echo HomeUrl()?>/blog">Blog's</a></li>
							<li style="margin-right: 15px;border-bottom: 1px #ddd solid;width: 100%;list-style-type: none;padding-top:5px;padding-bottom: 5px;"><a style="font-size: 13px;color:#434343" href="<?php echo HomeUrl()?>/sitemap/sitemap.xml">Sitemap</a></li>
						</ul>
					</div>
				
					<div >
						<ul style="width: 100%;text-align: center;padding: 0px;">
							<li style="list-style-type: none;display: inline-grid;width: 50px;"><a href="<?php echo setting()->facebook?>" target="_blank">
							<img src="<?php echo sourceUrl()?>/media/fb.png" style="width:20px;height:20px;border-radius: 5px;">
							</a></li>

							<li style="list-style-type: none;display: inline-grid;width: 50px;"><a href="<?php echo setting()->twitter?>" target="_blank">
							<img src="<?php echo sourceUrl()?>/media/tw.png" style="width:20px;height:20px;border-radius: 5px;">
							</a></li>

							<li style="list-style-type: none;display: inline-grid;width: 50px;"><a href="<?php echo setting()->instagram?>" target="_blank">
							<img src="<?php echo sourceUrl()?>/media/ig.png" style="width:20px;height:20px;border-radius: 5px;">
							</a></li>
						</ul>
					</div>
			
			



			<div style="margin-top:0px">
				<div class="cr" style="text-align: center;">©<?php echo date("Y")?> <?php echo setting()->title?>. All Rights Reserverd.</div>
			</div>
	
	</div>





<?php

	if((userinfo() !== false) and  (userinfo()->level > 1)){

		$url1 = "adminpanel/notification";
		$url2 = null;
		$url3 = null;
		$url4 = "adminpanel/profile";
		$url5 = "adminpanel";
		$url6 = "adminpanel/profileset";

	}else{

		$url1 = "clientarea/pemberitahuan";
		$url2 = "clientarea/whishlist";
		$url3 = "clientarea/keranjang_belanja";
		$url4 = "adminpanel/profile";
		$url5 = "clientarea";
		$url6 = "clientarea/pengaturan_profile";

	}

?>



<div id="b-nav" style="width: 100%;position: fixed;background: #fff;padding: 3px;padding-bottom:0px;bottom:0px;border-top:1px #ddd solid;z-index: 999;-webkit-box-shadow: 0px -1px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 0px -1px 6px 1px rgba(0,0,0,0.2);
box-shadow: 0px -1px 6px 1px rgba(0,0,0,0.2);left:0px;">
	<table width="100%" style="margin-bottom: -17px;padding: 5px;margin-top:5px;">
		<tr>
			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%">
					<img src="<?php echo sourceUrl()?>/media/home.png" style="width:25px;height: 25px;margin-top:-11px;">
					<p style="text-align: center;margin-top: 5px;padding-left: 5px;font-size: 12px;color:#434343">Home</p>
				</a>
			</td>

			<?php 
			$query = $this->db()->query("SELECT * FROM db_category WHERE level=0 ORDER BY rand() LIMIT 1");
			$category = $query->fetch();

			?>

			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>/<?php echo url_title($category['title'],"-",true)?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%">
					<img src="<?php echo sourceUrl()?>/media/kategori.png" style="width:27px;height: 27px;margin-top:-11px;">
					<p style="text-align: center;margin-top: 5px;padding-left: 5px;font-size: 12px;color:#434343">Kategori</p>
				</a>
			</td>

			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>/<?php echo $url2?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%">
					<img src="<?php echo sourceUrl()?>/media/love.png" style="width:25px;height: 25px;margin-top:-10px;">
					<p style="text-align: center;margin-top: 5px;padding-left: 5px;font-size: 12px;color:#434343">Ditandai</p>
				</a>
			</td>
			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>/<?php echo $url3?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%;">
					<?php if($this->total_cart() > 0){ ?>
					<span id="checkout_items" class="checkout_items" style="font-size: 10px;width: 15px;height: 15px;margin-top: 5px;"><?php echo $this->total_cart()?></span>

					<?php } ?>
					<img src="<?php echo sourceUrl()?>/img/cart.png" style="width:26px;height: 26px;margin-top: -10px;">
					<p style="text-align: center;margin-top: 5px;padding-left: 5px;font-size: 12px;color:#434343">Keranjang</p>

					
				</a>
			</td>
			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>/<?php echo $url4?>">
						<?php if(userinfo() !== false){ 

						if(empty(userinfo()->profile_pict) or (userinfo()->profile_pict == "")) {

							if(strtolower(userinfo()->gender) == "perempuan")
							$pict = sourceUrl()."/img/woman.png";
							else
							$pict = sourceUrl()."/img/man.png";
							
						}else $pict = sourceUrl()."/usr_pict/".userinfo()->profile_pict;

						?>
						<img src="<?php echo $pict?>" style="border-radius: 100%;position:relative;margin-top:-15px;width: 33px;height: 33px;margin-right: 10px;" >
						<p style="text-align: center;margin-top: 2px;font-size: 12px;color:#434343">Profile</p>

					<?php }else{ ?>
						<img src="<?php echo sourceUrl()."/media/users.png"?>" style="border-radius: 100%;position:relative;margin-top:-15px;width: 28px;height: 28px;margin-right: 10px;" >
						<p style="text-align: center;margin-top: 2px;font-size: 12px;color:#434343">Login</p>
					<?php } ?>

				</a>
			</td>
		</tr>
	</table>
	
</div>

<div style="height: 25px;"></div>
<script src="<?php echo HomeUrl() ?>/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo HomeUrl() ?>/js/clientarea.js"></script>
<script>

	$(document).ready(function(){

		$(".left-sidebar").css({

			"height" : $(window).height()-$("#t-nav").height()-$("#b-nav").height()-40+"px",
			"top" : $("#t-nav").height()+15+"px"

		});

		$(".cbx").click(function(){

			$(".cbx").prop("checked",false);
			$(".cbx").removeAttr("required");
			$(this).prop("checked",true);
			$(this).attr("required","true");

		});

		$("[type='checkbox']").attr("required","true");
		$(".dompet_digital").removeAttr("required");
	
	<?php
	if(splice(2) == "detail_komplein"){ ?>

			$(".list-data").click();
			real_time_chat_data();
			show_typing_alert();
			hide_typing_alert();
	

	<?php } ?>

	set_online();

	});
	
	function check_char(obj){

			var text = $(obj).val().length;

			switch($(obj).attr("id")){

				case "username":

					if(text < 6){
						
						$("#username").css({"border" : "1px #ff0000 solid"});
						$("#alert-username").show();
						$("#alert-username").html("Minimal 8 Karakter");

					}else if(text > 12){

						$("#username").css({"border" : "1px #ff0000 solid"});
						$("#alert-username").show();
						$("#alert-username").html("Maksimal 12 Karakter");

					}else{

						$("#username").css({"border" : ""});
						$("#alert-username").hide();
						$("#alert-username").html("");

					}

				break;

				case "password":

					if(text < 6){
						
						$("#password").css({"border" : "1px #ff0000 solid"});
						$("#alert-password").show();
						$("#alert-password").html("Minimal 8 Karakter");

					}else if(text > 12){

						$("#password").css({"border" : "1px #ff0000 solid"});
						$("#alert-password").show();
						$("#alert-password").html("Maksimal 12 Karakter");

					}else{

						$("#password").css({"border" : ""});
						$("#alert-password").hide();
						$("#alert-password").html("");

					}

				break;

				case "repassword":

					if(text < 6){
						
						$("#repassword").css({"border" : "1px #ff0000 solid"});
						$("#alert-repassword").show();
						$("#alert-repassword").html("Minimal 8 Karakter");

					}else if(text > 12){

						$("#repassword").css({"border" : "1px #ff0000 solid"});
						$("#alert-repassword").show();
						$("#alert-repassword").html("Maksimal 12 Karakter");

					}else{

						if($("#repassword").val() !== $("#password").val()){
							$("#password").css({
								"border" : "1px #ff0000 solid",
								"background" : "#ebc2b9"
							});
							
							$("#repassword").css({
								"border" : "1px #ff0000 solid",
								"background" : "#ebc2b9"
							});
							
							$("#alert-repassword").hide();
							$("#alert-repassword").html("");

							

						}else{
							$("#password").css({
								"border" : "1px #53a65e solid",
								"background" : "#a2dbaa"
							});

							$("#repassword").css({
								"border" : "1px #53a65e solid",
								"background" : "#a2dbaa"
							});

							$("#alert-repassword").hide();
							$("#alert-repassword").html("");

							
						}
						
					}

				break;

			}

			

		}

		function verif(obj){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/adminpanel/verif_mail_code",
				data: {
					verifikasi : $(obj).val(),
					type : "1"
				},
				success : function(event){


					if($(obj).val() == ""){

						$(obj).css({
							"border" : "1px #ddd solid",
							"background" : "#fff"
						});

					}else{

						if(event.indexOf("<true/>") !== -1){

							$(obj).css({
									"border" : "1px #53a65e solid",
									"background" : "#a2dbaa"
							});

						}else{

							$(obj).css({
									"border" : "1px #ff0000 solid",
									"background" : "#ebc2b9"
							});

						}
					}
							
				}

			});

		}


		function send_code(a){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/adminpanel/verif_mail",
				beforeSend : function(){

					$(a).html("Mengirim..");

				},
				success : function(){
					alert("Silahkan Cek pada Email lama Anda");
					$(a).html("Kirim Kode");
				}

			});

		}


		function real_time_chat_data(){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/adminpanel/chat_list",
				data: {type:"reload",room:$(".room").val(),user_id:$(".uid").val()},

				success : function(event){
					if(event.indexOf("<reload/>") !== -1){
						$("#chat-data-list").append(event);
						$('#chat-list').scrollTop($('#chat-list')[0].scrollHeight);
					}

					setTimeout(function(){
						real_time_chat_data();
					},3500);
				}

			});

		}

		function typing_send(){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/adminpanel/chat_list",
				data: {type:"send_typing",room:$(".room").val(),user_id:$(".uid").val(),typing:"1"},

				success : function(event){
					
					setTimeout(function(){

						hide_typing_send();

					},3500);

				}

			});

		}

		function hide_typing_send(){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/adminpanel/chat_list",
				data: {type:"send_typing",room:$(".room").val(),user_id:$(".uid").val(),typing:"0"},

				success : function(event){
					
				}

			});

		}

		function show_typing_alert(){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/adminpanel/chat_list",
				data: {type:"typing",room:$(".room").val(),user_id:$(".uid").val()},

				success : function(event){

					if(event.indexOf("<false/>") == -1){
						
						var element = event.split("/");

						for(var i = 0; i < element.length;i++){

							var s_el = element[i].split("|");
							$("."+s_el[1]).hide();
							$("."+s_el[0]).html("Under typing ...");
							$("."+s_el[0]).show();


						}

						
					}


					setTimeout(function(){
						show_typing_alert();
					},3500);
					
				}

			});

		}

		function set_online(){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/adminpanel/set_online?id=<?php echo $this->get("id")?>&splice=<?php echo splice(2)?>",
				success : function(event){
					$("head").append(event);
					setTimeout(function(){

						set_online();

					},5000);

				}
			});

		}

		function verif_refund(){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/clientarea/verif_refund",
				success : function(event){
					
					alert("Kode terkirim, silahkan cek email anda.");

				}
			});

		}

		function hide_typing_alert(){

			$.ajax({

				type : "POST",
				url : "<?php echo HomeUrl()?>/adminpanel/chat_list",
				data: {type:"hide_typing",room:$(".room").val(),user_id:$(".uid").val()},

				success : function(event){

					if(event.indexOf("<false/>") == -1){
						
						var element = event.split("/");

						for(var i = 0; i < element.length;i++){

							var s_el = element[i].split("|");
							$("."+s_el[1]).show();
							$("."+s_el[0]).html("Under typing ...");
							$("."+s_el[0]).delay(1000).hide();

						}
						
					}

					setTimeout(function(){
						hide_typing_alert();
					},3500);
					
				}

			});

		}

		function select_bank(obj){

			$(".picture-bank").css({

				"border" : "1px #ddd solid"

			});

			$(obj).css({

				"border" : "6px orangered solid"

			});

			$("#bank-info").val($(obj).attr("data"));
		}
		function open_menu(){

		if($(".left-sidebar").css("display") == "none"){

			$(".left-sidebar").show();

		}else{

			$(".left-sidebar").hide();

		}

	}

	function show_add_rek(id){

			if(id == "1"){
				$(".add-rekening").show();
				$(".select-rekening").hide();
				$(".add-rekening input").attr("required","true");
				$(".select-rekening select").removeAttr("name");
				$(".add-rekening input").slice(0).attr("name","bank_name");
				$(".add-rekening input").slice(1).attr("name","rekening_number");
				$(".add-rekening input").slice(2).attr("name","card_name");
			}else{
				$(".add-rekening").hide();
				$(".select-rekening").show();
				$(".add-rekening input").val("");
				$(".add-rekening input").removeAttr("required");
				$(".select-rekening select").attr("name","bank_info");
				$(".add-rekening input").removeAttr("name");
			}

		}


</script>
</body>