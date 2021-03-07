<?php

$user = $this->db()->query("SELECT * FROM db_users WHERE id='".$this->get("id")."' ");
$user = $user->fetch();

if(empty($user['profile_pict']) or ($user['profile_pict'] == "")) {

if(strtolower($user['gender']) == "perempuan")

	$pict = sourceUrl()."/img/woman.png";
	else
	$pict = sourceUrl()."/img/man.png";
	
}else $pict = sourceUrl()."/usr_pict/".$user['profile_pict'];

?>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Berisi dana dari transaksi yang dibatalkan atau di refund saat proses komplain. Dana dapat digunakan kembali untuk membeli produk lainnya.</i></p>
<form method="get" action="<?php echo HomeUrl()?>/adminpanel/view_funds" style="float:right">
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>">
<input type="hidden" name="id" value="<?php echo $this->get("id")?>">
</form>
<div class="big-panel-box" style="margin-top:20px;">

	<div class="list">
		<table width="100%">
			<tr>
				<td class="tr" style="width: 200px;">
					<p class="t1">Informasi Akun</p>
					<p class="t2">* Riwayat saldo dari customer</p>
				</td>
				<td colspan="2">
					<img src="<?php echo $pict?>" style="width:50px;height:50px;position: absolute;margin-top:12px;border-radius: 100%;">
					<p style="margin-left:70px;font-family: Segoe UI Bold"><?php echo ucwords($user['first_name']." ".$user['last_name']) ?></p>
					<p style="margin-left:70px;margin-top:-10px;font-size: 13px;"><a href="<?php echo HomeUrl()?>/adminpanel/users?q=<?php echo $user['username']?>" style="color:#09f">@<?php echo $user['username']?></a></p>
				</td>
			</tr>

			<?php
			$paging = $this->pagination(false,"db_wallet","view_funds");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_wallet ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/wallet.png" style="width: 150px;">
						<p style="font-family: 'Segoe UI Bold';font-size: 18px;">Tdak Ada Riwayat Saldo</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

				$saldo = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE id < ".$show['id']." and user_id='".$user['id']."'");

				if($show['type'] == 0){
					$msg = "Pengembalian dana pembelian produk  <br><a style='color:orangered' href='".HomeUrl()."/adminpanel/orders?q=".$show['invoice_id']."'>".$show['invoice_id']."</a>";
					$color = "#3abd75";
					$symbol = "+";
					$saldo = $saldo['saldo'] + $show['saldo'];
				}else if($show['type'] == 1){

					if($show['status'] == 1){
						$saldo = $saldo['saldo'] + $show['saldo'];
						$status = "<span style='color:#1093ad;font-family:Segoe UI Bold'>[ Penarikan Selesai ]</span>";
					}else{
						$saldo = $saldo['saldo'];
						$status = "<span style='color:#c7c416;font-family:Segoe UI Bold'>[ Sedang Diproses ]</span>";
					}

					$msg = "Penarikan saldo <br>ID Transaksi : <a style='color:orangered' href='".HomeUrl()."/adminpanel/view_funds?id=".$show['user_id']."&q=".$show['tf_id']."'>".$show['tf_id']."</a><br>".$status;
					$color = "#d11717";
					$symbol = "-";

					

				}else if($show['type'] == 2){
					$msg = "Penggunaan saldo untuk membeli produk <br><a style='color:orangered' href='".HomeUrl()."/adminpanel/orders&q=".$show['invoice_id']."'>".$show['invoice_id']."</a><br>ID Transaksi : <a style='color:orangered' href='".HomeUrl()."/adminpanel/view_funds?id=".$show['user_id']."&q=".$show['tf_id']."'>".$show['tf_id']."</a>";
					$color = "#0f8fa6";
					$symbol = "-";
					$saldo = $saldo['saldo'] + $show['saldo'];
				}elseif($show['type'] == 3){
					$msg = "Deposit saldo <br>ID Transaksi : <a style='color:orangered' href='".HomeUrl()."/adminpanel/view_funds?id=".$show['user_id']."&q=".$show['tf_id']."'>".$show['tf_id']."</a>";
					$color = "#3abd75";
					$symbol = "+";
					$saldo = $saldo['saldo'] + $show['saldo'];
				}
				
			?>

			<tr>
				<td>
					<p style="font-size: 13px;color:#666"><?php echo date("d/m/Y [H:i:s]", $show['date_time'])?></p>
					<p style="font-size: 16px;margin-top:-10px;"><?php echo $msg?></p>
				</td>
				<td style="width: 150px;">
					<p style="font-size: 14px;color:#666">Nominal</p>
					<p style="font-size: 16px;margin-top:-10px;font-family: Segoe UI Bold;color:<?php echo $color?>"><?php echo $symbol?> Rp <?php echo str_replace("-",null,number_format($show['saldo']))?></p>
				</td>
				<td style="width: 150px;">
					<p style="font-size: 14px;color:#666">Saldo</p>
					<p style="font-size: 16px;margin-top:-10px;font-family: Segoe UI Bold">Rp <?php echo number_format($saldo)?></p>
				</td>
			</tr>

		<?php  } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;float: right;width: 100%">

	<div style="float: right;margin-top:-5px;">
		<?php echo $this->pagination(true,"db_wallet","view_funds") ?>
	</div>
		
</div>
<?php } ?>