<?php 
require("includes/dumbpress.php"); 
dpDebugStart();

if (getOption("enableCaching")=="on") {
    //Page Caching
  $rawurl = $_SERVER['QUERY_STRING'];
  if ($rawurl == "") $rawurl="home";
  //$rawurl = base64_encode($rawurl); 
  $cachefile = "caches/$rawurl.html";
  $cachetime = 5 * 60;

  if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
      include($cachefile);
      dpDebugStop();
      echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
      exit;
  }
  ob_start();  
}




dpHeader(); 
if (!isset($_GET["articleID"]) && !isset($_GET["tagID"])) {
    dpGallery(); 
 } ?>
<div class="row">
  <div class="col-lg-8">
      <?php 
        if (isset($_GET["articleID"])) {
          dpGetArticle($_GET["articleID"]);
        } elseif (isset($_GET["searchKey"])) {
          dpSearch($_GET["searchKey"]);
        } else {
          dpBlogroll((isset($_GET["page"])?$_GET["page"]-1:""),(isset($_GET["tagID"])?$_GET["tagID"]:"")); 
        }
      ?>
  </div>
  <div class="col-lg-4">
    <?php dpSidebar(); ?>
  </div>
</div>
<?php dpFooter(); ?>

<?php
if (getOption("enableCaching")=="on") {
  // Cache the output to a file
  $fp = fopen($cachefile, 'w');
  fwrite($fp, ob_get_contents());
  fclose($fp);
  ob_end_flush();
}
dpDebugStop();
?>