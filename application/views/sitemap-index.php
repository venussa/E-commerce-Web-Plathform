<?php 
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<?xml-stylesheet type="text/xsl" href="'.sourceUrl().'/css/main.xsl"?>';


?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    <?php 

    $query = $this->db()->query("SELECT * FROM db_category WHERE level=0");

    while($show = $query->fetch()) { 

        $product = ($this->db()->query("SELECT * FROM db_product WHERE category='".$show['id']."' ORDER BY sorting_id DESC LIMIT 1"))->fetch();
        ?>

        <sitemap>
            <loc><?php echo HomeUrl()."/sitemap/".url_title($show['title'],"-",true)?>-<?php echo $show['id']?>.xml</loc>
            <lastmod><?php echo date("Y-m-d",$product['date_time'])?></lastmod>
        </sitemap>

    <?php }   ?>


<?php 

$blog = ($this->db()->query("SELECT * FROM db_custom_page WHERE level=2 and status=1 ORDER BY id DESC LIMIT 1"))->fetch();

?>

    <sitemap>
            <loc><?php echo HomeUrl()."/sitemap/blog.xml"?></loc>
            <lastmod><?php echo date("Y-m-d",$blog['date_time'])?></lastmod>
        </sitemap>
    
</sitemapindex>