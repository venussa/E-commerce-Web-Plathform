
<?php 

$query = $this->db()->query("SELECT * FROM db_users WHERE id='".$this->get("id")."' ");
$show = $query->fetch();

if($show['level'] >= userinfo()->level) {
	$editable = "readonly";
	$style="background:#f5f5f5;";
}else {
	$editable = null;
	$style=null;
}
$role = json_decode($show['role']);
?>

<p style="border-bottom:1px #eee solid;padding-bottom:10px;font-size:14px"><i>" Menu untuk merubah user. Pastikan semua data telah terisi dengan baik "</i></p>

<form method="POST" action="<?php echo HomeUrl()?>/adminpanel/edit_users?id=<?php echo $show['id']?>" enctype="multipart/form-data">
<table width="100%" style="">
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">First Name</p>
			<p class="t2">* Nama Depan</p>
		
		<input type="text" name="first_name" class="form-input" required value="<?php echo $show['first_name']?>" style="<?php echo $style?>" <?php echo $editable?>></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Last Name</p>
			<p class="t2">* Nama Belakang</p>
		
		<input type="text" name="last_name" class="form-input" value="<?php echo $show['last_name']?>" style="<?php echo $style?>" <?php echo $editable?>></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Gender</p>
			<p class="t2">* Jenis Kelamin</p>
		<div id="child-category-select">

			<?php if($show['level'] < userinfo()->level){ ?>
			<select type="text" name="gender" class="form-input" style="width: 99.5%" required <?php echo $editable?>>

				<?php if(strtolower($show['gender']) == "laki - laki") {?>
				
				<option>Laki - laki</option>
				<option>Perempuan</option>
				
				<?php }else{ ?>

				<option>Perempuan</option>
				<option>Laki - laki</option>
				
				<?php } ?>
			</select>
			<?php }else{ ?>

				<input type="text" name="gender" class="form-input" required value="<?php echo $show['gender']?>" style="<?php echo $style?>" <?php echo $editable?>>

			<?php } ?>
		</div>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Address</p>
			<p class="t2">* Alamat tempat tinggal</p>
		
		<textarea type="text" name="address" class="form-input" rows="2" style="width: 94%;font-size: 13px;<?php echo $style?>" required <?php echo $editable?>><?php echo $show['address']?></textarea></td>
	</tr>



	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Provinsi</p>
		


			<?php if($show['level'] < userinfo()->level){ ?>
			<select name="province" class="form-input" style="width: 99.5%" <?php echo $editable?>>
				<?php 

					foreach(provinsi() as $key => $value){

						if($value == $show['province'])
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(provinsi() as $key => $value){

						if($value !== $show['province'])
						echo "<option value='$key'>$value</option>";

						else $kode = $key;

					}

				?>
				</select>
			<?php }else{ ?>

				<input type="text" name="province" class="form-input" required value="<?php echo $show['province']?>" style="<?php echo $style?>" <?php echo $editable?>>

			<?php } ?>
			
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kabupaten / Kota</p>
		


			<?php if($show['level'] < userinfo()->level){ ?>
			<select name="state" class="form-input" style="width: 99.5%" <?php echo $editable?>>
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value == $show['state'])
						echo "<option value='$key'>$value</option>";

					}

				?>
				<?php 

					foreach(kabupaten($kode) as $key => $value){

						if($value !== $show['state'])
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>
		<?php }else{ ?>
			<input type="text" name="state" class="form-input" required value="<?php echo $show['state']?>" style="<?php echo $style?>" <?php echo $editable?>>
		<?php } ?>
		</td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kecamatan</p>
		


			<?php if($show['level'] < userinfo()->level){ ?>
			<select name="district" class="form-input" style="width: 99.5%" <?php echo $editable?>>

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value == $show['district'])
						echo "<option value='$key'>$value</option>";

					}

				?>

				<?php 

					foreach(kecamatan($kode) as $key => $value){

						if($value !== $show['district'])
						echo "<option value='$key'>$value</option>";
						else $kode = $key;

					}

				?>
			</select>
			<?php }else{ ?>
			<input type="text" name="district" class="form-input" required value="<?php echo $show['district']?>" style="<?php echo $style?>" <?php echo $editable?>>
		<?php } ?>
		</td>
	</tr>


	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Kode Pos</p>
		
		<input type="text" name="zip_code" class="form-input" required value="<?php echo $show['zip_code']?>" readonly="" style="background: #f5f5f5"></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Email</p>
			<p class="t2">* Email aktif pengguna</p>
		
		<input type="email" style="background: #f5f5f5" readonly=""  class="form-input" required value="<?php echo $show['email']?>" <?php echo $editable?>></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Phone Number</p>
			<p class="t2">* Nomor telephone yang dapat dihubungi</p>
		
		<input type="text" style="background: #f5f5f5" readonly="" class="form-input" required value="<?php echo $show['phone_number']?>" <?php echo $editable?>></td>
	</tr>

	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Username</p>
		
		<input type="text" style="background: #f5f5f5" readonly=""  class="form-input" required value="<?php echo $show['username']?>" <?php echo $editable?>></td>
	</tr>


	
	<tr>
		<td class="tr" style="width: 200px;">
			<p class="t1">Level Access</p>
			<p class="t2"></p>
		<div id="child-category-select">

			<?php if($show['level'] < userinfo()->level){ ?>

			<select type="text" name="level" class="form-input" onChange="return role_access(this)" style="width: 99.5%" required <?php echo $editable?>>

				<?php if($show['level'] == 0) {$level_access="Customer";?>
				
				<option>Customer</option>
				<option>Suplier</option>
				<?php if(userinfo()->level > 2) echo "<option>Admin</option>"; ?>
				
				<?php }elseif($show['level'] == 1){$level_access="Suplier";?>

				<option>Suplier</option>
				<option>Customer</option>
				<?php if(userinfo()->level > 2) echo "<option>Admin</option>"; ?>

				<?php }elseif($show['level'] == 2){$level_access="Admin";?>

				<option>Admin</option>
				<option>Suplier</option>
				<option>Customer</option>

				<?php }else $level_access="Administrator"; ?>
			</select>
		<?php }else{ 

			if($show['level'] == 0)
				$level_access="Customer";

			elseif($show['level'] == 1)
				$level_access="Suplier";

			elseif($show['level'] == 2)
				$level_access="Admin";

			else $level_access="Administrator"; 
			?>

			<input type="text" style="background: #f5f5f5" readonly=""  class="form-input" required value="<?php echo $level_access?>" <?php echo $editable?>>

		<?php }?>
		</div>
		</td>
	</tr>

	<?php if(($show['level'] == 2) and (userinfo()->level >= 3)){ ?>
	<tr class="role-access" >
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
					  <input type="checkbox" name="blog[]" value="1" <?php check_role(1, $role->blog)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="custom[]" value="1" <?php check_role(1, $role->custom)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="product[]" value="1" <?php check_role(1, $role->product)?>>
					  <span class="checkmark"></span>
					</label></td>
					
					
				</tr>
				<tr>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="blog[]" value="2" <?php check_role(2, $role->blog)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="custom[]" value="2" <?php check_role(2, $role->custom)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="product[]" value="2" <?php check_role(2, $role->product)?>>
					  <span class="checkmark"></span>
					</label></td>
					
					
				</tr>
				<tr>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="blog[]" value="3" <?php check_role(3, $role->blog)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="custom[]" value="3" <?php check_role(3, $role->custom)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="product[]" value="3" <?php check_role(3, $role->product)?>>
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
					  <input type="checkbox" name="category[]" value="1" <?php check_role(1, $role->category)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="bank[]" value="1" <?php check_role(1, $role->bank)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Create
					  <input type="checkbox" name="user[]" value="1" <?php check_role(1, $role->user)?>>
					  <span class="checkmark"></span>
					</label></td>
				</tr>
				<tr>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="category[]" value="2" <?php check_role(2, $role->category)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="bank[]" value="2" <?php check_role(2, $role->bank)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Update
					  <input type="checkbox" name="user[]" value="2" <?php check_role(2, $role->user)?>>
					  <span class="checkmark"></span>
					</label></td>
				</tr>
				<tr>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="category[]" value="3" <?php check_role(3, $role->category)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="bank[]" value="3" <?php check_role(3, $role->bank)?>>
					  <span class="checkmark"></span>
					</label></td>
					<td><label class="cb-container">Delete
					  <input type="checkbox" name="user[]" value="3" <?php check_role(3, $role->user)?>>
					  <span class="checkmark"></span>
					</label></td>
				</tr>
				<tr>
					<th><label class="cb-container">Refund Control
					  <input type="checkbox" name="refund[]" value="6" <?php check_role(6, $role->refund)?>>
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Deposit Control
					  <input type="checkbox" name="deposit[]" value="6" <?php check_role(6, $role->deposit)?>>
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Order
					  <input type="checkbox" name="order[]" value="6" <?php check_role(6, $role->order)?>>
					  <span class="checkmark"></span>
					</label></th>
				</tr>

				<tr>
					<th><label class="cb-container">Income Prediction
					  <input type="checkbox" name="income[]" value="6" <?php check_role(6, $role->income)?>>
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">Customer Funds
					  <input type="checkbox" name="funds[]" value="6" <?php check_role(6, $role->funds)?>>
					  <span class="checkmark"></span>
					</label></th>
					<th><label class="cb-container">User Opinion
					  <input type="checkbox" name="opinion[]" value="6" <?php check_role(6, $role->opinion)?>>
					  <span class="checkmark"></span>
					</label></th>
				</tr>
				
		

			</table>
		</td>
	</tr>
	<?php } ?>

	<?php if($show['level'] < userinfo()->level) { ?>
	<tr>
		<td>

			<div style="border-top:2px #ddd dashed;height:20px;margin-top:20px;"></div>
			<button class="btn-white" type="submit" style="cursor:pointer;padding: 10px;font-size: 15px;">Save User</button>
		</td>

	<?php } ?>

	</tr>

</table>

</form>