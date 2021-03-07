
<?php if(userinfo()->username == $this->get("q")){

	echo "<script>window.location='".HomeUrl()."/adminpanel/profile';</script>";
	exit;

}?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Halaman user adalah halaman untuk memanagement user yang dapat mengakses halaman ini dengan memberikannya hak akses tertentu yaitu customer, suplier, dan administrator. Jika status user adalah <b>On</b>, maka user dapat login dan sebaliknya jika <b>Off</b> maka user tidak dapat login</p>
<button class="btn-white" style="cursor:pointer;width: 100%;margin-bottom: 10px;" onClick="window.location='<?php echo HomeUrl()?>/adminpanel/addusers';">Add New User</button>
<form method="get" action="<?php echo HomeUrl()?>/adminpanel/users" >
<input class="tb-search" style="width: 97%;float: none;border-radius: 5px" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">

			
			<?php
			$paging = $this->pagination(false,"db_users","users");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_users ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");
			if($query->rowCount() == 0){?>

				<tr><td colspan="5">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/users.png" style="width: 150px;">
						<p style="font-weight:600;font-size: 18px;">User Tidak Ditemukan</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{
			while($show = $query->fetch()){ 


			if($show['level'] >= userinfo()->level) $status = "<i style='color:#666'>Access Danied</i>";

			elseif($show['status'] == 1) $status = '<img style="cursor:pointer;" sort-id="'.$show['id'].'" onClick="set_status_user(this)" src="'.sourceUrl().'/img/on.png" width="62">';

			else $status = '<img style="cursor:pointer;" sort-id="'.$show['id'].'" onClick="set_status_user(this)" src="'.sourceUrl().'/img/off.png" width="62">';

			?>

			<tr>
				<td>
					<?php 

					if(empty($show['profile_pict']) or ($show['profile_pict'] == "")){

						if(strtolower($show['gender']) == "perempuan")
						$pict = sourceUrl()."/img/woman.png";
						else
						$pict = sourceUrl()."/img/man.png";
						
					}else $pict = sourceUrl()."/usr_pict/".$show['profile_pict'];

						echo "<img src='".$pict."' style='width:50px;height:50px;border-radius:100%;position:absolute;margin-top:3px;'>";


						echo "<p style='margin-left:70px;margin-top:0px;font-weight:600;'>".strip_tags(ucwords($show['first_name']." ".$show['last_name']))."<span style=\"font-size:12px;color:#666;margin-left:10px;\">(@".$show['username'].")</span></p>";
						echo "<p style='margin-left:70px;margin-top:-10px;font-size:11px;font-style:italic;color:#666;'>".strip_tags($show['address'].", ".$show['district'].", ".$show['state'].", ".$show['province']." (".$show['zip_code'].") ")."</p>";
						echo "<p style='margin-left:70px;font-size:12px'><span style='font-weight:600;'>Registered Date : </span>".date("d/m/Y", $show['regis_date'])." ".date("H:i", $show['regis_date'])."</p>";

					?>
			
					<?php 

						echo "<p style='margin-left:70px;font-size:12px'><span style='font-weight:600;'>Email : </span><a style='color:#09f' href='mailto:".$show['email']."'>".$show['email']."</a></p>";
						echo "<p style='margin-left:70px;font-size:12px'><span style='font-weight:600;'>Phone Number : </span>".$show['phone_number']."</p>";

					?>						
				
					<p style='margin-left:70px;font-size:12px'><span style='font-weight:600;margin-right: 10px;'>Level Access : </span>
					<?php 

					if($show['level'] == 0){

						echo "<span style='font-size:13px;background:#787672;color:#f5f5f5;padding:5px;border-radius:5px;'>Customer</span>";

					}else if($show['level'] == 1){

						echo "<span style='font-size:13px;background:#47bf61;color:#f5f5f5;padding:5px;border-radius:5px;'>Suplier</span>";

					}else if($show['level'] == 2){

						echo "<span style='font-size:13px;background:#3a6da1;color:#f5f5f5;padding:5px;border-radius:5px;'>Admin</span>";

					}else if($show['level'] == 3){

						echo "<img src='".sourceUrl()."/media/king.png' width='30'>";

					}

				?></p>

					<p style='margin-left:70px;font-size:12px'><?php echo $status?></p>


					<?php if($show['level'] < 2) $url = "mailto:".$show['email'];
					else $url = HomeUrl()."/adminpanel/message?chat_to=".$show['username']."#".$show['username'];
					?>


					<p style='margin-left:70px;'>
						<a style="color:orangered;font-size: 13px;" href="<?php echo $url ?>">Chat To</a> · 
						<a style="color:orangered;font-size: 13px;" href="<?php echo HomeUrl()."/adminpanel/editusers?id=".$show['id']?>">Edit</a> · 
						<a style="color:orangered;font-size: 13px;" href="javascript:void(0)" onClick="delete_product(<?php echo $show['id']?>,'delete_users')">Hapus</a>
					</p>
					
				</td>
			</tr>

		<?php } }?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_users","users") ?>
	</div>
		
</div>
<?php }