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

/*********** ARTICLES FUNCTIONS *********/

/*
* DumbPress getArticle
*/

function dpGetArticle($articleID) {
  
  $query  = "SELECT * FROM articles where id=$articleID";
    $result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  ?>
  <article>
    <header>
    <h1><?php echo $row['title']; ?></h1>
    <h3><?php echo $row['excerpt']; ?></h3>
    <p>
    <div class="postGallery">
    <?php if ($row['cover_image_1'] != "") { ?> <a class="group1" href="<?php echo $row['cover_image_1']; ?>"><img src="<?php echo $row['cover_image_1']; ?>" class="postGalleryImg"></a><?php } ?>
    <?php if ($row['cover_image_2'] != "") { ?> <a class="group1" href="<?php echo $row['cover_image_2']; ?>"><img src="<?php echo $row['cover_image_2']; ?>" class="postGalleryImg"></a><?php } ?>
    <?php if ($row['cover_image_3'] != "") { ?> <a class="group1" href="<?php echo $row['cover_image_3']; ?>"><img src="<?php echo $row['cover_image_3']; ?>" class="postGalleryImg"></a><?php } ?>
    </div>
    </p>    
    </header>
    <p>
    <?php 
    echo getOption("preArticle");
    echo $row['content']; 
    echo getOption("postArticle");
    ?>
    </p>
    <footer>Posted <?php echo $row['pubdate']; ?>&nbsp; in <?php echo getTags($row['id']); ?></footer>
  </article>
  <?php
  } 
} 

function dpCreateArticle($title,$content,$pubdate,$excerpt,$gallery,$cover_image_1,$cover_image_2,$cover_image_3,$state,$tags) {
  $query  = "insert into articles(gallery,title,content,pubdate,excerpt,cover_image_1,cover_image_2,cover_image_3,state) values($gallery,'$title','$content','$pubdate','$excerpt','$cover_image_1','$cover_image_2','$cover_image_3',$state)";
  //echo $query;
  $result = mysql_query($query);
  //Get inserted ID
  $result = mysql_query("SELECT * FROM articles WHERE id = LAST_INSERT_ID();");
  $row = mysql_fetch_array($result);
  $lastinsertid = $row["id"];
  //Remove old tags
  mysql_query("delete from articles_tags where articleID=$lastinsertid");
  // Saving TAGS
    for ($i=0; $i<count($tags); $i++) {
        mysql_query("insert into articles_tags (articleID,tagID) values (".$lastinsertid.",".$tags[$i].")");
    }

  return $result;
}

function dpDeleteArticle($articleID) {
  mysql_query("delete from articles where id=$articleID");
}

function dpUpdateArticle($articleID,$title,$content,$pubdate,$excerpt,$gallery,$cover_image_1,$cover_image_2,$cover_image_3,$state,$tags) {
  $query  = "update articles set gallery=$gallery,title='$title',content='$content',pubdate='$pubdate',excerpt='$excerpt',cover_image_1='$cover_image_1',cover_image_2='$cover_image_2',cover_image_3='$cover_image_3',state=$state where id=$articleID";
  //echo $query;
  $result = mysql_query($query);
  //Remove old tags
  mysql_query("delete from articles_tags where articleID=$articleID");
  // Saving TAGS
    for ($i=0; $i<count($tags); $i++) {
        mysql_query("insert into articles_tags (articleID,tagID) values (".$articleID.",".$tags[$i].")");
    }

  return $result;
}

function getTags($articleID) {
  $return ="";
  $query  = "SELECT * FROM `tags` inner join articles_tags on articles_tags.tagID=tags.id where articleID=$articleID";
  $result = mysql_query($query);
  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
    $return .= "<a href='".getOption("sitelink")."/arguments/".$row['id']."/".$row['tagslug']."/'>".$row['tagname']."</a>";
  }
  
  return $return;
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

function clearCaches() {
  $return ="<ul>";
  foreach (new DirectoryIterator('../caches') as $fileInfo) {
      if(!$fileInfo->isDot()) {
        unlink("../caches/".$fileInfo->getFilename());
        $return .= "<li>".$fileInfo->getFilename()." - <font color=red>REMOVED</font>"; 
      }
  }
  $return .="</ul>";
  return $return;
}

?>