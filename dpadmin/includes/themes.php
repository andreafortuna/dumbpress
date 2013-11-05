<?php 
require_once("../includes/dumbpress.php"); 

?>

<?php 
if (isset($_POST["theme"])) { 
	setOption("theme",$_POST["theme"]);
}
?>

<h2>Appereance</h2>
<br/>

<form method="post" action="?action=themes">
<h3>Current theme: <strong><?php echo getTheme(); ?></strong></h3>
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
<input type="submit" value="Save"/>
<br/>
<br/>



<?php
	if (isset($_POST["galleryTitle"])) {
		setOption("galleryTitle", $_POST["galleryTitle"]);
		setOption("blogrollTitle", $_POST["blogrollTitle"]);		
		echo "<h4>Saved!</h4>";
	}
	
?>

<fieldset>
<legend>Home page customizations</legend>
<form method="post" action="?action=themes">
	<label for="galleryTitle">Gallery Title </label>
	<input type="text" name="galleryTitle" value="<?php echo getOption("galleryTitle"); ?>"><br>
	<label for="blogrollTitle">BlogRoll Title </label>
	<input type="text" name="blogrollTitle" value="<?php echo getOption("blogrollTitle"); ?>"><br>
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
<legend>Article page customizations</legend>
<form method="post" action="?action=themes">
	<label for="preArticle">Pre-article HTML code </label>
	<textarea name="preArticle" cols="60" rows="5"><?php echo getOption("preArticle"); ?></textarea><br/><br/>
	<label for="postArticle">Post-article HTML code</label>
	<textarea name="postArticle" cols="60" rows="5"><?php echo getOption("postArticle"); ?></textarea><br/><br/>
	<input type="submit" value="Save">
</form>
</fieldset>
<br/>



</form>