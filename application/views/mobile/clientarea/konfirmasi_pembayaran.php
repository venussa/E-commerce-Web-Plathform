
<?php 

$query = $this->db()->query("SELECT * FROM db_orders WHERE sorting_id='".$this->get("id")."'  and user_id='".userinfo()->user_id."' ");
$show  = $query->fetch();

if($query->rowCount() == 0){

	header("location:".HomeUrl()."/clientarea/pembayaran_tertunda");
	exit;
}

if($show['status'] > 1){

	header("location:".HomeUrl()."/clientarea/pembayaran_tertunda");
	exit;

}

$product = $this->db()->query("SELECT * FROm db_product WHERE product_id='".$show['product_id']."' ");
$product = $product->fetch();

$picture = json_decode($product['picture']);

$shipping_data = $this->db()->query("SELECT * FROM db_delivery_service WHERE invoice_id='".$show['invoice_id']."' ");
$shipping_data = $shipping_data->fetch();

$destination = $this->db()->query("SELECT * FROM db_destination_address WHERE id='".$show['destination']."'");
$destination = $destination->fetch();

$bank = $this->db()->query("SELECT * FROM db_pay_info WHERE id='".$show['pay_with']."' ");
$bank = $bank->fetch();

$order_pending = $this->db()->query("SELECT * FROM db_order_pending WHERE order_id='".$this->get("id")."'  and user_id='".userinfo()->user_id."' ");
$order_pending = $order_pending->rowCount();

$hours = 86400;

$last_pay0 = $show['start_time'] + $hours;
$last_pay = date("M d, Y H:i:s",$last_pay0);

$total_price = $show['total_order'] * $show['price'];
$total_cost = $total_price + $shipping_data['price'];
$pay_method = $total_cost;
$total_cost = number_format($total_cost);
$total_price = number_format($total_price);

$order_pendings = $this->db()->query("SELECT * FROM db_order_pending WHERE order_id='".$show['sorting_id']."' ");
$order_pending_show = $order_pendings->fetch();
$order_pending = $order_pendings->rowCount();

$wallet = $this->db()->query("SELECT * FROM db_wallet WHERE user_id='".userinfo()->user_id."' and invoice_id='".$show['invoice_id']."' ");
$wallet = $wallet->fetch();
$wallet['saldo'] = $wallet['saldo'] - $wallet['saldo'] - $wallet['saldo'];

if(($show['wallet'] == 1) and ($wallet['saldo'] < $pay_method)) $total_cost = number_format(($pay_method - $wallet['saldo']));

if(empty($show['resi_number'])) $show['resi_number'] = " Belum Tersedia";


if(empty($show['note_order'])) $show['note_order'] = "Tidak ada catatan";

if(($show['status'] == 0)) $status = "Menunggu Pembayaran";
elseif(($show['status'] == 1)) $status = "Menunggu Konfirmasi";
elseif(($show['status'] == 2)) $status = "Pesanan Diproses";
elseif(($show['status'] == 3)) $status = "Pesanan Telah Dikirim";
elseif(($show['status'] == 4)) $status = "Pesanan Telah Tiba";
elseif(($show['status'] == 5)) $status = "Melakukan Komplain";
elseif(($show['status'] == 8)) $status = "Pesanan Selesai";
elseif(($show['status'] == 9)) $status = "Pesanan Dibatalkan";

?>
<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Upload Bukti Transfer</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>Segera lakukan pembayaran sebelum batas waktu yang di tentukan berakhir</i></p>

<div class="big-panel-box" style="margin-top:20px;">

	<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>

	<p style="text-align: center;font-size:16px;font-weight: 600">Segera lakukan pembayaran sebelum</p>

	<?php }else{ ?>

	<p style="text-align: center;font-size:16px;font-weight: 600">Sisa waktu tunggu</p>	

	<?php } ?>

	<div style="width: 90%;background: #f5f5f5;border-radius: 5px;border:1px #ddd solid;padding: 5px;margin: auto;margin-bottom: 20px;">
		<p id="count-down" style="font-weight:600;font-size: 25px;text-align: center;">
		00 <span style='color:#666;font-size:10px;'>Jam</span> : 
		00 <span style='color:#666;font-size:10px;'>Menit</span> : 
		00 <span style='color:#666;font-size:10px;'>Detik</span>
	</p>
		<p style="color:#666;font-size: 12px;text-align: center">( Sebelum <?php echo date("d F Y, H:i",$last_pay0);?> WIB )</p>
	</div>
</div>

<div class="big-panel-box" style="margin-top:20px;border:transparent;">
	<p style="font-weight:600;margin-top: 0px;">Catatan Penting</p>
	<ul style="margin-left:-25px;">
		<li style="padding: 5px;font-size:13px;">Transferlah dengan <span style="color:orangered">jumlah yang sesuai</span>, dan biaya transfer beda bank <span style="color:orangered">ditanggung oleh pembeli</span></li>
		<li style="padding: 5px;font-size:13px;"><span style="color:orangered">Simpan bukti pembayaran</span> yang sewaktu-waktu diperlukan jika terjadi kendala transaksi</li>

		<li style="padding: 5px;font-size:13px;">Pesanan <span style="color:orangered">otomatis dibatalkan</span> apabila tidak melakukan pembayaran lebih dari 24 Jam setelah kode pembayaran diberikan</li>
	</ul>
</div>




<table width="100%" style="margin-top: 20px;border-top:1px #ddd solid;">

			<tr>
				<td valign="top" colspan="2">
					<p style="font-weight:600;font-size: 13px;">
						Nomor Invoice
					</p>

					<p style=";font-size: 13px;margin-top:-5px;">
					#<?php echo $show['invoice_id']?>
					</p>

					<p style=";font-size: 13px;float: left;width: 70px;margin-right:10px">
						<img src="<?php echo sourceUrl()."/content/".$picture[0]?>" style="width:60px;height:60px;border:1px #ddd solid;border-radius: 5px;">
					</p>

					<p style=";font-size: 13px;float: left;">
						<p style="font-size:13px;margin-top:25px;"><a style="color:#434343;font-weight:600;" href="<?php echo HomeUrl()?>/clientarea/detail_pesanan?id=<?php echo $show['sorting_id']?>"><?php echo $product['title']?></a></p>
						<p style="color:orangered;margin-top:-10px;font-size: 13px;">Rp <?php echo number_format($show['price'])?> <span style="color:#666;font-size:12px;margin-left:15px;"><?php echo $show['total_order']?> Product ( <?php echo number_format($product['weight'] * $show['total_order'])?> Gr )</span></p>
						
						<p style="background: #f5f5f5;border:1px #ddd solid;padding:5px;margin-top:30px;font-size:13px;border-radius: 4px;">Lakukan Pembayaran Sebelum <?php echo $last_pay?></p>
					
					</p>

				</td>
			</tr>
			<tr>
				<td valign="top" style="width: 200px;">
					<p style=";font-size: 13px;">Metode Pembayaran</p>
					<p style="font-weight:600;font-size: 13px;margin-top:-5px;">Transfer <?php echo $bank['bank_name']?></p>

					<p style=";font-size: 13px;margin-top: 30px;">
						Total Pembayaran
					</p>
					<p style="font-weight:600;font-size: 13px;margin-top:-5px;color:orangered">
						<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						Rp <?php echo $total_cost?>
					<?php }else{ ?>
						Belum Ada
					<?php } ?>
					</p>
				</td>

				<td valign="top" style="width: 150px;">

					<p style=";font-size: 13px;">
						<img src="<?php echo sourceUrl()?>/bank/<?php echo $bank['icon']?>" style="width:70px;height:40px;border:1px #ddd solid;border-radius: 5px;">
					</p>

					<p style="font-size: 13px;font-weight:600;"><?php echo $bank['bank_name']?></p>
					<p style="font-size: 13px;color:orangered"><span style="color:#000;">No. Rek :</span> 
					<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						<?php echo $bank['bank_info']?>
					<?php }else{ ?>
						Belum Ada
					<?php } ?>
					</p>



					<p style="font-size: 13px;margin-top:-10px;">A/N : 
					<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>
						<?php echo $bank['atas_nama']?>
					<?php }else{ ?>
						Belum Ada
					<?php } ?>
					</p>

				
				</td>
				
				
				
			</tr>

		</table>



<?php if(($product['transaction_scheme'] < 1) or (($order_pending > 0) and ($product['transaction_scheme'] > 0))){ ?>

<p style="font-weight: 600;font-size: 17px">Upload bukti Transfer</p>
<div class="big-panel-box" style="margin-top:20px;border:1px #ccc solid;border-radius: 5px;overflow: hidden;margin-bottom: 50px;">
	<form method="POST" action="<?php echo HomeUrl()?>/clientarea/upload_pembayaran?id=<?php echo $show['sorting_id']?>" enctype="multipart/form-data">
<table width="100%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight: 600">Nama Bank</p>
			<p class="t2">* Bank yang anda gunakan untuk Transfer</p>
		<input type="text" name="your_bank_name" class="form-input" style="border:1px #ccc solid;border-radius: 5px;width: 93%" value="<?php echo $show['your_bank_name']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight: 600">Nomor Rekening</p>
		
		<input type="text" name="your_rekening_number" class="form-input" style="border:1px #ccc solid;border-radius: 5px;width: 93%" value="<?php echo $show['your_rekening_number']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight: 600">Atas Nama</p>
		
		<input type="text" name="your_atas_nama" class="form-input" style="border:1px #ccc solid;border-radius: 5px;width: 93%" value="<?php echo $show['your_atas_nama']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight: 600">Lampiran</p>
			<p class="t2">* Foto Bukti transfer</p>
		

			
			<?php 

			if(!empty($show['screenshot'])){

				$pict = sourceUrl()."/transfer/".$show['screenshot'];

			}else{
			
				$pict = sourceUrl()."/img/img-upload.png";

			}
			

			?>

			<img src="<?php echo $pict?>" style="width: 75px;height:75px;cursor: pointer;" id="img-icon" onClick="click_upload('input-icon')">
				<input type="file" id="input-icon" name="screenshot" style="display: none;" required="">
		</td>
	</tr>


	<tr>
		<td>

		<?php if($show['status'] == 0){ ?>
			<p style="font-size: 13px;">
				<label class="cb-container"> Sudah yakin benar? karena setelah upload anda tidak dapat mengubah datanya kembali
				  <input type="checkbox" required="">
				  <span class="checkmark"></span>
				</label>
			</p>
			<button class="btn-white" type="submit" style="cursor:pointer;padding: 5px;font-size: 15px;border-radius: 4px;background: #fe4c50;border:1px #fe4c50 solid;">Konfirmasi Transfer</button>

			<?php }else{ ?>

			<p style="color:orangered;font-size:13px;">Bukti telah kami terima, pembayaran akan kami verifikasi dalam waktu 1 x 24 Jam</p>

			<?php } ?>
		</td>
	</tr>


</table>

</form>

</div>

<?php }else{ ?>

<p style="font-size:11px;color:#666;padding:5px;">
		* Dalam menenuntukan biaya pengiriman yang dikenakan, kami akan melakukan pengukuran berat keseluruhan barang karena barang yang anda pesan membutuhkan media air yang mana kami harus menghitung valume dari air tersebut untuk mendapatkan berat total dari barang yang anda pesan. Total biaya yang harus anda bayar akan segera kami beritahukan melalui email atau anda dapat mengeceknya pada menu <a style="color:#09f" href="<?php echo HomeUrl()?>/clientarea/pembayaran_tertunda" target="_blank">pembayaran tertunda</a> dengan masa kerja Maksimal 1 x 24 Jam.
	</p>

<?php } ?>



<script>

var countDownDate = new Date("<?php echo $last_pay?>").getTime();
var x = setInterval(function() {

  var now = new Date().getTime();

  var distance = countDownDate - now;

  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  if(days > 0)
  document.getElementById("count-down").innerHTML = days+"<span style='color:#666;font-size:10px;'>Hari</span> : "+hours + " <span style='color:#666;font-size:10px;'>Jam</span> : "+ 
  	  minutes + " <span style='color:#666;font-size:10px;'>Menit</span>";

  else document.getElementById("count-down").innerHTML = hours + " <span style='color:#666;font-size:10px;'>Jam</span> : "+ 
  	  minutes + " <span style='color:#666;font-size:10px;'>Menit</span> : " + 
  	  seconds+" <span style='color:#666;font-size:10px;'>Detik</span>";

  if (distance < 0) {
    clearInterval(x);
    document.getElementById("count-down").innerHTML = "EXPIRED";
  }
}, 1000);
</script>