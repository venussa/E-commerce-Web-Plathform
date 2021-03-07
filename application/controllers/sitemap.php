<?php

	class sitemap extends load{

		function home(){

			$query = $this->db()->query("SELECT * FROM db_category WHERE level=0");

			while($show = $query->fetch()){

				$data[] = url_title($show['title'],"-",true)."-".$show['id'].".xml";

			}
			$data[] = "blog.xml";
			$data[] = "sitemap.xml";

			if(empty(splice(2))) {

				header("location:".HomeUrl()."/sitemap/sitemap.xml");
				exit;

			}elseif(!in_array(splice(2),$data)){
				
				header("location:".HomeUrl()."/sitemap/sitemap.xml");
				exit;

			}elseif(splice(2) == "sitemap.xml") $this->view("sitemap-index");

			elseif(splice(2) == "blog.xml") $this->view("sitemap-blog");

			else $this->view("sitemap-data");

		}

	}