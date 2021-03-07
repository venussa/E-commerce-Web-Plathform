<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Daftar permintaan penarikan saldo dompet digital.</i></p>

<form method="get" action="<?php echo HomeUrl()?>/adminpanel/request_deposit">
<input class="tb-search" type="text" name="q" placeholder="Search ..." value="<?php echo urldecode($this->get("q"))?>" style="width:97%;float:none;">
</form>

<div class="big-panel-box" style="margin-top:20px;float:none;">

	<div class="list">
		<table width="100%">

			<?php
			$paging = $this->pagination(false,"db_deposit_request","request_deposit");

			$offset = ($paging->page - 1) * $paging->dataperpage;

			$limit = $paging->dataperpage;

			$query = $this->db()->query("SELECT * FROM db_deposit_request ".$paging->condition." ORDER BY id DESC LIMIT $offset,$limit");

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

				$saldo = $this->db()->fetchAssoc("SELECT SUM(saldo) as saldo FROM db_deposit_request WHERE id < ".$show['id']." and user_id='".userinfo()->user_id."'");

				if($show['type'] == 0){
					$msg = "Pengembalian dana pembelian produk  <br>".$show['invoice_id'];
					$color = "#3abd75";
					$symbol = "+";
					$saldo = $saldo['saldo'] + $show['saldo'];
				}else if($show['type'] == 3){

					if($show['status'] == 1){
						$saldo = $saldo['saldo'] + $show['saldo'];
						$status = "<span style='color:#1093ad;font-weight:600;'>[ Dana Terdeposit ]</span>";
					}else{
						$saldo = $saldo['saldo'];
						$status = "";
					}

					$msg = "Deposit saldo <br>ID Transaksi : ".$show['tf_id']."<br>".$status;
					$color = "#d11717";
					$symbol = "-";

					

				}else if($show['type'] == 2){
					$msg = "Penggunaan saldo untuk membeli produk <br>".$show['invoice_id']."<br>ID Transaksi : ".$show['tf_id'];
					$color = "#0f8fa6";
					$symbol = "-";
					$saldo = $saldo['saldo'] + $show['saldo'];
				}
				
			?>

			<tr>
				<td>
					<p style="font-size: 13px;color:#666"><?php echo date("d/m/Y [H:i:s]", $show['date_time'])?></p>
					<p style="font-size: 14px;margin-top:-10px;"><?php echo $msg?></p>

					<p style="font-size: 14px;color:#666">Nominal</p>
					<p style="font-size: 16px;margin-top:-10px;font-weight:600;color:<?php echo $color?>">Rp <?php echo str_replace("-",null,number_format($show['saldo']))?></p>

					<a href="<?php echo HomeUrl()?>/adminpanel/deposit_status?id=<?php echo $show['tf_id']?>" style="color:orangered">Validasi Permintaan</a>
				</td>
			</tr>

		<?php  } } ?>

		</table>
	</div>
</div>

<?php if($query->rowCount() !== 0){ ?>
<div style="margin-top:0px;width: 100%;margin-bottom: 60px;">

	<div style="margin-left: -40px;">
		<?php echo $this->pagination(true,"db_deposit_request","request_deposit") ?>
	</div>
		
</div>
<?php } ?>