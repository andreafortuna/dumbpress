<?php 
require("includes/dumbpress.php"); 
dpHeader(); 
if (!isset($_GET["articleID"]) && !isset($_GET["tagID"])) {
    dpGallery(); 
 } ?>
<div class="row">
  <div class="col-lg-8">
      <?php 
        if (isset($_GET["articleID"])) {
          dpGetArticle($_GET["articleID"]);
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
