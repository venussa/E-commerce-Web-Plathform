<?php
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<?xml-stylesheet type="text/xsl" href="'.sourceUrl().'/css/main.xsl"?>';

$id = explode("-",splice(2));
$id = $id[count($id)-1];
$id = explode(".",$id);
$id = $id[0];

$query = $this->db()->query("SELECT * FROM db_product WHERE category='".$id."' and status=1 ORDER BY sorting_id DESC");

?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0" xmlns:xhtml="http://www.w3.org/1999/xhtml">

<?php 
while($show = $query->fetch()){ 
$category = $this->db()->query("SELECT title FROM db_category WHERE id='".$show['category']."' ");
$category = $category->fetch();
?>

<url>
<loc><?php echo HomeUrl()?>/<?php echo url_title($category['title'],"-",true)?>/<?php echo url_title($show['title'],"-",true)?>?id=<?php echo $show['sorting_id']?></loc>
<lastmod><?php echo date("Y-m-d",$show['date_time']) ?></lastmod>
<changefreq>Weekly</changefreq>
<priority>0.8</priority>
</url>

<?php } ?>

</urlset>