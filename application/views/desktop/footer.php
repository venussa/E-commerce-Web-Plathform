	</div>
	<!-- Newsletter -->

	<div class="newsletter" style="background: #fff;border-top:1px #ddd solid;padding-top:20px;">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="newsletter_text d-flex flex-column justify-content-center align-items-lg-start align-items-md-center text-center">
						<p style="font-size: 20px;">Bank Transfer</p>
						<p style="margin-top: 15px;margin-bottom: 10px;">
							<?php 
							$query = $this->db()->query("SELECT * FROM db_pay_info");
							while($show = $query->fetch()){?>
								<img src="<?php echo HomeUrl()."/bank/".$show['icon']?>" style="width: 100px;height:50px;border-radius: 3px;border:1px #ddd solid;margin-right: 10px;background: #fff;">
							<?php } ?>
						</p>
					</div>
				</div>
		
			</div>
		</div>
	</div>

	<!-- Footer -->

	<footer class="footer" style="margin-bottom:-100px;background: #fff;">
		<div class="container" style="height: 180px;overflow: hidden;">
			<div class="row">
				<div class="col-lg-9">
					<div class="footer_nav_container d-flex flex-sm-row flex-column align-items-center justify-content-lg-start justify-content-center text-center">
						<ul class="footer_nav">
							<?php

							$query = $this->db()->query("SELECT * FROM db_custom_page WHERE status=1 and level=0 ORDER BY position ASC");

							while($show = $query->fetch()){	?>
							
								<li style="margin-right: 15px;"><a href="<?php echo HomeUrl()?>/<?php echo $show['slug']?>"><?php echo $show['title']?></a></li>

							<?php } ?>
							<li style="margin-right: 15px;"><a href="<?php echo HomeUrl()?>/blog">Blog's</a></li>
							<li style="margin-right: 15px;"><a href="<?php echo HomeUrl()?>/sitemap/sitemap.xml">Sitemap</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3">
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
				</div>
			</div>



			<div class="row">
				<div class="col-lg-12">
					<div class="footer_nav_container">
						<div class="cr">©<?php echo date("Y")?> <?php echo setting()->title?>. All Rights Reserverd.</div>
					</div>
				</div>
			</div>
		</div>
	</footer>



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


</script>
<input type="text" value="<?php echo documentUrl()?>" class="my-link" style="background: transparent;color: transparent;border: transparent;position: absolute;">
</body>

</html>