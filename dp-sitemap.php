<?php
header("Content-Type: text/xml;charset=iso-8859-1");
include("includes/dumbpress.php");
$page = @$_GET['p'];
if ($page == "") $page = 0;
$page = $page * 10000;
$query = "select * from articles where pubdate < now()  limit ".$page.",10000" ;
$num_rows = mysql_num_rows(mysql_query($query));  
$result = mysql_query($query) or die("Query failed");
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
	for($i=0;$i<$num_rows; $i++)
	{
		$url_product =  createArticlePermalink(mysql_result($result,$i,"id"),mysql_result($result,$i,"title"));	
		$date = mysql_result($result,$i,"pubdate"); 
		$year = substr($date,0,4); 
		$mon  = substr($date,5,2); 
		$day  = substr($date,8,2); 
		$displaydate = ''.$year.'-'.$mon.'-'.$day.'';
		echo 
		'<url>
			<loc>'.$url_product.'</loc>
			<lastmod>'.$displaydate.'</lastmod>
			<changefreq>yearly</changefreq>
			<priority>0.8</priority>
			</url>';
	}
	echo '</urlset>';
	mysql_close(); 
?>