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
  $option = str_replace("'", "''", $option);
  $value = str_replace("'", "''", $value);
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

function shrinkTitleSE($title) {
  $title = preg_replace('/[^a-zA-Z0-9\-]/', ' ',  strtolower($title));
  $title = preg_replace('/\s+/', '-', $title); 
  $title = str_replace("---","-",$title);
  $title = trim($title,"-");
  
  return $title;
}


function createPermalink($pagename) {
  $baseurl = getOption("sitelink");
  return $baseurl."/".$pagename;
}

/*
* Article permalink
*/
function createArticlePermalink($articleID,$title) {
  return createPermalink("articles/".$articleID."/".shrinkTitleSE($title).".html");
}


?>