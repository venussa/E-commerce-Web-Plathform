<?php if(userinfo()->level < 1){
echo "<script>window.location='".HomeUrl()."/clientarea/dashboard';</script>";
exit;
}?>

<p style="border-bottom:1px #ccc solid;padding-bottom:10px;font-size:18px;font-weight: 600;margin-top:20px;-webkit-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
-moz-box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);
box-shadow: 1px 3px 6px 1px rgba(0,0,0,0.2);padding: 10px;border-radius: 5px;">Tambah Produk</p>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Menu untuk menambahkan artikel / produk terbaru. Pastikan semua data telah terisi dengan baik "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/clientarea/add_product" enctype="multipart/form-data">
<table width="100%" style="">


	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Title</p>
			<p class="t2">* Judul dari produk yang di input</p>
		
		<input type="text" name="title" class="form-input" required style="width:93%"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Description</p>
			<p class="t2">* Deskripsi dari produk</p>
		
		<textarea type="text" name="description" class="form-input" rows="4" style="width: 94%;font-size: 13px;" required></textarea></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Category</p>
			<p class="t2">* Kategori dari produk</p>
		

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
			<p class="t1" style="font-weight:600">Sub Category</p>
			<p class="t2">* Sub Kategori dari kategori <span id="child-category"><b><?php echo $default_sub_category_name?></b></span></p>
		
		<span id="child-category-select">
			<select type="text" name="subcategory" class="form-input" style="width: 99.5%" required>
				<?php 
				$query = $this->db()->query("SELECT * FROM db_category WHERE level='1' and sublevel='$default_sub_category_id' ");
				while($show = $query->fetch()){ ?>
					
					<option><?php echo $show['title']?></option>

				<?php } ?>
			</select>
		</span>
	</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Size</p>
			<p class="t2">* Anda bisa memasukkan penjelasan lengkap mengenai ukuran pada bagian deskripsi produk</p>
		
		<select type="text" name="size" class="form-input" required style="width: 99.5%">
			<option>Kecil</option>
			<option>Sedang</option>
			<option>Besar</option>
		</select></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Weight</p>
			<p class="t2">* Berat tiap barang (Gram)</p>
		
		<input type="text" name="weight" class="form-input" required style="width:93%"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Stock</p>
			<p class="t2">* Jumlah ketersediaan barang</p>
		
		<input type="text" name="stock" class="form-input" required style="width:93%"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Minimum Order</p>
			<p class="t2">* Jumlah pembelian paling sedikit</p>
		
		<input type="text" name="min_order" class="form-input" required  value="1" style="width:93%"></td>
	</tr>


	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Price</p>
			<p class="t2">* Harga Product</p>
		
		<input type="text" name="price" class="form-input" required style="width:93%"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Picture</p>
			<p class="t2">*Foto dari produk, maksimal 5 foto yang di upload</p>
		

			<div  style="width: 97.5%;background: #fff;border:1px #ddd solid;padding: 5px;">
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
		<td>

			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;width: 100%">Save & Publish</button>
		</td>
	</tr>

</table>

</form>