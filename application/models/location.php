<?php
	
	class location extends load{

		function __construct(){

			if(empty($this->get("price")))
			echo $this->show_location($this->post("q"));

			else echo $this->price($this->post("q"));

		}

		function price(){
			return "Rp ".number_format(
							delivery_cost(
								setting()->distributor_location,
								$this->post("q"),
								$this->post("w")
							)[0]->price);
		}

		function show_location($search = null){

			if(!empty($search)) $q = " and (name like '%".$search."%')";
			else $q = null;

			$query = $this->db()->query("SELECT * FROM db_location WHERE type='kabupaten' $q");

			while ($show = $query->fetch()) {

				$parent = $this->db()->query("SELECT * FROM db_location WHERE loc_id='".$show['parrent']."' ");
				$parent = $parent->fetch();

				$data[] = '<li class="type_sorting_btn" onClick="return get_price(this)" style="text-align:left;font-size:12px;height:30px;" name="'.$show['name'].'" loc_id="'.$show['loc_id'].'">
				<span>'.$show['name'].'<p style="font-size:8px;color:#fe4c50;margin-top:-13px">'.$parent['name'].'</p></span>
				
				</li>';
			}

			return implode(null,$data);

		}

	}
?>
