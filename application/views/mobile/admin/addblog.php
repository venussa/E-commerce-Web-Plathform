<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Menu untuk menambahkan halaman website baru" </i></p>


<form method="POST" id="blog" action="<?php echo HomeUrl()?>/adminpanel/add_page" enctype="multipart/form-data">
<table width="100%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Title</p>
			<p class="t2">* Nama untuk halaman</p>
		
		<input type="text" name="title" class="form-input" required onKeyup="return create_slug(this)"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Slug</p>
			<p class="t2">* link dari halaman</p>
		
		<input type="text" id="slugs" name="slug" class="form-input" required>
		<P style="font-size: 12px;color:#666">* Kosongkan jika anda tidak ingin menyertakan alamat url</P>
		</td>
	</tr>

	<tr>
			<td class="tr" style="width: 200px;" valign="top">
				<p class="t1">Banner Image</p>
				<p class="t2">* Gambar poster blog</p>
			

				<div style="border:1px #ddd solid;background: #fff;width: 350px;height:200px;vertical-align: middle;text-align: center;">
					<img src="<?php echo sourceUrl()."/img/img2.png"?>" style="width: 100%;height:200px" id="img-thumbnail" onClick="click_upload('input-thumbnail')">
				</div>
				<p style="font-size: 13px;color:#666;">Sesuaikan dengan ukuran umum image banner</p>
				<input type="file" id="input-thumbnail" name="img" style="display: none;" required>
			</td>
		</tr>

	<tr>
		
		<td class="tr" style="width: 200px;">
			<p class="t1">Meta Description</p>
			<p class="t2">* Deskripsi singkat dari konten blog, usahakan tidak lebih dari 160 huruf</p>
		

			<textarea type="text" name="description" class="form-input" rows="3" style="width: 94.1%;"><?php echo $show['description'] ?></textarea>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<div class="tr" style="width: 200px;">
			<p class="t1">Web Content</p>
			<p class="t2">* Isi atau Content dari halaman</p>
			</div>
			<textarea type="text" name="content" class="form-input textarea" rows="15" style="max-width: 96.1%;min-width: 96%"></textarea>
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