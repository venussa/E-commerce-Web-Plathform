
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px">Anda dapat merubah data dari profile anda kapan saja, namun anda memerlukan tindakan lebih untuk mengubah data email karena email ini agan digunakan sebagai jembatan komunikasi antara system dengan pengguna.</p>


<?php

if(empty(userinfo()->profile_pict) or (userinfo()->profile_pict == "")) {

		if(strtolower(userinfo()->gender) == "perempuan")
		$pict = sourceUrl()."/img/woman.png";
		else
		$pict = sourceUrl()."/img/man.png";
		
	}else $pict = sourceUrl()."/usr_pict/".userinfo()->profile_pict;

?>


<div style="width: 100%">
	<img src="<?php echo $pict?>" width="100%"  style="position: absolute;width: 100px;height:100px">
	<p style="margin-left:110px;margin-top:0px;">
		<span style="font-size: 16px;font-weight:600"><?php echo ucwords(userinfo()->first_name." ".userinfo()->last_name) ?> <span style="font-size: 11px;color:#09f">( @<?php echo userinfo()->username?> )</span></span>
		</p>

	<p style="margin-left:110px;margin-top:0px;">
		<span style="font-size: 12px;color:#666">
		<img src="<?php echo sourceUrl()?>/media/mark.png" width="13">
		<?php echo userinfo()->state?>, <?php echo userinfo()->province?></span>
	</p>
	<p style="margin-left:110px;margin-top:-15px;">
		<span style="font-size: 12px;color:#666">
		<img src="<?php echo sourceUrl()?>/media/surat.png" width="13">
		<a href="mailto:<?php echo userinfo()->email?>" style="color: #09f;font-size: 13px;"><?php echo userinfo()->email?></a>
		</span>
	</p>


	<p style="margin-left:110px;margin-top:-15px;">
		<span style="font-size: 12px;color:#666">
		<img src="<?php echo sourceUrl()?>/media/role.png" width="15">
	<?php 

		if(userinfo()->level == 0){

			echo "Customer";

		}else if(userinfo()->level == 1){

			echo "Suplier";

		}else if(userinfo()->level == 2){

			echo "Admin";

		}else{

			echo "Administrator";

		}

	?>
	</p>



<div style="margin-top:50px;">
		<p style="font-size: 18px;font-weight:600;border-bottom:1px #ddd solid;padding:5px;">Tentang Saya 

			<span style="float: right;font-size: 12px;color:#666;margin-top:5px;cursor:pointer" onClick="window.location='<?php echo HomeUrl()?>/clientarea/pengaturan_profile';"><img src="<?php echo sourceUrl()?>/media/cog.png" width="13"> Ubah Profile</span>

		</p>
		<p style="color:#666;font-size: 13px;"><img src="<?php echo sourceUrl()?>/media/mark.png" width="13"> Alamat Saya</p>
		<table width="100%" style="margin-left:10px;">
			<tr>
				<td style="width:130px;padding:5px;font-weight:600;font-size: 13px;color:#434343">Alamat</td>
				<td style="color: #666;padding:5px;font-size: 13px;">: <?php echo userinfo()->address?></td>
			</tr>
			<tr>
				<td style="width:130px;padding:5px;font-weight:600;font-size: 13px;color:#434343">Kecamatan</td>
				<td style="color: #666;padding:5px;font-size: 13px;">: <?php echo userinfo()->district?></td>
			</tr>

			<tr>
				<td style="width:130px;padding:5px;font-weight:600;font-size: 13px;color:#434343">Kabupaten / Kota</td>
				<td style="color: #666;padding:5px;font-size: 13px;">: <?php echo userinfo()->state?></td>
			</tr>

			<tr>
				<td style="width:130px;padding:5px;font-weight:600;font-size: 13px;color:#434343">Provinsi</td>
				<td style="color: #666;padding:5px;font-size: 13px;">: <?php echo userinfo()->province?></td>
			</tr>

			<tr>
				<td style="width:130px;padding:5px;font-weight:600;font-size: 13px;color:#434343">Kode Pos</td>
				<td style="color: #666;padding:5px;font-size: 13px;">: <?php echo userinfo()->zip_code?></td>
			</tr>
		</table>


		<p style="color:#666;font-size: 13px;"><img src="<?php echo sourceUrl()?>/media/cs.png" width="13"> Hubungi Saya</p>
		<table width="100%" style="margin-left:10px;">
			<tr>
				<td style="width:130px;padding:5px;font-weight:600;font-size: 13px;color:#434343">Email</td>
				<td style="color: #666;padding:5px;font-size: 13px;">: <a href="mailto:<?php echo userinfo()->email?>" style="color: #09f;font-size: 13px;"><?php echo userinfo()->email?></a></td>
			</tr>
			<tr>
				<td style="width:130px;padding:5px;font-weight:600;font-size: 13px;color:#434343">No. Telephone</td>
				<td style="color: #666;padding:5px;font-size: 13px;">: <?php echo userinfo()->phone_number?></td>
			</tr>

		</table>
	</div>
</div>