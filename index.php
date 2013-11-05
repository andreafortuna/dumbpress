<?php 
require("includes/dumbpress.php"); 
?>
<?php dpHeader(); 
if (!isset($_GET["articleID"]) && !isset($_GET["tagID"])) {?>
      <h1><?php echo getOption("galleryTitle");?></h1>
      <hr>
      <div class="row">
       <?php dpGallery(); ?>
      </div>

	<br/>
<?php } ?>
<div class="row">
  <div class="col-lg-8">
      <?php 
        if (isset($_GET["articleID"])) {
          dpGetArticle($_GET["articleID"]);
        } else { ?>

        <?php  dpBlogroll((isset($_GET["page"])?$_GET["page"]-1:""),(isset($_GET["tagID"])?$_GET["tagID"]:"")); 
        }
      ?>
  </div>

  <div class="col-lg-4">
    <?php dpSidebar(); ?>
  </div>

</div>
<?php dpFooter(); ?>
