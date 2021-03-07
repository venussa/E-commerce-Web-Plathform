
<?php 

$command = "SELECT * FROM db_product WHERE sorting_id='".$this->get("id")."' ";
$query = $this->db()->query($command);
$show = $query->fetch();

$category = $this->db()->query("SELECT * FROM db_category WHERE id='".$show['category']."' ");
$category = $category->fetch();

$subcategory = $this->db()->query("SELECT * FROM db_category WHERE id='".$show['sub_category']."' ");
$subcategory = $subcategory->fetch();

$dis_query = $this->db()->query("SELECT * FROM db_product_discount WHERE product_id='".$show['sorting_id']."' ");
$discount = $dis_query->fetch();

$start_time = date("Y-m-d",$discount['start_time']);
$end_time = date("Y-m-d",$discount['end_time']);

if($dis_query->rowCount() == 0){

	$discount['price'] = null;
	$start_time = null;
	$end_time = null;
}

?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Menu untuk menambahkan artikel / produk terbaru. Pastikan semua data telah terisi dengan baik "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/edit_product?id=<?php echo $this->get("id")?>" enctype="multipart/form-data">
<table width="100%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Product Id</p>
			<p class="t2">* Id khusus product</p>
		</td>
		<td><input type="text" class="form-input" value="<?php echo $show['product_id']?>" readonly="" style="background: #eee" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Title</p>
			<p class="t2">* Judul dari produk yang di input</p>
		</td>
		<td><input type="text" name="title" class="form-input" value="<?php echo $show['title']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Description</p>
			<p class="t2">* Deskripsi dari produk</p>
		</td>
		<td><textarea type="text" name="description" class="form-input" rows="4" style="max-width: 96.1%;min-width: 96%;font-size:13px;" required><?php echo $show['description']?></textarea></td>
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
			<p class="t1">Sub Category</p>
			<p class="t2">* Sub Kategori dari kategori <span id="child-category"><b></b></span></p>
		</td>
		<td id="child-category-select">
			<select type="text" name="subcategory" class="form-input" style="width: 99.5%" required>
				<?php 
				$query = $this->db()->query("SELECT * FROM db_category WHERE level='1' and sublevel='".$subcategory['id']."' ");

				echo "<option>".$subcategory['title']."</option>";

				while($show_sub_category = $query->fetch()){ 
				if($show_sub_category['title'] !== $subcategory['title']){
				?>
					
					<option><?php echo $show_sub_category['title']?></option>

				<?php }} ?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Size</p>
			<p class="t2">* Anda bisa memasukkan penjelasan lengkap mengenai ukuran pada bagian deskripsi produk</p>
		</td>
		<td><select type="text" name="size" class="form-input" required style="width: 99.5%">
			<option><?php echo $show['size']?></option>
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
		<td><input type="text" name="weight" class="form-input" value="<?php echo $show['weight']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Stock</p>
			<p class="t2">* Jumlah ketersediaan barang</p>
		</td>
		<td><input type="text" name="stock" class="form-input" value="<?php echo $show['stock']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Minimum Order</p>
			<p class="t2">* Jumlah pembelian paling sedikit</p>
		</td>
		<td><input type="text" name="min_order" class="form-input" required  value="<?php echo $show['min_order']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Price</p>
			<p class="t2">* Harga Product</p>
		</td>
		<td><input type="text" name="price" class="form-input" value="<?php echo $show['price']?>" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Discount</p>
			<p class="t2">* Potongan harga barang (PRODUCT)</p>
		</td>
		<td>
			<div  style="width: 97.5%;background: #f5f5f5;border:1px #ddd solid;
			height:100px;padding: 5px;">
				<input type="text" name="discount" class="form-input" value="<?php echo $discount['price']?>" placeholder="Besar Potongan Harga">
				<br>
				<br>
				Dari : <input type="date" value="<?php echo $start_time?>" class="form-input" style="width: 150px;" name="start_time">&nbsp;&nbsp;
				Sampai : <input type="date" value="<?php echo $end_time?>" class="form-input" style="width: 150px;" name="end_time">
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
		<td class="tr" style="width: 200px;">
			<p class="t1">Transaction Scheme</p>
			<p class="t2">* Skema Transaksi yang diterapkan</p>
		</td>
		<td>
			<p><label class="cb-container"> Skema Langsung
			  <input type="checkbox" name="transaction_scheme" value="0" <?php echo ($show['transaction_scheme'] == 0) ? "checked" : "";?> class="cbx">
			  <span class="checkmark"></span>
			</label>
			<span style="font-size:11px;color:#666">* User yang melakukan transaksi bisa dapat langsung mengetahui harga ongkos kirim produk</span>
		</p>
			<p><label class="cb-container"> Skema Tak Langsung
			  <input type="checkbox" name="transaction_scheme" value="1" <?php echo ($show['transaction_scheme'] == 1) ? "checked" : "";?> class="cbx">
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