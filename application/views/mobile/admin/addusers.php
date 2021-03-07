
<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Menu untuk menambahkan user baru. Pastikan semua data telah terisi dengan baik "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/add_users" enctype="multipart/form-data">
<table width="100%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">First Name</p>
			<p class="t2">* Nama Depan</p>
		
		<input type="text" name="first_name" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Last Name</p>
			<p class="t2">* Nama Belakang</p>
		
		<input type="text" name="last_name" class="form-input" ></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Gender</p>
			<p class="t2">* Jenis Kelamin</p>
		<div id="child-category-select">
			<select type="text" name="gender" class="form-input" style="width: 99.5%" required>
				<option>Laki - laki</option>
				<option>Perempuan</option>
			</select>
		</div>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Address</p>
			<p class="t2">* Alamat tempat tinggal</p>
		
		<textarea type="text" name="address" class="form-input" rows="2" style="width: 94%;font-size: 13px;" required></textarea></td>
	</tr>



	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Provinsi</p>
		

			<select name="province" class="form-input" style="width: 99.5%">
				<?php 

					foreach(provinsi() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kabupaten / Kota</p>
		

			<select name="state" class="form-input" style="width: 99.5%">
				<?php 

					foreach(kabupaten() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kecamatan</p>
		

			<select name="district" class="form-input" style="width: 99.5%">
				<?php 

					foreach(kecamatan() as $key => $value){

						echo "<option value='$key'>$value</option>";

					}

				?>
			</select>
		</td>
	</tr>


	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kode Pos</p>
		
		<input type="text" name="zip_code" class="form-input" required value="<?php echo kodepos("k1","Mendoyo")?>" readonly="" style="background: #f5f5f5"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Email</p>
			<p class="t2">* Email aktif pengguna</p>
		
		<input type="email" name="email" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Phone Number</p>
			<p class="t2">* Nomor telephone yang dapat dihubungi</p>
		
		<input type="text" name="phone_number" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Username</p>
			<p class="t2"></p>
		
		<input type="text" name="username" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Password</p>
			<p class="t2"></p>
		
		<input type="password" name="password" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Re-type Password</p>
			<p class="t2"></p>
		
		<input type="password" name="retype_password" class="form-input" required></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Level Access</p>
			<p class="t2"></p>
		<div id="child-category-select">
			<select onChange="return role_access(this)" type="text" name="level" class="form-input" style="width: 99.5%" required>
				<option>Customer</option>
				<option>Suplier</option>
				<?php if(userinfo()->level > 2) echo "<option>Admin</option>"; ?>
			</select>
		</div>
		</td>
	</tr>

	<?php if((userinfo()->level >= 3)){ ?>
	<tr class="role-access" style="display: none;">
		<td class="tr" colspan="2">
			<p class="t1">Role Access</p>
			<p class="t2">Wewenang yang dapat di akses</p>
			<table style="width: 100%" class="table-access" cellpadding="0" cellspacing="0">
				<tr>
					<th><label class="cb-container">Blog
					  <input type="checkbox" name="blog[]" value="0">
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Custom Page
					  <input type="checkbox" name="custom[]" value="0">
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Product
					  <input type="checkbox" name="product[]" value="0">
					  <span class="checkmark"></span>
					</label></th>
					
				</tr>
				<tr>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="blog[]" value="1" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="custom[]" value="1" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="product[]" value="1" >
					  <span class="checkmark"></span>
					</label></td>
					
					
				</tr>
				<tr>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="blog[]" value="2" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="custom[]" value="2" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="product[]" value="2" >
					  <span class="checkmark"></span>
					</label></td>
					
					
				</tr>
				<tr>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="blog[]" value="3" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="custom[]" value="3" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="product[]" value="3" >
					  <span class="checkmark"></span>
					</label></td>
					
					
				</tr>
				<tr>
					<th><label class="cb-container">Category
					  <input type="checkbox" name="category[]" value="0">
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Bank
					  <input type="checkbox" name="bank[]" value="0">
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">User
					  <input type="checkbox" name="user[]" value="0">
					  <span class="checkmark"></span>
					</label></th>
				</tr>
				<tr>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="category[]" value="1" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="bank[]" value="1" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="user[]" value="1" >
					  <span class="checkmark"></span>
					</label></td>
				</tr>
				<tr>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="category[]" value="2" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="bank[]" value="2" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="user[]" value="2" >
					  <span class="checkmark"></span>
					</label></td>
				</tr>
				<tr>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="category[]" value="3" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="bank[]" value="3" >
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="user[]" value="3" >
					  <span class="checkmark"></span>
					</label></td>
				</tr>
				<tr>
					<th><label class="cb-container">Refund Control
					  <input type="checkbox" name="refund[]" value="6" >
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Deposit Control
					  <input type="checkbox" name="deposit[]" value="6" >
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Order
					  <input type="checkbox" name="order[]" value="6" >
					  <span class="checkmark"></span>
					</label></th>
				</tr>

				<tr>
					<th><label class="cb-container">Income Prediction
					  <input type="checkbox" name="income[]" value="6" >
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Customer Funds
					  <input type="checkbox" name="funds[]" value="6" >
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">User Opinion
					  <input type="checkbox" name="opinion[]" value="6" >
					  <span class="checkmark"></span>
					</label></th>
				</tr>
				
		

			</table>
		</td>
	</tr>
	<?php } ?>

	<tr>
		<td>
			
			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Save User</button>
		</td>
	</tr>

</table>

</form>