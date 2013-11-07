<?php
header("Content-Type: text/xml;charset=iso-8859-1");

include("includes/dumbpress.php");
$page = @$_GET['p'];
if ($page == "") $page = 0;

$page = $page * 10000;


$query = "select * from articles limit ".$page.",10000" ;


//count all the articles that are current and published
$num_rows = mysql_num_rows(mysql_query($query));  

//select them and put them into a dataset called $result

$result = mysql_query($query) or die("Query failed");


//this is the normal header applied to any Google sitemap.xml file
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';


	//loop through the entire resultset
	for($i=0;$i<$num_rows; $i++)
	{
		$url_product =  createArticlePermalink(mysql_result($result,$i,"id"),mysql_result($result,$i,"title"));

		//$immagine = "http://static.bnotizie.net/images/full/".base64_encode(mysql_result($result,$i,"image")).".png";
		/*you need to assign a date to the entity.  if you don't 
		store a timestamp in the Database then you need slapping*/
		
		$date = mysql_result($result,$i,"pubdate"); //the date stored
	
		$year = substr($date,0,4); //work out the year
		$mon  = substr($date,5,2); //work out the month
		$day  = substr($date,8,2); //work out the day
		
		/*display the date in the format Google expects:
		2006-01-29 for example*/
		
		$displaydate = ''.$year.'-'.$mon.'-'.$day.'';
						
		//you can assign whatever changefreq and priority you like
		echo 
		'<url>
			<loc>'.$url_product.'</loc>
			<lastmod>'.$displaydate.'</lastmod>
			<changefreq>yearly</changefreq>
			<priority>0.8</priority>
			</url>';
		
		
	}

	//close the XML attribute that we opened in #3
	echo '</urlset>';

	mysql_close(); //close connection
?>