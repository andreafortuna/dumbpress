<?php
require_once("../includes/dumbpress.php"); 
//ICONS: http://marcoceppi.github.io/bootstrap-glyphicons/
?>


<?php
	if (isset($_POST["sitetitle"])) {
		setOption("sitetitle", $_POST["sitetitle"]);
		setOption("sitelink", $_POST["sitelink"]);
		setOption("headline", $_POST["headline"]);
		setOption("enableCaching", @$_POST["enableCaching"]);
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
	<label for="claim">Claim </label>
	<input type="text" name="claim" size="60" value="<?php echo getOption("claim"); ?>">
	<br/>

	<label for="enableCaching">Enable caching </label>
	<input type="checkbox" name="enableCaching" <?php  echo (getOption("enableCaching") == "on" ?  "checked" :  "");?> >
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
		setOption("enableAddThisBox", $_POST["enableAddThisBox"]);
		setOption("enablePinterest", $_POST["enablePinterest"]);
		
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
	<label for="enableAddThisBox">Enable AddThis Box </label>
	<input type="checkbox" name="enableAddThisBox" <?php  echo (getOption("enableAddThisBox") == "on" ?  "checked" :  "");?> >
	<br/>
	<label for="enablePinterest">Enable Pinterest </label>
	<input type="checkbox" name="enablePinterest" <?php  echo (getOption("enablePinterest") == "on" ?  "checked" :  "");?> >
	<br/>


	<input type="submit" value="Save">
</form>
</fieldset>
<br/>

<?php
	if (isset($_POST["facebookAppID"])) {
		setOption("facebookAppID", $_POST["facebookAppID"]);
		setOption("facebookAdminID", $_POST["facebookAdminID"]);		
		setOption("enableFBComments", @$_POST["enableFBComments"]);		
		echo "<h4>Saved!</h4>";
	}
	
?>
<fieldset>
<legend><i class="glyphicon glyphicon-globe"></i>OpenGraph</legend>
<form method="post" action="?action=options">
	<label for="ganalyticsID">Facebook APP ID </label>
	<input type="text" name="facebookAppID" value="<?php echo getOption("facebookAppID"); ?>"><br>
	<label for="ganalyticsID">Facebook Admin ID </label>
	<input type="text" name="facebookAdminID" id ="facebookAdminID" value="<?php echo getOption("facebookAdminID"); ?>"> &nbsp; <input type="button" value="Convert Username" onclick="convertUsername();"><br>
	<script>
	function convertUsername() {

		$.getJSON( "http://graph.facebook.com/"+$("#facebookAdminID").val(), function( data ) {
		  $.each( data, function( key, val ) {
		  	if (key=="id") {
		  		$("#facebookAdminID").val(val);
		  	}		   
		  });
		});
	}
	</script>

	<label for="enableFBComments">Enable Facebook Comments </label>
	<input type="checkbox" name="enableFBComments" <?php  echo (getOption("enableFBComments") == "on" ?  "checked" :  "");?> >
	<br/>
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


