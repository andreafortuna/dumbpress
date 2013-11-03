<?php
/************ UTILITY *************/
function getOption($option) {
  //TODO: caching system
  //DB Caching - TBD
  $returnvalue="";
  $query  = "SELECT * FROM options where optionName='".$option."'";
  
  $result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  	$returnvalue=$row['optionValue'];
  }
  return $returnvalue;
}
function setOption($option, $value) {
  mysql_query("delete from options where optionName ='$option'");
  mysql_query("insert into options(optionname,optionValue) values ('$option','$value')");
}

function getTheme(){
	$theme = getOption("theme");
	if ($theme=="") $theme="default";
	return $theme;
}



/*
* PERMALINK MANAGER
*/
function createPermalink($pagename) {
  $baseurl = getOption("sitelink");
  return $baseurl."/".$pagename;
}

/*
* TODO: make function for article's permalinks creation
*/
?>