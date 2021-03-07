<!DOCTYPE html>
<html>
<head>

	<title><?php echo ucwords(str_replace("_"," ",splice(2))) ?> > <?php echo setting()->title?></title>
	<link rel="stylesheet" href="<?php echo HomeUrl() ?>/css/admin-mobile.css" />
	<link rel="base-url" id="base-url" href="<?php echo HomeUrl()?>" />
	<link rel="shortcut icon" href="<?php echo setting()->icon?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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


<div class="newsletter" style=";background: #fff;border-top:1px #ccc solid;border-bottom:1px #ccc solid;padding-top:10px;margin-top: 20px;padding-bottom:20px;">
		
			
			
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

	<div class="footer" style="background: #fff;margin-top: -10px;padding:0px;">
			
				
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


<script src="<?php echo HomeUrl() ?>/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo HomeUrl() ?>/js/admin.js"></script>
<script src="<?php echo sourceUrl() ?>/js/tinymce/js/tinymce/tinymce.js"></script>

<style>
	.mceu_31{
		width: 500px;
	}
</style>

<script>

	


	$(document).ready(function(){

		$(".left-sidebar").css({

			"height" : $(window).height()-$("#t-nav").height()-36+"px"

		});

		$(".cbx").click(function(){

			$(".cbx").prop("checked",false);
			$(this).prop("checked",true);
		});


		$("#cat-sel").change(function(){

			if($(this).val() == "None"){

				$("#img-cat").show();

			}else{
				$("#img-cat").hide();
			}

			return false;
		});
	
	<?php 

		if(!empty($this->get("chat_to"))){ 

			if(!empty($this->get("id"))) $click = $this->get("chat_to")."-".$this->get("id");
			else $click = $this->get("chat_to");

		?>
			$("#<?php echo $click ?>").click();
		

	<?php } if(splice(2) == "message"){ ?>

			real_time_chat_data();
			show_typing_alert();
			hide_typing_alert();
	

	<?php } ?>

	set_online();

	});

	function open_menu(){

		if($(".left-sidebar").css("display") == "none"){

			$(".left-sidebar").show();

		}else{

			$(".left-sidebar").hide();

		}

	}


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
				data : {
					email : $("#email").val()
				},
				beforeSend : function(){

					$(a).html("Mengirim..");

				},
				success : function(){
					alert("Silahkan Cek pada Email anda");
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
				url : "<?php echo HomeUrl()?>/adminpanel/set_online",
				success : function(event){

					setTimeout(function(){

						set_online();

					},5000);

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




	tinymce.init({
	  selector: '.textarea',
	  plugins: ['autolink','image','link','lists','hr','paste','image','media','contextmenu','code','responsivefilemanager'],
	  codesample_languages: [
	        {text: 'HTML/XML', value: 'markup'},
	        {text: 'JavaScript', value: 'javascript'},
	        {text: 'CSS', value: 'css'},
	        {text: 'PHP', value: 'php'},
	        {text: 'OTHER', value: 'php'},
	        
	    ],
	  paste_as_text: true,
	  
	  toolbar: ['bold italic underline | numlist bullist | codesample | link image media | responsivefilemanager | code'],
	  default_link_target: "_blank",
	  external_filemanager_path:"../sources/js/responsive_filemanager/filemanager/",
	  filemanager_title:"<?php echo setting()->title?> Galery" ,
	  // external_plugins: { "filemanager" : "/koi/sources/js/responsive_filemanager/filemanager/plugin.min.js"}
	  // setup: function (editor) {
	  // 	 editor.save();
	  //    editor.on('keyup', function () {
	  //     	delay(function(){ 
	  //     		$.ajax({
	  //           type : "POST",
	  //           url  :  "/draft",
	  //           data : {
	  //           	draft : "true",
	  //           	act : "description_step",
	  //           	content : editor.getContent(),
	  //           	forstep : $("#"+editor.id).attr("steps"),
	  //           },
	  //           success : function(event){
	  //               console.log("draft");        
	  //               $.get("/draft/reload");        
	  //           }
	  //       });
	  //       },500);
	  //   });
	  // 	}
	   });

		function role_access(a){
		if($(a).val() == "Admin") $(".role-access").show();
		else $(".role-access").hide();
	}

	$("input[value=0],input[value=1],input[value=2],input[value=3]").click(function(){

		var  el = $(this).attr("name");
			 el = el.replace("[]","");

		var data = ["blog", "custom", "product", "category", "bank", "user"];

		var value = $(this).val();

		if(value == "0"){
		
			if ($(this).is(':checked')) {

				$("input[name*="+el+"][value!=0]").prop("checked",true);

			}else{

				$("input[name*="+el+"][value!=0]").prop("checked",false);

			}

		}else{

			var number = 0;

			for(var i = 1; i <=3 ; i++){

				if ($("input[name*="+el+"][value="+i+"]").is(':checked')) {

					var check_val = parseInt($("input[name*="+el+"][value="+i+"]").val());

					number += check_val;

				}

			}

			if(number >= 6){

				$("input[name*="+el+"][value=0]").prop("checked",true);

			}else{
				
				$("input[name*="+el+"][value=0]").prop("checked",false);				

			}

		}
	});

	$(document).ready(function(){

		var data = ["blog", "custom", "product", "category", "bank", "user"];

		for(var num = 0; num < data.length; num++){

			var number = 0;

			for(var i = 1; i <=3 ; i++){

				if ($("input[name*="+data[num]+"][value="+i+"]").is(':checked')) {

					var check_val = parseInt($("input[name*="+data[num]+"][value="+i+"]").val());

					number += check_val;

				}

			}


			if(number >= 6){

				$("input[name*="+data[num]+"][value=0]").prop("checked",true);
				console.log(data[num]);

			}else{
				
				$("input[name*="+data[num]+"][value=0]").prop("checked",false);				

			}

		}

	});

	
</script>
</body>
</html>