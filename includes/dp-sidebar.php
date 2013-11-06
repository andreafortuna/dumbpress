<?php 
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
	return "TODO:Search FORM";
}

function dpInstagramWidget() { 

	$cachedContent = loadCache("instagramWidget");
	if ($cachedContent != "") return $cachedContent;

	$return ="<a href='http://instagram.com/".getOption("instagramAccount")."/' target=_blank><div class='instagramWidget' >";

	if (!isset($_SESSION["instagramWidget"])) {
		$xmlObject = simplexml_load_file('http://followgram.me/'.getOption("instagramAccount").'/rss');
		$_SESSION["instagramWidget"] = $xmlObject->asXML(); 
		//echo "instagram cached";	
	} 

	$rss = new SimpleXMLElement($_SESSION["instagramWidget"]);//simplexml_load_file('http://followgram.me/andrea_fortuna/rss');

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