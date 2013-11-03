<?php 
require_once("dbconn.php");
/***** CONSTANTS ********/

$widgets = [
    "[taglist]" => dpGetTagList(),
    "[tagcloud]" => dpGetTagCloud(),
    "[search]" => dpGetSearchWidget()
];

/***** FUNCTIONS *****/

function dpGetTagList() {
	$return ="<h4>Categories</h4>";
	 $query  = "SELECT * FROM tags order by menuorder asc";
	  $result = mysql_query($query);

	  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  { 
	  	$return .= "<li><a href='".$row['tagslug']."/'>".$row['tagname']."</a></li>";
	  } 
	  return $return;
}


function dpGetTagCloud() {
	return "TagCloud";
}

function dpGetSearchWidget() {
	
}
?>