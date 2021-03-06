<?php 
require_once("../includes/dumbpress.php"); 

?>

<?php 
if (isset($_POST["theme"])) { 
	setOption("theme",$_POST["theme"]);
}
?>

<h2>Appearance</h2>
<br/>

<form method="post" action="?action=themes">
<h3><i class="glyphicon glyphicon-eye-open"></i>Current theme: <strong><?php echo getTheme(); ?></strong></h3>
<label for="theme">Select Theme</label>
<select name="theme">
<?php 

$directories = scandir('../themes/');
foreach($directories as $directory){
    if(substr($directory, 0,1) != "."){
    	if (getTheme() == $directory) {
			echo "<option value='$directory' selected >$directory</option>";
    	} else {
    		echo "<option value='$directory' >$directory</option>";	
    	}
        
}
} 
?>
</select>
<br>
<input type="submit" value="Save"/>
<br/>
<br/>



<?php
	if (isset($_POST["galleryTitle"])) {
		setOption("galleryTitle", $_POST["galleryTitle"]);
		setOption("blogrollTitle", $_POST["blogrollTitle"]);	
		setOption("pagesize", $_POST["pagesize"]);		
		echo "<h4>Saved!</h4>";
	}
	
?>

<fieldset>
<legend><i class="glyphicon glyphicon-home"></i>Home page customizations</legend>
<form method="post" action="?action=themes">
	<label for="galleryTitle">Gallery Title </label>
	<input type="text" name="galleryTitle" value="<?php echo getOption("galleryTitle"); ?>"><br>
	<label for="blogrollTitle">BlogRoll Title </label>
	<input type="text" name="blogrollTitle" value="<?php echo getOption("blogrollTitle"); ?>"><br>
	<label for="pagesize">Page Size </label>
	<input type="text" name="pagesize" value="<?php echo getOption("pagesize"); ?>"><br>
	<input type="submit" value="Save">
</form>
</fieldset>
<br/>

<?php
	if (isset($_POST["preArticle"])) {
		setOption("preArticle", $_POST["preArticle"]);
		setOption("postArticle", $_POST["postArticle"]);	
		echo "<h4>Saved!</h4>";
	}
	
?>

<fieldset>
<legend><i class="glyphicon glyphicon-edit"></i>Article page customizations</legend>
<form method="post" action="?action=themes">
	<label for="preArticle">Pre-article HTML code </label>
	<textarea name="preArticle" cols="60" rows="5"><?php echo getOption("preArticle"); ?></textarea><br/><br/>
	<label for="postArticle">Post-article HTML code</label>
	<textarea name="postArticle" cols="60" rows="5"><?php echo getOption("postArticle"); ?></textarea><br/><br/>
	<input type="submit" value="Save">
</form>
</fieldset>
<br/>




<?php
	if (isset($_POST["courtesyPage"])) {
		setOption("enableCourtesyPage", @$_POST["enableCourtesyPage"]);	
		file_put_contents("courtesy.txt", $_POST["courtesyPage"]);
		echo "<h4>Saved!</h4>";
		if (@$_POST["enableCourtesyPage"] == "on") {
		//create index.html
		file_put_contents("../index.html", $_POST["courtesyPage"]);
		} else {
			//delete index.html
			@unlink("../index.html");
		}
	}

	
	
?>



<fieldset>
<legend><i class="glyphicon glyphicon-exclamation-sign"></i>Courtesy Page</legend>
<form method="post" action="?action=themes">
	<label for="enableCourtesyPage">Enable Courtesy Page </label>
	<input type="checkbox" name="enableCourtesyPage" <?php  echo (getOption("enableCourtesyPage") == "on" ?  "checked" :  "");?> >
	<br/>

	<label for="courtesyPage">HTML code</label>
	<textarea name="courtesyPage" cols="90" rows="20"><?php echo @file_get_contents("courtesy.txt"); ?></textarea><br/><br/>
	<input type="submit" value="Save">
</form>
</fieldset>
<br/>



</form>