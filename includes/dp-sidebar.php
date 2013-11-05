<?php 
require_once("dbconn.php");
require_once("dumbpress.php");
require_once("dp-functions.php");
/***** CONSTANTS ********/

$widgets = [
    "[taglist]" => dpGetTagList(),
    "[tagcloud]" => dpGetTagCloud(),
    "[search]" => dpGetSearchWidget()
];

/***** FUNCTIONS *****/

function dpGetTagList() {
	$return="";
	 $query  = "SELECT * FROM tags order by menuorder asc";
	  $result = mysql_query($query);

	  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  { 
	  	$return .= "<li><a href='".getOption("sitelink")."/arguments/".$row['id']."/".$row['tagslug']."/'>".$row['tagname']."</a></li>";
	  } 
	  return $return;
}


function dpGetTagCloud() {
	return "TODO:TagCloud";
}

function dpGetSearchWidget() {
	return "TODO:Search FORM";
}
?>