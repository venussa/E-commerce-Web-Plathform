	</div>
	<!-- Newsletter -->

	<div class="newsletter" style="background: #fff;border-top:1px #ddd solid;border-bottom:1px #ddd solid;padding-top:10px;margin-top: 0px;padding-bottom:20px;">
		
			
			
					<div class="newsletter_text d-flex flex-column justify-content-center align-items-lg-start align-items-md-center text-center">
						<p style="font-size: 15px;">Bank Transfer</p>
						<p style="margin-top: 15px;margin-bottom: 10px;">
							<?php 
							$query = $this->db()->query("SELECT * FROM db_pay_info");
							while($show = $query->fetch()){?>
								<img src="<?php echo HomeUrl()."/bank/".$show['icon']?>" style="width: 50px;height:25px;border-radius: 3px;border:1px #ddd solid;margin-right: 10px;background: #fff;">
							<?php } ?>
						</p>
					</div>
	
		
	
	
	</div>

	<!-- Footer -->

	<footer class="footer" style="margin-bottom:80px;background: #fff;margin-top: -35px;">
			
				
					<div class="footer_nav_container d-flex flex-sm-row flex-column align-items-center justify-content-lg-start justify-content-center text-center" style="">
						<ul class="footer_nav" style="width: 100%">
							<?php

							$query = $this->db()->query("SELECT * FROM db_custom_page WHERE status=1 and level=0 ORDER BY position ASC");

							while($show = $query->fetch()){	?>
							
								<li style="margin-right: 15px;border-bottom: 1px #ddd solid;width: 100%;"><a style="font-size: 13px;" href="<?php echo HomeUrl()?>/<?php echo $show['slug']?>"><?php echo $show['title']?></a></li>

							<?php } ?>
							<li style="margin-right: 15px;border-bottom: 1px #ddd solid;width: 100%;"><a style="font-size: 13px;" href="<?php echo HomeUrl()?>/blog">Blog's</a></li>
							<li style="margin-right: 15px;border-bottom: 1px #ddd solid;width: 100%;"><a style="font-size: 13px;" href="<?php echo HomeUrl()?>/sitemap/sitemap.xml">Sitemap</a></li>
						</ul>
					</div>
				
					<div class="footer_social d-flex flex-row align-items-center justify-content-lg-end justify-content-center">
						<ul>
							<li><a href="<?php echo setting()->facebook?>" target="_blank">
							<img src="<?php echo sourceUrl()?>/media/fb.png" style="width:20px;height:20px;border-radius: 5px;">
							</a></li>
							<li><a href="<?php echo setting()->twitter?>" target="_blank">
							<img src="<?php echo sourceUrl()?>/media/tw.png" style="width:20px;height:20px;border-radius: 5px;">
							</a></li>

							<li><a href="<?php echo setting()->instagram?>" target="_blank">
							<img src="<?php echo sourceUrl()?>/media/ig.png" style="width:20px;height:20px;border-radius: 5px;">
							</a></li>
						</ul>
					</div>
			
			



			<div style="margin-top:0px">
				<div class="cr" style="text-align: center;">©<?php echo date("Y")?> <?php echo setting()->title?>. All Rights Reserverd.</div>
			</div>
	
	</footer>


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

<div id="b-nav" style="width: 100%;position: fixed;background: #fff;padding: 10px;padding-bottom:0px;bottom:0px;border-top:1px #ddd solid;z-index: 999;-webkit-box-shadow: 0px -1px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 0px -1px 6px 1px rgba(0,0,0,0.2);
box-shadow: 0px -1px 6px 1px rgba(0,0,0,0.2);">
	<table width="100%" style="margin-bottom: -14px;">
		<tr>
			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%">
					<img src="<?php echo sourceUrl()?>/media/home.png" style="width:25px;height: 25px;margin-top:-11px;">
					<p style="text-align: center;margin-top: 10px;padding-left: 5px;font-size: 12px;">Home</p>
				</a>
			</td>

			<?php 
			$query = $this->db()->query("SELECT * FROM db_category WHERE level=0 ORDER BY rand() LIMIT 1");
			$category = $query->fetch();

			?>

			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>/<?php echo url_title($category['title'],"-",true)?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%">
					<img src="<?php echo sourceUrl()?>/media/kategori.png" style="width:27px;height: 27px;margin-top:-11px;">
					<p style="text-align: center;margin-top: 10px;padding-left: 5px;font-size: 12px;">Kategori</p>
				</a>
			</td>

			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>/<?php echo $url2?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%">
					<img src="<?php echo sourceUrl()?>/media/love.png" style="width:25px;height: 25px;margin-top:-10px;">
					<p style="text-align: center;margin-top: 10px;padding-left: 5px;font-size: 12px;">Ditandai</p>
				</a>
			</td>
			<td style="text-align: center;width: 20%">
				<a href="<?php echo HomeUrl()?>/<?php echo $url3?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%;">
					<?php if($this->total_cart() > 0){ ?>
					<span id="checkout_items" class="checkout_items" style="font-size: 10px;width: 15px;height: 15px;margin-top: 5px;"><?php echo $this->total_cart()?></span>

					<?php } ?>
					<img src="<?php echo sourceUrl()?>/img/cart.png" style="width:26px;height: 26px;margin-top: -10px;">
					<p style="text-align: center;margin-top: 10px;padding-left: 5px;font-size: 12px;">Keranjang</p>

					
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
						<p style="text-align: center;margin-top: 9px;font-size: 12px;">Profile</p>

					<?php }else{ ?>
						<img src="<?php echo sourceUrl()."/media/users.png"?>" style="border-radius: 100%;position:relative;margin-top:-15px;width: 28px;height: 28px;margin-right: 10px;" >
						<p style="text-align: center;margin-top: 9px;font-size: 12px;">Login</p>
					<?php } ?>

				</a>
			</td>
		</tr>
	</table>
	

	
</div>

<script src="<?php echo sourceUrl()?>/themplate/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo sourceUrl()?>/themplate/styles/bootstrap4/popper.js"></script>
<script src="<?php echo sourceUrl()?>/themplate/styles/bootstrap4/bootstrap.min.js"></script>
<script src="<?php echo sourceUrl()?>/themplate/plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="<?php echo sourceUrl()?>/themplate/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="<?php echo sourceUrl()?>/themplate/plugins/easing/easing.js"></script>
<script src="<?php echo sourceUrl()?>/themplate/plugins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="<?php echo sourceUrl()?>/themplate/js/single_custom.js"></script>
<script src="<?php echo sourceUrl()?>/js/swipper/js/swiper.min.js"></script>

<script>

	var delay = (function(){
	  var timer = 0;
	  return function(callback, ms){
	    clearTimeout (timer);
	    timer = setTimeout(callback, ms);
	  };
	})();
	
	function select_location(obj){

		delay(function(){
			
			$.ajax({

				type : "post",
				url : "<?php echo HomeUrl()?>/handler/location",
				data : {
					q : $(obj).val()
				},
				success : function(event){

					$("#data-location").html(event);

				}

			});

		},700);

		return false;

	}

	<?php if(!empty($this->get("id"))){ ?>

	function get_price(obj){

		$(".loc-name").html($(obj).attr("name"));

		$.ajax({

			type : "post",
			url : "<?php echo HomeUrl()?>/handler/location?price=true",
			data : {
				q : $(obj).attr("loc_id"),
				w : <?php echo ($this->get_product(true) == true) ? $this->get_product()->weight : "0";?>
			},
			success : function(event){

				$("#predict-price").html(event);

			}

		});

	}

	<?php } ?>

	function update_order(obj){

		delay(function(){
		var data = $("#quantity_value").html();
		$("#total-order").val(data);
		},300);

	}

	function favourit(obj){

		$.ajax({

			type : "post",
			url : "<?php echo HomeUrl()?>/handler/whitelist",
			data : {
				id : $(obj).attr("p_id")
			},
			success : function(event){

				if(event.indexOf("<add/>") !== -1){

					$(obj).addClass("active");

				}else{

					$(obj).removeClass("active");

				}

				

			}

		});

	}

	function number_format (number, decimals, dec_point, thousands_sep) {
	    // Strip all characters but numerical ones.
	    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	    var n = !isFinite(+number) ? 0 : +number,
	        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	        s = '',
	        toFixedFix = function (n, prec) {
	            var k = Math.pow(10, prec);
	            return '' + Math.round(n * k) / k;
	        };
	    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	    if (s[0].length > 3) {
	        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	    }
	    if ((s[1] || '').length < prec) {
	        s[1] = s[1] || '';
	        s[1] += new Array(prec - s[1].length + 1).join('0');
	    }
	    return s.join(dec);
	}

	function copy_link() {
		/* Get the text field */
		var copyText = document.getElementsByClassName("my-link")[0];

		/* Select the text field */
		copyText.select();
		copyText.setSelectionRange(0, 99999); /*For mobile devices*/

		/* Copy the text inside the text field */
		document.execCommand("copy");

		/* Alert the copied text */
		alert("Url Berhasil Disalin");
		} 

	function typing(obj){

		if($(obj).val() != ""){

			var data = $(obj).val();
				data = data.replace(/\D/g,'');
				data = number_format(data);
			
			$(obj).val(data);
		}

		var v1 = $("#start_price").val().replace(",","").replace(".","").replace(",","");
		var v2 = $("#end_price").val().replace(",","").replace(".","").replace(",","");

		var build = "";

		if((v1 !== "") && (v2 !== "")){

			delay(function(){

				var url = $("#doc_active").val();

				var data_url = url.split("?");

				var data_var = data_url[1].split("&");

				var price1 = url.split("start_price=");
				var price2 = url.split("end_price=");

				if(data_var.length > 1){

					for(var i = 0; i < data_var.length; i++){

						var var_split = data_var[i].split("=");

						if(i == (data_var.length - 1)) var simbol = "";
						else simbol = "&";

						if(var_split[0] == "start_price")
						build += var_split[0]+"="+v1+simbol;
						else if(var_split[0] == "end_price")
						build += var_split[0]+"="+v2+simbol;
						else if(var_split[0] !== "")
						build += var_split[0]+"="+var_split[1]+simbol;

					}

					if((price1.length <= 1) && (price2.length <= 1)){

						build += "&start_price="+v1+"&";
						build += "end_price="+v2;

					}

				}else{

					var sb = data_url[1].split("=");

					if(sb[0] == "q"){
					build += "q="+sb[1]+"&";
					build += "start_price="+v1+"&";
					build += "end_price="+v2;
					}else{
					build += "sub_category="+sb[1]+"&";
					build += "start_price="+v1+"&";
					build += "end_price="+v2;
					}

				}

				window.location=data_url[0]+"?"+build;

			},2000);

		}

	}

    var swiper = new Swiper('.swiper-container', {

      speed: 600,
      parallax: true,
      spaceBetween: 30,
      slidesPerView: 1,
      autoplay: {
        delay: 2500,
        disableOnInteraction: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      }
    });

    $(document).ready(function(){
    	var w = ($(".conts li").width()+30) * $(".conts li").length;
    	$(".conts").css({"width":w+"px"});


    	var w = ($(".cat-list-pro li").width()) * $(".cat-list-pro li").length; 
    	$(".cat-list-pro").css({"width":w+"px"});

    	var limit = $("#b-nav").height() + $("#t-nav").height();
    	var w_height = $(window).height() - limit;
    	$("#filter-search").css({

    		"top" : ($("#t-nav").height() + 20)+"px",
    		"height" : (w_height+30)+"px"

    	});
    });

    function menu_collapse(id){

    	if(id == 1){
    		$("#filt-1").show();
    		$("#filt-2").hide();
    	}

    	if(id == 2){
    		$("#filt-1").hide();
    		$("#filt-2").show();
    	}

    	if($("#filter-search").css("display") == "none"){

    		$("#filter-search").show();

    	}else{
			
			$("#filter-search").hide();

    	}

    }

</script>
<input type="text" value="<?php echo documentUrl()?>" class="my-link" style="background: transparent;color: transparent;border: transparent;position: absolute;">
</body>

</html>