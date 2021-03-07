<!DOCTYPE html>
<html>
<head>
	<title><?php echo strip_tags(ucwords(str_replace(["_","'"]," ",splice(2))))?> | <?php echo ucwords(setting()->title)?></title>
	<link rel="stylesheet" href="<?php echo HomeUrl() ?>/css/clientarea.css" />
	<link rel="base-url" id="base-url" href="<?php echo HomeUrl()?>" />
	<link rel="shortcut icon" href="<?php echo setting()->icon?>">
</head>
<body>
	
	{navbar-menu}

	<div class="container">
		
		{sidebar-menu}

		<div class="admin-content" style="margin-bottom: 40px;">
			
			{navurl-menu}

			{home-content}

		</div>

	</div>
>
<script src="<?php echo HomeUrl() ?>/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo HomeUrl() ?>/js/clientarea.js"></script>
<script>

	$(document).ready(function(){

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