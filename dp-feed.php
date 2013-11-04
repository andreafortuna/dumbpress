<?php 
require ("includes/dumbpress.php");
header("Content-Type: application/xml; charset=utf-8");  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>

<rss version="2.0">
  <channel>
    <title><?php echo getOption("sitetitle"); ?></title>
    <link><?php echo getOption("sitelink"); ?></link>
    <description><?php echo getOption("headline"); ?></description>
    <language>IT-it</language>
    <pubDate><?php echo (gmdate(DATE_RFC822));?></pubDate>
    <lastBuildDate><?php echo (gmdate(DATE_RFC822));?></lastBuildDate> 
    <generator><?php echo getOption("siteurl"); ?></generator>
    <managingEditor><?php echo getOption("webmasterEmail"); ?></managingEditor>
    <webMaster><?php echo getOption("webmasterEmail"); ?></webMaster>
<?php 



$query = "select * from articles";
$query = $query." order by pubdate desc ";
$query = $query."  limit 0,20";


?>
<?php
$result =mysql_query($query);
while ($row=mysql_fetch_array($result)) 
{
$title = $row['title'];
$title = htmlspecialchars($title);
$description = $row['excerpt'];

?><item>
      <title><?php echo ($title); ?></title>
      <link><?php echo createArticlePermalink($row['id'],$row['title']);?></link>
      <description><?php echo ($description); ?></description>
      <pubDate><?php echo (date(DATE_RFC822,strtotime($row['pubdate']))); ?></pubDate>
      <guid><?php echo createPermalink("?articleID=".$row["id"]);?></guid>
    </item><?php } ?>
  </channel>
</rss>
