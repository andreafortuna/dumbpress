<?php

require("../../includes/dumbpress.php");

$result = mysql_query("select *  from articles where pubdate <= now() and state=1");

$totalComments = 0;
$totalShare =0;

while($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	$url = createArticlePermalink($row['id'],$row['title']);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://graph.facebook.com/?ids=' . $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	$data = curl_exec($curl);
	curl_close($curl);

	$json = json_decode($data);
  	$totalComments += @($json->$url->comments) ? $json->$url->comments : 0;
  	$totalShare += @($json->$url->shares) ? $json->$url->shares : 0;
  	//echo "URL:$url - Shares:".@(($json->$url->shares) ? $json->$url->shares : 0)." - Comments:".(@($json->$url->comments) ? $json->$url->comments : 0)."<br>";
}

echo $totalShare."-".$totalComments;
setOption("facebookShares",$totalShare);
setOption("facebookComments",$totalComments);

?>