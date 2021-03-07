<body>

<div class="super_container">
	<!-- Header -->
	<header class="header trans_300" >

		<!-- Main Navigation -->

		<div class="main_nav_container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-right">

					<?php if(splice(1) == "blog") $link = "blog";
					else $link = "search";
					?>

					<form method="GET" action="<?php echo HomeUrl()?>/<?php echo $link?>">
						<div class="logo_container">
							<a href="<?php echo HomeUrl()?>"><img src="<?php echo setting()->logo?>" height="35"></a>

							
							<?php if(splice(1) == "blog"){ ?>
							<input type="text" style="border:1px #ddd solid;padding:5px;border-radius: 10px;margin-left:20px;width: 350px;" placeholder="Cari artikel <?php echo setting()->title?>" value="<?php echo strip_tags(urldecode(htmlspecialchars_decode($this->get("q"))))?>" name="q">
							<?php }else{ ?>
							<input type="text" style="border:1px #ddd solid;padding:5px;border-radius: 10px;margin-left:20px;width: 350px;" placeholder="Cari produk <?php echo setting()->title?>" value="<?php echo strip_tags(urldecode(htmlspecialchars_decode($this->get("q"))))?>" name="q">
							<?php } ?>

							<button style="background: #f9f9f9;margin-left:-38px;padding: 4px;border: transparent;position: relative;top:-1px;border-radius:0 10px 10px 0;border-left: 1px #ddd solid;border-right: 1px #ddd solid;cursor: pointer;">
							<img src="<?php echo sourceUrl()."/media/search.png"?>" style="width:25px;">
							</button>
						


							<ul class="product_sorting">
										<li style="width: auto;border:transparent;width: 120px;text-align: left;">
											<span class="type_sorting_text">Category </span>
											<i class="fa fa-angle-down" style="margin-left: 10px;"></i>
											<ul class="sorting_type" style="border:1px #ddd solid;border-radius: 10px;margin-top:10px;padding-top: 10px;width:150px;">

												<?php 
												$query = $this->db()->query("SELECT * FROM db_category WHERE level=0");
												while($show = $query->fetch()){ ?>
												<li class="type_sorting_btn" style="text-align:left;">
													<p><a href="<?php echo HomeUrl()?>/<?php echo url_title($show['title'],"-",true)?>" style="border-bottom: transparent;font-size:13px;font-weight: 400"><img src="<?php echo sourceUrl()."/media/c-right.png"?>" style="width:8px;border-radius: 100%;margin-right: 10px;"><?php echo $show['title']?></a></p>
												</li>
												<?php } ?>
											</ul>
										</li>
									</ul>
						</div>
					</form>
						<nav class="navbar" style="margin-top: -15px;">
							<!-- <ul class="navbar_menu">
								<li><a href="index.html">home</a></li>
								<li><a href="#">blog</a></li>
								<li><a href="contact.html">contact</a></li>
							</ul> -->

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

							<a href="<?php echo HomeUrl()?>/<?php echo $url1?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%">
								<img src="<?php echo sourceUrl()?>/media/bell.png" style="width:25px;">

								<?php if(alert_notification() > 0) { ?>
								<span id="checkout_items" class="checkout_items" style="font-size: 10px;width: 15px;height: 15px;margin-top: 8px;"><?php echo alert_notification()?></span>
								<?php } ?>
							</a>

							<?php if((userinfo() !== false) and (userinfo()->level < 2)){ ?>

							<a href="<?php echo HomeUrl()?>/<?php echo $url2?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%">
								<img src="<?php echo sourceUrl()?>/media/love.png" style="width:20px;">
							</a>

							<a href="<?php echo HomeUrl()?>/<?php echo $url3?>" style="position:relative;top:10px;padding: 8px;padding-top: 2px;border-radius: 100%;margin-right: 50px;">
								<img src="<?php echo sourceUrl()?>/img/cart.png" style="width:25px;">

								<?php if($this->total_cart() > 0){ ?>
								<span id="checkout_items" class="checkout_items" style="font-size: 10px;width: 15px;height: 15px;margin-top: 5px;"><?php echo $this->total_cart()?></span>

								<?php } ?>
							</a>
							
							<?php } ?>

							<?php 

								if(userinfo() !== false){

									if(empty(userinfo()->profile_pict) or (userinfo()->profile_pict == "")) {

										if(strtolower(userinfo()->gender) == "perempuan")
										$pict = sourceUrl()."/img/woman.png";
										else
										$pict = sourceUrl()."/img/man.png";
										
									}else $pict = sourceUrl()."/usr_pict/".userinfo()->profile_pict;

									$name = stringLimit(ucwords(userinfo()->first_name),14,"");

								}

								?>


							<ul class="product_sorting">
										<li style="width: auto;border:transparent;width: auto;text-align: left;">
											<a href="<?php echo HomeUrl()?>/<?php echo $url4?>">
											<span class="type_sorting_text" style="text-align: left;">

												<?php if(userinfo() !== false){ ?>
												<img src="<?php echo $pict?>" style="border-radius: 100%;position:relative;top:5px;width: 28px;height: 28px;margin-right: 10px;" >
												<span style="position: relative;top: 6px;color:#666;margin-left: 0px;"><?php echo $name?></span>

											<?php }else{ ?>
												<a href="<?php echo HomeUrl()?>/login" style="background: #fe4c50;color:#fff;padding:6px;border-radius: 5px;position: relative;top:7px;">Login Pengguna</a>
											<?php } ?>

											</span>

										</a>

										<?php if(userinfo() !== false){ ?>
											<i class="fa fa-angle-down" style="margin-left: 10px;position: relative;top: 5px;"></i>
											<ul class="sorting_type" style="border:1px #ddd solid;width: 300px;border-radius: 10px;margin-top:10px;">

												<li class="type_sorting_btn" style="padding: 10px;">
													<table style="width: 100%">
														<tr>
															<td style="width: 69px;" valign="top">
																<img src="<?php echo $pict?>" style="border-radius: 100%;border:1px #ddd solid;position:relative;top:5px;width: 62px;height: 62px;margin-right: 10px;" >
															</td>
															<td valign="top">
																<p style="text-align: left;">
																	<a href="<?php echo HomeUrl()?>/<?php echo $url4?>" style="border-bottom: transparent;"><?php echo ucwords(userinfo()->first_name." ".userinfo()->last_name)?></a></p>
																<p style="text-align: left;font-size: 12px;font-weight: 400;margin-top: -10px;color:#666">

																	<img src="<?php echo sourceUrl()?>/media/mark.png" width="12" style="margin-right:10px">
																	<?php echo userinfo()->province?>
																</p>
																<p style="text-align: left;font-size: 12px;font-weight: 400;margin-top: -15px;color:#09f">

																	<img src="<?php echo sourceUrl()?>/media/surat.png" width="12" style="margin-right:10px">
																	<?php echo stringLimit(userinfo()->email,20," ...")?>
																</p>

																<p style="border-top:2px #ddd dashed;" >
																	<p style="text-align: left;font-size: 13px;font-weight: 400;margin-top: -10px;"><a href="<?php echo HomeUrl()?>/<?php echo $url4?>" style="border-bottom: transparent;">Lihat Profile</a></p>

																	<p style="text-align: left;font-size: 13px;font-weight: 400;margin-top: -15px;color:#666"><a href="<?php echo HomeUrl()?>/<?php echo $url5?>" style="border-bottom: transparent;">Halaman <?php echo (userinfo()->level > 1)? "Admin" : "Client"?></a></p>

																	<p style="text-align: left;font-size: 13px;font-weight: 400;margin-top: -15px;color:#666"><a href="<?php echo HomeUrl()?>/<?php echo $url6?>" style="border-bottom: transparent;">Pengaturan</a></p>
																</p>
																<p><a href="<?php echo HomeUrl()."/adminpanel/logout"?>"><button style="width: 100%;text-shadow: rgba(0,0,0,.01) 0 0 1px;border:1px #fe4c50 solid;color:#fff;font-weight:600;padding: 5px;background: #fe4c50;border-radius: 10px;cursor:pointer">Keluar</button></a></p>
															</td>
														</tr>
														
													</table>
												</li>
											</ul>
										<?php } ?>
										</li>
									</ul>

							<div class="hamburger_container">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>

	</header>

	<div class="fs_menu_overlay"></div>