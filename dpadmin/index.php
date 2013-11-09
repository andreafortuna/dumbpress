<?php require("includes/header.php"); ?>
<div class="row">
  <div class="col-lg-2">
		<?php require("includes/sidebar.php"); ?>
  </div>


  <div class="col-lg-10">
<?php

	if (isset($_GET["action"])) {
		require("includes/".$_GET["action"].".php");	
	} else {
		include("includes/home.php");
	}
?>
  </div>


</div>


<?php require("includes/footer.php"); ?>