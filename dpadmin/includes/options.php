<?php
require_once("../includes/dumbpress.php"); 
//ICONS: http://marcoceppi.github.io/bootstrap-glyphicons/
?>


<?php
	if (isset($_POST["sitetitle"])) {
		setOption("sitetitle", $_POST["sitetitle"]);
		setOption("sitelink", $_POST["sitelink"]);
		setOption("headline", $_POST["headline"]);
		setOption("claim", $_POST["claim"]);
		echo "<h4>Saved!</h4>";
	}
	
?>
<fieldset>
<legend><i class="glyphicon glyphicon-cog"></i>Site Options</legend>
<form method="post" action="?action=options">
	<label for="sitetitle">Site Title </label>
	<input type="text" name="sitetitle" value="<?php echo getOption("sitetitle"); ?>">
	<br/>
	<label for="sitetitle">URL </label>
	<input type="text" name="sitelink" value="<?php echo getOption("sitelink"); ?>">
	<br/>
	<label for="headline">Headline </label>
	<input type="text" name="headline" size="60" value="<?php echo getOption("headline"); ?>">
	<br/>
	<label for="headline">Claim </label>
	<input type="text" name="claim" size="60" value="<?php echo getOption("claim"); ?>">
	<br/>
	<input type="submit" value="Save">
</form>
</fieldset>
<br/>
<?php ?>



<?php
	if (isset($_POST["ganalyticsID"])) {
		setOption("ganalyticsID", $_POST["ganalyticsID"]);
		echo "<h4>Saved!</h4>";
	}
	
?>
<fieldset>
<legend><i class="glyphicon glyphicon-signal"></i>Google Analytics</legend>
<form method="post" action="?action=options">
	<label for="ganalyticsID">Google Analytics ID </label>
	<input type="text" name="ganalyticsID" value="<?php echo getOption("ganalyticsID"); ?>"><br>
	<input type="submit" value="Save">
</form>
</fieldset>
<br/>
<?php ?>



<?php
	if (isset($_POST["twitterAccount"])) {
		setOption("twitterAccount", $_POST["twitterAccount"]);
		setOption("instagramAccount", $_POST["instagramAccount"]);
		setOption("facebookPage", $_POST["facebookPage"]);
		
		echo "<h4>Saved!</h4>";
	}
?>
<fieldset>
<legend><i class="glyphicon glyphicon-share"></i>Social Accounts</legend>
<form method="post" action="?action=options">
	<label for="twitterAccount">Twitter username </label>
	<input type="text" name="twitterAccount" value="<?php echo getOption("twitterAccount"); ?>"><br>
	<label for="twitterAccount">Instagram username </label>
	<input type="text" name="instagramAccount" value="<?php echo getOption("instagramAccount"); ?>"><br>
	<label for="facebookPage">Facebook Page</label>
	<input type="text" name="facebookPage" size="60" value="<?php echo getOption("facebookPage"); ?>"><br>
	<input type="submit" value="Save">
</form>
</fieldset>
<br/>
<?php ?>

<?php
	if (isset($_POST["ckfinderlicense"])) {
		setOption("ckfinderlicensename", $_POST["ckfinderlicensename"]);
		setOption("ckfinderlicensekey", $_POST["ckfinderlicensekey"]);
		echo "<h4>Saved!</h4>";
	}
	
?>
<fieldset>
<legend><i class="glyphicon glyphicon-shopping-cart"></i>CKFinder</legend>
<form method="post" action="?action=options">
	<label for="ckfinderlicensename">License Name</label>
	<input type="text" name="ckfinderlicensename" value="<?php echo getOption("ckfinderlicensename"); ?>">
	<br/>
	<label for="ckfinderlicensekey">License Key</label>
	<input type="text" name="ckfinderlicensekey" value="<?php echo getOption("ckfinderlicensekey"); ?>"><br/>
	<input type="submit" value="Save">
</form>
</fieldset>
<br/>
<?php ?>


