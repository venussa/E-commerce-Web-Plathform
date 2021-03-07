
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Menu untuk menambahkan artikel / produk terbaru. Pastikan semua data telah terisi dengan baik "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/add_product" enctype="multipart/form-data">
<table width="100%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Title</p>
			<p class="t2">* Judul dari produk yang di input</p>
		</td>
		<td><input type="text" name="title" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Description</p>
			<p class="t2">* Deskripsi dari produk</p>
		</td>
		<td><textarea type="text" name="description" class="form-input" rows="4" style="max-width: 96.1%;min-width: 96%;font-size:13px;" required></textarea></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Category</p>
			<p class="t2">* Kategori dari produk</p>
		</td>
		<td>
			<select type="text" name="category" class="form-input" style="width: 99.5%" onChange="return change_sub_category(this)" required>
				<?php 
				$query = $this->db()->query("SELECT * FROM db_category WHERE level='0' ");

				$sum = 1;
				while($show = $query->fetch()){ 
				if($sum == 1) {
				
					$default_sub_category_id = $show['id'];
					$default_sub_category_name = $show['title'];

				}
				?>
					
					<option><?php echo $show['title']?></option>

				<?php $sum++;} ?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Sub Category</p>
			<p class="t2">* Sub Kategori dari kategori <span id="child-category"><b><?php echo $default_sub_category_name?></b></span></p>
		</td>
		<td id="child-category-select">
			<select type="text" name="subcategory" class="form-input" style="width: 99.5%" required>
				<?php 
				$query = $this->db()->query("SELECT * FROM db_category WHERE level='1' and sublevel='$default_sub_category_id' ");
				while($show = $query->fetch()){ ?>
					
					<option><?php echo $show['title']?></option>

				<?php } ?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Size</p>
			<p class="t2">* Anda bisa memasukkan penjelasan lengkap mengenai ukuran pada bagian deskripsi produk</p>
		</td>
		<td><select type="text" name="size" class="form-input" required style="width: 99.5%">
			<option>Kecil</option>
			<option>Sedang</option>
			<option>Besar</option>
		</select></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Weight</p>
			<p class="t2">* Berat tiap barang (Gram)</p>
		</td>
		<td><input type="text" name="weight" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Stock</p>
			<p class="t2">* Jumlah ketersediaan barang</p>
		</td>
		<td><input type="text" name="stock" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Minimum Order</p>
			<p class="t2">* Jumlah pembelian paling sedikit</p>
		</td>
		<td><input type="text" name="min_order" class="form-input" required  value="1"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Price</p>
			<p class="t2">* Harga Product</p>
		</td>
		<td><input type="text" name="price" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Discount</p>
			<p class="t2">* Potongan harga barang (OPTIONAL)</p>
		</td>
		<td>
			<div  style="width: 97.5%;background: #f5f5f5;border:1px #ddd solid;
			height:100px;padding: 5px;">
				<input type="text" name="discount" class="form-input" placeholder="Besar Potongan Harga">
				<br>
				<br>
				Dari : <input type="date" class="form-input" style="width: 150px;" name="start_time">&nbsp;&nbsp;
				Sampai : <input type="date"  class="form-input" style="width: 150px;" name="end_time">
			</div>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Picture</p>
			<p class="t2">*Foto dari produk, maksimal 5 foto yang di upload</p>
		</td>
		<td>
			<div  style="width: 97.5%;background: #fff;border:1px #ddd solid;
			height:100px;padding: 5px;">
				<span id="preview-img"></span>
				<input type="file" id="img1" name="img1" style="display: none;" required>
				<input type="file" id="img2" name="img2" style="display: none;">
				<input type="file" id="img3" name="img3" style="display: none;">
				<input type="file" id="img4" name="img4" style="display: none;">
				<input type="file" id="img5" name="img5" style="display: none;">

				<edit data="false" style="display: none;"></edit>

				<img src="<?php echo HomeUrl()?>/sources/img/img.png" style="width:90px;height:90px;margin-top:5px;cursor: pointer;margin:5px;" data="1" edit="false" id="upload-plus" onClick="upload_image(this)">

			</div>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Transaction Scheme</p>
			<p class="t2">* Skema Transaksi yang diterapkan</p>
		</td>
		<td>
			<p><label class="cb-container"> Skema Langsung
			  <input type="checkbox" name="transaction_scheme" value="0" class="cbx" checked="">
			  <span class="checkmark"></span>
			</label>
			<span style="font-size:11px;color:#666">* User yang melakukan transaksi bisa dapat langsung mengetahui harga ongkos kirim produk</span>
		</p>
			<p><label class="cb-container"> Skema Tak Langsung
			  <input type="checkbox" name="transaction_scheme" value="1" class="cbx">
			  <span class="checkmark"></span>
			</label></p>
			<span style="font-size:11px;color:#666">* User yang melakukan transaksi harus menunggu konfirmasi admin mengenai harga ongkos kirim</span>
		</td>
	</tr>

	<tr>
		<td></td>
		<td>
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Save & Publish</button>
		</td>
	</tr>

</table>

</form>