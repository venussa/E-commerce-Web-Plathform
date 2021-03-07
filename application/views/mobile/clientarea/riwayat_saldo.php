<?php 

$saldo0 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type != 1 ");
$saldo1 = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE user_id='".userinfo()->user_id."' and type=1 and status=1 ");
$saldo = $saldo0['saldo'] + $saldo1['saldo'];

?>
<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Riwayat Saldo</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Berisi dana dari transaksi yang dibatalkan atau di refund saat proses komplain. Dana dapat digunakan kembali untuk membeli produk lainnya.</i></p>
<form method="get" action="<?php echo HomeUrl()?>/clientarea/riwayat_saldo">
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>" style="width:97%;float:none;">
</form>
<div style="border:1px #ccc solid;border-radius: 5px;margin-top:10px;">
	<p style="padding: 10px;padding-top: 2px;"><a style="color:orangered" href="<?php echo HomeUrl()?>/clientarea/riwayat_saldo">Total Saldo di <?php echo setting()->title?></a></p>
	<p style="font-weight: 600;font-size: 25px;padding: 10px;margin-top: -20px;">Rp <?php echo number_format($saldo)?></p>
	<p style="padding: 10px;margin-top: -20px">
		<a href="<?php echo HomeUrl()?>/clientarea/penarikan_saldo"><button class="btn-white" style="width: 100%;border-radius: 5px;">Tarik Saldo</button></a></p>
	<p style="padding: 10px;margin-top: -20px">
		<a href="<?php echo HomeUrl()?>/clientarea/deposit"><button class="btn-white" style="width: 100%;border-radius: 5px;border:1px #fe4c50 solid; color : #fe4c50;background: #fff;">Deposit</button></a></p>
	</p>
</div>
<div class="big-panel-box" style="margin-top:20px;float: none;">

	<div class="list">
		<table width="100%">

			<?php
			$paging = $this->pagination(false,"db_wallet","riwayat_saldo");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_wallet ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

			if($query->rowCount() == 0){?>

				<tr><td colspan="4">

					<div style="padding: 10px;text-align: center;height:283px;margin-top: 30px;">
						<img src="<?php echo sourceurl()?>/media/wallet.png" style="width: 150px;">
						<p style="font-weight:600;font-size: 18px;">Tdak Ada Riwayat Saldo</p>
						<p style="color:#666;font-size:13px;margin-top:-5px;">Coba cari dengan kata kunci yang lebih spesifik</p>
					</div>

				</td></tr>

			<?php }else{

			while($show = $query->fetch()){ 

				$saldo = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_wallet WHERE id < ".$show['id']." and user_id='".userinfo()->user_id."'");

				if($show['type'] == 0){
					$msg = "Pengembalian dana pembelian produk  <br><a style='color:orangered' href='".HomeUrl()."/clientarea/daftar_transaksi?q=".$show['invoice_id']."'>".$show['invoice_id']."</a>";
					$color = "#3abd75";
					$symbol = "+";
					$saldo = $saldo['saldo'] + $show['saldo'];
				}else if($show['type'] == 1){

					if($show['status'] == 1){
						$saldo = $saldo['saldo'] + $show['saldo'];
						$status = "<span style='color:#1093ad;font-weight:600;'>[ Penarikan Selesai ]</span>";
					}else{
						$saldo = $saldo['saldo'];
						$status = "<span style='color:#c7c416;font-weight:600;'>[ Sedang Diproses ]</span>";
					}

					$msg = "Penarikan saldo <br>ID Transaksi : ".$show['tf_id']."<br>".$status;
					$color = "#d11717";
					$symbol = "-";

					

				}else if($show['type'] == 2){
					$msg = "Penggunaan saldo untuk membeli produk <br><a style='color:orangered' href='".HomeUrl()."/clientarea/daftar_transaksi?q=".$show['invoice_id']."'>".$show['invoice_id']."</a><br>ID Transaksi : ".$show['tf_id'];
					$color = "#0f8fa6";
					$symbol = "-";
					$saldo = $saldo['saldo'] + $show['saldo'];
				}elseif($show['type'] == 3){
					$msg = "Deposit saldo <br>ID Transaksi : ".$show['tf_id'];
					$color = "#3abd75";
					$symbol = "+";
					$saldo = $saldo['saldo'] + $show['saldo'];
				}
				
			?>

			<tr>
				<td>
					<p style="font-size: 13px;color:#666"><?php echo date("d/m/Y [H:i:s]", $show['date_time'])?></p>
					<p style="font-size: 14px;margin-top:-10px;"><?php echo $msg?></p>
				

					<p style="font-size: 14px;color:#666">Nominal</p>
					<p style="font-size: 16px;margin-top:-10px;font-weight:600;color:<?php echo $color?>"><?php echo $symbol?> Rp <?php echo str_replace("-",null,number_format($show['saldo']))?></p>
				

					<p style="font-size: 14px;color:#666">Saldo</p>
					<p style="font-size: 16px;margin-top:-10px;font-weight:600;">Rp <?php echo number_format($saldo)?></p>
				</td>
			</tr>

		<?php  } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0) { ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_wallet","riwayat_saldo") ?>
	</div>
		
</div>
<?php } ?>