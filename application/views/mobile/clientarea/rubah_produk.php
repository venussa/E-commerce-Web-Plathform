<?php 

if(userinfo()->level < 1){
echo "<script>window.location='".HomeUrl()."/clientarea/dashboard';</script>";
exit;
}
$command = "SELECT * FROM db_product WHERE sorting_id='".$this->get("id")."' and user_id='".userinfo()->user_id."' ";
$query = $this->db()->query($command);
$show = $query->fetch();

$category = $this->db()->query("SELECT title FROM db_category WHERE id='".$show['category']."' ");
$category = $category->fetch();

$subcategory = $this->db()->query("SELECT title FROM db_category WHERE id='".$show['sub_category']."' ");
$subcategory = $subcategory->fetch();

if($query->rowCount() == 0){

	echo "<script>alert('Tidak ditemukan produk');window.location='".HomeUrl()."/clientarea/produk_saya';</script>";
	exit;

}

?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Menu untuk menambahkan artikel / produk terbaru. Pastikan semua data telah terisi dengan baik "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/clientarea/edit_product?id=<?php echo $this->get("id")?>" enctype="multipart/form-data" >
<table width="98%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Product Id</p>
			<p class="t2">* Id khusus product</p>
		
		<input type="text" class="form-input" value="<?php echo $show['product_id']?>" readonly="" style="background: #eee" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Title</p>
			<p class="t2">* Judul dari produk yang di input</p>
		
		<input type="text" name="title" class="form-input" value="<?php echo $show['title']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Description</p>
			<p class="t2">* Deskripsi dari produk</p>
		
		<textarea type="text" name="description" class="form-input" rows="4" style="max-width: 96.1%;min-width: 96%;font-size:14px;" required><?php echo $show['description']?></textarea></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Category</p>
			<p class="t2">* Kategori dari produk</p>
		

			<select type="text" name="category" class="form-input" style="width: 99.5%;color:#000;border:1px #ddd solid;" onChange="return change_sub_category(this)" required disabled>
				<?php 
				$query = $this->db()->query("SELECT * FROM db_category WHERE level='0' ");
				
				echo "<option>".$category['title']."</option>";
				while($show_category = $query->fetch()){ 

				if($show_category['title'] !== $category['title']) {

				?>
					
					<option><?php echo $show_category['title']?></option>

				<?php } } ?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Sub Category</p>
			<p class="t2">* Sub Kategori dari kategori <span id="child-category"></span></p>
		
		<span id="child-category-select">
			<select type="text" name="subcategory" class="form-input" style="width: 99.5%;color:#000;border:1px #ddd solid;" required disabled>
				<?php 
				$query = $this->db()->query("SELECT * FROM db_category WHERE level='1' and sublevel='".$subcategory['id']."' ");

				echo "<option>".$subcategory['title']."</option>";

				while($show_sub_category = $query->fetch()){ 
				if($show_sub_category['title'] !== $subcategory['title']){
				?>
					
					<option><?php echo $show_sub_category['title']?></option>

				<?php }} ?>
			</select>
		</span>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Size</p>
			<p class="t2">* Anda bisa memasukkan penjelasan lengkap mengenai ukuran pada bagian deskripsi produk</p>
		
		<select type="text" name="size" class="form-input" required style="width: 99.5%">
			<option><?php echo $show['size']?></option>
			<option>Kecil</option>
			<option>Sedang</option>
			<option>Besar</option>
		</select></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Weight</p>
			<p class="t2">* Berat tiap barang (Gram)</p>
		
		<input type="text" name="weight" class="form-input" value="<?php echo $show['weight']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Stock</p>
			<p class="t2">* Jumlah ketersediaan barang</p>
		
		<input type="text" name="stock" class="form-input" value="<?php echo $show['stock']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Minimum Order</p>
			<p class="t2">* Jumlah pembelian paling sedikit</p>
		
		<input type="text" name="min_order" class="form-input" required  value="<?php echo $show['min_order']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Price</p>
			<p class="t2">* Harga Product</p>
		
		<input type="text" name="price" class="form-input" value="<?php echo $show['price']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1" style="font-weight:600">Picture</p>
			<p class="t2">*Foto dari produk, maksimal 5 foto yang di upload</p>
		

			<div  style="width: 97.5%;background: #fff;border:1px #ddd solid;padding: 5px;">
				<span id="preview-img">

				<?php 

				$picture = json_decode($show['picture']);

				$sum = 1;

				foreach($picture as $key => $value){ ?>

					<img src="<?php echo sourceUrl()."/content/".$value?>" id="act-img-<?php echo $sum?>" edit="true" data="<?php echo $sum?>" onClick="upload_image(this)" style="border:1px #ddd solid;margin:5px;width:90px;height:90px;margin-top:5px;cursor: pointer;">

				<?php $sum++; } ?>

				
				</span>

				<input type="file" id="img1" name="img1" style="display: none;">
				<input type="file" id="img2" name="img2" style="display: none;">
				<input type="file" id="img3" name="img3" style="display: none;">
				<input type="file" id="img4" name="img4" style="display: none;">
				<input type="file" id="img5" name="img5" style="display: none;">

				<edit data="false" style="display: none;"></edit>

				<?php if($sum < 6){ ?>
				<img src="<?php echo HomeUrl()?>/sources/img/img.png" style="width:90px;height:90px;margin-top:5px;cursor: pointer;margin:5px;" data="<?php echo $sum?>" edit="false" id="upload-plus" onClick="upload_image(this)">
				<?php } ?>

			</div>
		</td>
	</tr>



	<tr>
		

		<td>
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Save & Publish</button>
		</td>
	</tr>

</table>

</form>