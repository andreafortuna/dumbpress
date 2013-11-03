<?php 
require("includes/dumbpress.php"); 
?>
<?php dpHeader(); 
if (!isset($_GET["articleID"])) {?>
      <h1>Le ultime ricette...</h1>
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
          <h1>Blogroll</h1>
          <hr>
        <?php  dpBlogroll(); 
        }
      ?>
  </div>

  <div class="col-lg-4">
    <?php dpSidebar(); ?>
  </div>

</div>
<?php dpFooter(); ?>
