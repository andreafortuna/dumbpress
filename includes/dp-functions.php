<?php
/************ UTILITY *************/

function cacheOptions() {
  $options = array();
  $query  = "SELECT * FROM options";
  $result = mysql_query($query);
  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
    $options[] = array($row["optionName"],$row["optionValue"]);
  }
  $_SESSION["options"] = $options;
}


function getOption($option) {
  if (!isset($_SESSION["options"])) cacheOptions();
  //cacheOptions();
  $array = $_SESSION["options"];

   foreach ($array as $key) {       
       if ($key[0] === $option) {
           return $key[1];
       }
   }
   return null;
}



function setOption($option, $value) {
  $option = str_replace("'", "''", $option);
  $value = str_replace("'", "''", $value);
  mysql_query("delete from options where optionName ='$option'");
  mysql_query("insert into options(optionname,optionValue) values ('$option','$value')");
  cacheOptions();
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


/* CACHING */

function loadCache($id) {
  $cachefile = "caches/$id.tmp";
  $cachetime = 5 * 60;
//$cachetime = 0;
  if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
      return file_get_contents($cachefile);
  }
  return "";
}

function saveCache($id,$content) {
  $cachefile = "caches/$id.tmp";
  @file_put_contents($cachefile, $content);
}


?>