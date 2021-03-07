
<?php 
$query = $this->db()->query("SELECT * FROM db_custom_page WHERE id='".$this->get("id")."' ");
$show = $query->fetch();

if(empty($show['img'])) $img = sourceUrl()."/img/img2.png";
else $img = sourceUrl()."/website/".$show['img'];
?>
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Edit content pada blog" </i></p>

<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/edit_page?id=<?php echo $this->get("id")?>" enctype="multipart/form-data">
<table width="100%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Title</p>
			<p class="t2">* Nama untuk halaman</p>
		</td>
		<td><input type="text" name="title" class="form-input" required  onKeyup="return create_slug(this)"value="<?php echo $show['title']?>"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Slug</p>
			<p class="t2">* link dari halaman</p>
		</td>
		<td><input type="text" name="slug" class="form-input" required id="slugs" value="<?php echo $show['slug']?>">
		<P style="font-size: 12px;color:#666">* Kosongkan jika anda tidak ingin menyertakan alamat url</P>
		</td>
	</tr>

	<tr>
			<td class="tr" style="width: 200px;" valign="top">
				<p class="t1">Banner Image</p>
				<p class="t2">* Wajib jika dijadikannya sebagai slider</p>
			</td>
			<td>
				<div style="border:1px #ddd solid;background: #fff;width: 350px;height:200px;vertical-align: middle;text-align: center;">
					<img src="<?php echo $img?>" style="width: 100%;height:200px" id="img-thumbnail" onClick="click_upload('input-thumbnail')">
				</div>
				<p style="font-size: 13px;color:#666;">Sesuaikan dengan ukuran minimal 600 x 200 Pixel</p>
				<input type="file" id="input-thumbnail" name="img" style="display: none;">
			</td>
		</tr>


	<tr>
		
		<td class="tr" style="width: 200px;">
			<p class="t1">Meta Description</p>
			<p class="t2">* Deskripsi singkat dari konten blog, usahakan tidak lebih dari 160 huruf</p>
		</td>
		<td >
			<textarea type="text" name="description" class="form-input" rows="3" style="max-width: 96.1%;min-width: 96%"><?php echo $show['description'] ?></textarea>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<div class="tr" style="width: 200px;">
			<p class="t1">Web Content</p>
			<p class="t2">* Isi atau Content dari halaman</p>
			</div>
			<textarea type="text" name="content" class="form-input textarea" rows="15" style="max-width: 96.1%;min-width: 96%"><?php echo $show['content']?></textarea>
		</td>
	</tr>

	
	<tr>
		<td colspan="2">
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			
			<button class="btn-white" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Save & Publish</button>
		</td>
	</tr>

</table>

</form>