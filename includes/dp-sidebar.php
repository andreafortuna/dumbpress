<?php 
//error_reporting(E_ALL);
require_once("dbconn.php");
require_once("dumbpress.php");
require_once("dp-functions.php");
/***** CONSTANTS ********/

$widgets = [
    "[taglist]" => "dpGetTagList",
    "[tagcloud]" => "dpGetTagCloud",
    "[search]" => "dpGetSearchWidget",
    "[facebook]" => "dpFacebookWidget",
    "[instagram]" => "dpInstagramWidget",
    "[twitter]" => "dpTwitterWidget"
];

/***** FUNCTIONS *****/

function dpGetTagList() {

	$cachedContent = loadCache("taglistWidget");
	if ($cachedContent != "") return $cachedContent;

	$return="";
	 $query  = "SELECT * FROM tags order by menuorder asc";
	  $result = mysql_query($query);

	  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  { 
	  	$return .= "<li><a href='".getOption("sitelink")."/arguments/".$row['id']."/".$row['tagslug']."/'>".$row['tagname']."</a></li>";
	  } 
	  saveCache("taglistWidget", $return);
	  return $return;
}


function dpGetTagCloud() {
	return "TODO:TagCloud";
}

function dpGetSearchWidget() {
	$return = "<form onsubmit='return doSearch();'>
				<input type='text' id='searchKey' name='searchKey'>
				<input type='submit' value='Search'>
				</form>
<script>
function doSearch() {

	window.location.replace('".getOption("sitelink")."/search/'+$('#searchKey').val());
	return false;
}
</script>
				";
	return $return;
}

function dpInstagramWidget() { 

	$cachedContent = loadCache("instagramWidget");
	if ($cachedContent != "") return $cachedContent;

	$return ="<a href='http://instagram.com/".getOption("instagramAccount")."/' target=_blank><div class='instagramWidget' >";

	if (!isset($_SESSION["instagramWidget"])) {

		$url = 'http://followgram.me/'.getOption("instagramAccount").'/rss';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$data = curl_exec($curl);
		curl_close($curl);

		$content = utf8_encode($data);
		$xmlObject = simplexml_load_string($content);
		$_SESSION["instagramWidget"] = $xmlObject->asXML(); 
		//echo "instagram cached";	
	} 

	$rss = new SimpleXMLElement($_SESSION["instagramWidget"]);

	$counter = 0;
	foreach ($rss->channel->item as $item) {
	   $return .= $item->description;
	   $counter++;
	   if ($counter>=5) break;
	} 
	$return .= "</div></a>";

	saveCache("instagramWidget", $return);
	
	return $return;
}

function dpFacebookWidget() { 
	return "<iframe src='//www.facebook.com/plugins/likebox.php?href=".urlencode(getOption("facebookPage"))."&amp;width&amp;height=230&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=false&amp;appId=461819973910856' scrolling='no' frameborder='0' style='border:none; overflow:hidden; height:230px;' allowTransparency='true'></iframe>";
}

function dpTwitterWidget() {
	return "<a class=\"twitter-timeline\" href=\"https://twitter.com/".getOption("twitterAccount")."\" data-widget-id=\"305608819323576321\" data-screen-name=\"".getOption("twitterAccount")."\">Tweets di @".getOption("twitterAccount")."</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\"://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>";
}



?>