<?php

$query = $this->db()->query("SELECT * FROM db_deposit_request WHERE tf_id='".urldecode($this->get("id",["'"]))."' and type='3'");

if($query->rowCount() == 0){

	header("location:".HomeUrl()."/adminpanel/request_deposit");
	exit;
}

$show = $query->fetch();
$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$show['user_id']."' ");
$user = $user->fetch();

if(empty($user['profile_pict']) or ($user['profile_pict'] == "")) {

if(strtolower($user['gender']) == "perempuan")

	$pict = sourceUrl()."/img/woman.png";
	else
	$pict = sourceUrl()."/img/man.png";
	
}else $pict = sourceUrl()."/usr_pict/".$user['profile_pict'];

?>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Validasi permintaan penarikan saldo dompet digital dari customer</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/verif_deposit?id=<?php echo urldecode($this->get("id",["'"]))?>" enctype="multipart/form-data">
<table width="100%" style="">
	
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Informasi Akun</p>
			<p class="t2">* Nama akun yang mengajukan Deposit</p>
	
			<img src="<?php echo $pict?>" style="width:50px;height:50px;position: absolute;margin-top:15px;border-radius: 100%;">
			<p style="margin-left:70px;font-weight:600;"><?php echo ucwords($user['first_name']." ".$user['last_name']) ?></p>
			<p style="margin-left:70px;margin-top:-10px;font-size: 13px;"><a href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user['username']?>" style="color:#09f">@<?php echo $user['username']?></a></p>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nama Pada Rekening</p>
		<input type="text" class="form-input" disabled required value="<?php echo $show['card_name']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nama Bank</p>
			<p class="t2">* Nama bank yang anda gunakan</p>
		
		<input type="text" class="form-input" disabled required value="<?php echo $show['bank_name']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Nomor Rekening</p>
		
		<input type="text" class="form-input" disabled required value="<?php echo $show['rekening_number']?>"></td>
	</tr>
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Besar Penarikan</p>
			<p class="t2">* Minimum dana yang dapat di tarik ialah sebesar Rp 50.000</p>
		
		<input type="text" class="form-input" disabled required value="Rp <?php echo str_replace("-",null,number_format($show['saldo']))?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Lampiran</p>
			<p class="t2">* Foto Bukti transfer</p>
		

			
			<?php $pict = sourceUrl()."/bank/".$show['picture']; ?>

			<img onClick="MyWindow=window.open('<?php echo $pict?>','MyWindow','width=1000,height=1000'); return false;" src="<?php echo $pict?>" style="width: 150px;cursor: pointer;border:1px #ddd solid;">
			<br>
			<br>
		</td>
	</tr>

	<tr>
		<td>
			
			<label class="cb-container">Check bila dana sudah masuk ke rekening
			  <input type="checkbox" required <?php echo ($show['status'] == 1) ? "checked disabled" : null?>> 
			  <span class="checkmark"></span>
			</label>

			<?php if($show['status'] == 0) { ?>
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white rebuild" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Verifikasi</button>
			<?php } ?>
		</td>
	</tr>

</table>

</form>

