<div class="navbar">
		<div class="container">
			<div class="left-content"><a href="<?php echo HomeUrl()?>"><img src="<?php echo setting()->logo?>" style="height:30px;"></a>

			
			</div>
			<div class="right-content" style="width: 600px;">

				<?php

				if(empty(userinfo()->profile_pict) or (userinfo()->profile_pict == "")) {

						if(strtolower(userinfo()->gender) == "perempuan")
						$pict = sourceUrl()."/img/woman.png";
						else
						$pict = sourceUrl()."/img/man.png";
						
					}else $pict = sourceUrl()."/usr_pict/".userinfo()->profile_pict;

				?>

		
				<div class="userinfo-info" style="margin-top: -20px;color:#666">
					

				<a href="<?php echo HomeUrl()?>/adminpanel/logout" style="color:#434343">
					<p class="nav-menu-right">
						<img src="<?php echo sourceUrl()?>/media/logout.png" style="width: 23px;height: 23px;position: absolute;margin-top:-3px;margin-left:-30px;box-shadow: none;border-radius: 0px;cursor:pointer;" > Logout
					</p>
				</a>

				<a href="<?php echo HomeUrl()?>/adminpanel/profileset" style="color:#434343">
					<p class="nav-menu-right" style="margin-right: 45px;">
						<img src="<?php echo sourceUrl()?>/media/cog.png" style="width: 25px;height: 25px;position: absolute;margin-top:-3px;margin-left:-30px;box-shadow: none;border-radius: 0px;cursor:pointer;" > Profile Setting

					</p>
				</a>

				<a href="<?php echo HomeUrl()?>/adminpanel/profile" style="color:#434343">
					<p class="nav-menu-right" style="margin-right: 45px;">
						<img src="<?php echo $pict?>" style="width: 25px;height: 25px;position: absolute;margin-top:-3px;margin-left:-30px;box-shadow: none;border-radius: 100%;cursor:pointer;" > <?php echo ucwords(userinfo()->first_name." ".userinfo()->last_name)?>
					</p>
				</a>

				</div>


				

			</div>
		</div>
	</div>