<?php
	
	class subcategory extends load{

		function __construct(){

			$command = "SELECT * FROM db_category WHERE title='".$this->post("title")."' ";
			$query = $this->db()->query($command);
			$fetch = $query->fetch();

			$sub_catgegory = $this->db()->query("SELECT * FROM db_category WHERE level='1' and sublevel='".$fetch['id']."'");

			echo '<select type="text" name="subcategory" class="form-input" style="width: 99.5%" required>';
			
			
				while($show = $sub_catgegory->fetch()){ 
					
					echo '<option>'.$show['title'].'</option>';

				}

			echo '</select>|'.$fetch['title'];

		}

	}