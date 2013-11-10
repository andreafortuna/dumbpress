<script>

var popupBlockerChecker = {
        check: function(popup_window,id){
            var _scope = this;
            if (popup_window) {
                if(/chrome/.test(navigator.userAgent.toLowerCase())){
                    setTimeout(function () {
                        _scope._is_popup_blocked(_scope, popup_window,id);
                     },200);
                }else{
                    popup_window.onload = function () {
                        _scope._is_popup_blocked(_scope, popup_window,id);
                    };
                }
            }else{
                _scope._displayError();
            }
        },
        _is_popup_blocked: function(scope, popup_window,id){
            if ((popup_window.innerHeight > 0)==false){ 
            	scope._displayError(); 
            } else {
            	window.location.href="?action=posts&edit=" + id;
            }
        },
        _displayError: function(){
            alert("Popup Blocker is enabled! Please add this site to your exception list.");
        }
    };




	function preview(id) {
		var pop = window.open("../index.php?articleID="+id,null,"height=700,width=1000,status=yes,toolbar=no,menubar=no,location=no");	
		popupBlockerChecker.check(pop,id);

	}
</script>

<?php 

require_once("../includes/dumbpress.php");



?>

<?php if (isset($_GET["delete"])) { 
	dpDeleteArticle($_GET["delete"]); 
}
?>


<?php if (isset($_GET["editid"]) || isset($_GET["preview"])) { 
	$editid = $_GET["editid"];

	$gallery = (isset($_POST['gallery']) && $_POST['gallery'] == "on" ? "1" : "0"); 
  	$title = $_POST['title']; 
  	$content = $_POST['content']; 
  	$pubdate = $_POST['pubdate']; 
  	$excerpt = $_POST['excerpt']; 
  	$state = $_POST['state']; 
  	$cover_image_1 = $_POST['cover_image_1']; 
  	$cover_image_2 = $_POST['cover_image_2']; 
  	$cover_image_3 = $_POST['cover_image_3']; 
	$tags =$_POST["tag_group"];

	dpUpdateArticle($editid,$title,$content,$pubdate,$excerpt,$gallery,$cover_image_1,$cover_image_2,$cover_image_3,$state,$tags);
	if (isset($_POST["preview"])) {
		echo "<script>preview($editid)</script>";
		
	}

} ?>

<?php 


if (isset($_GET["save"])) { 
	$gallery = (isset($_POST['gallery']) && $_POST['gallery'] == "on" ? "1" : "0"); 
  	$title = $_POST['title']; 
  	$content = $_POST['content']; 
  	$pubdate = $_POST['pubdate']; 
  	$excerpt = $_POST['excerpt']; 
  	$state = $_POST['state']; 
  	if (isset($_POST["preview"])) $state=0;
  	$cover_image_1 = $_POST['cover_image_1']; 
  	$cover_image_2 = $_POST['cover_image_2']; 
  	$cover_image_3 = $_POST['cover_image_3']; 
	$tags =$_POST["tag_group"];

	$insertedid = dpCreateArticle($title,$content,$pubdate,$excerpt,$gallery,$cover_image_1,$cover_image_2,$cover_image_3,$state,$tags);
	
	if (isset($_POST["preview"])) {
		echo "<script>preview($insertedid)</script>";
		
	}

} ?>




<?php 
/******************************
****** ARTICLE EDITING ********
*******************************/
if (isset($_GET["edit"])) { ?>
	<h1>Article editing</h1>
		<?php
		  $editid = $_GET["edit"];
		  $query  = "SELECT * FROM articles where id=".$editid;
		  $result = mysql_query($query);

		  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		  {
			$gallery = $row['gallery']; 
		  	$title = $row['title']; 
		  	$content = $row['content']; 
		  	$pubdate = $row['pubdate']; 
		  	$excerpt = $row['excerpt']; 
		  	$state = $row['state']; 
		  	$cover_image_1 = $row['cover_image_1']; 
		  	$cover_image_2 = $row['cover_image_2']; 
		  	$cover_image_3 = $row['cover_image_3']; 
		  }
		?>


	<form method="post" action="?action=posts&editid=<?php echo $editid; ?>">
	<label for="title">Title</label>
	<input type="text" name="title" value="<?php echo $title; ?>" size=50>
	<br/>
	<textarea class="ckeditor" cols="80" id="editor1" name="content" rows="10">
	<?php echo $content; ?>
	</textarea>
	<br/>
	<label for="excerpt">Excerpt</label>
	<textarea cols="50" id="excerpt" name="excerpt" rows="2"><?php echo $excerpt; ?></textarea>
	<br/><br/>
	<label for="pubdate">PubDate</label>
	<input type="date" name="pubdate" value="<?php echo $pubdate; ?>">
	<br/><br/>
	<label for="pubdate">In Gallery</label>
	<input type="checkbox" name="gallery" <?php echo ($gallery == "1" ? "checked" : "") ; ?>>
	<br/><br/>

	<script type="text/javascript">
	function BrowseServer1()
	{
		var finder = new CKFinder();
		finder.basePath = './ckfinder/';	
		finder.selectActionFunction = SetFileField1;
		finder.popup();
	}
	function SetFileField1( fileUrl )
	{
		document.getElementById( 'coverimage1' ).value = fileUrl;
	}

	function BrowseServer2()
	{
		var finder = new CKFinder();
		finder.basePath = './ckfinder/';	
		finder.selectActionFunction = SetFileField2;
		finder.popup();
	}
	function SetFileField2( fileUrl )
	{
		document.getElementById( 'coverimage2' ).value = fileUrl;
	}

	function BrowseServer3()
	{
		var finder = new CKFinder();
		finder.basePath = './ckfinder/';	
		finder.selectActionFunction = SetFileField3;
		finder.popup();
	}
	function SetFileField3( fileUrl )
	{
		document.getElementById( 'coverimage3' ).value = fileUrl;
	}
	</script>

	<fieldset>

	<label for="cover_image_1">Cover Image 1</label>
	<input type="text" name="cover_image_1" id="coverimage1" value="<?php echo $cover_image_1; ?>"><input type="button" value="Browse Server" onclick="BrowseServer1();" /><br/>
	<label for="cover_image_2">Cover Image 2</label>
	<input type="text" name="cover_image_2" id="coverimage2" value="<?php echo $cover_image_2; ?>"><input type="button" value="Browse Server" onclick="BrowseServer2();" /><br/>
	<label for="cover_image_3">Cover Image 3</label>
	<input type="text" name="cover_image_3" id="coverimage3" value="<?php echo $cover_image_3; ?>"><input type="button" value="Browse Server" onclick="BrowseServer3();" /><br/>
	</fieldset>
	<br/>
	<label for="state">State</label>
	<select name="state">
	<option value=0 <?php echo ($state == "0" ? "selected" : "") ; ?>>Draft</option>
	<option value=1 <?php echo ($state == "1" ? "selected" : "") ; ?>>Online</option>
	</select>

	<br/>
	<label for="tag_group">Tags</label>
	<div style="width:200px;height:100px;overflow:auto;border:1px solid #ddd;padding:10px;">
	<?php
	  $query  = "SELECT * FROM tags";
	  $result = mysql_query($query);
	  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) { ?>
		<input type="checkbox" name="tag_group[]" value="<?php echo $row["id"] ?>" 
		<?php
			$Cresult = mysql_query("SELECT count(*) as C FROM articles_tags WHERE articleID = $editid and tagID=".$row["id"].";");
			$Crow = mysql_fetch_array($Cresult);
			if ($Crow["C"]>0) {
				echo " checked "; 
			}
		?>
		/><?php echo $row["tagname"]; ?><br />
	<?php } ?>

	</div>

	<br/>
	<input type="submit" value="Save">
	<input type="submit" value="Preview" name="preview">
	</form>

	<script>
	    var editor = CKEDITOR.replace( 'editor1' );
	    CKFinder.setupCKEditor( editor, 'ckfinder/' );
	</script>


<?php } elseif (isset($_GET["new"])) { 

/******************************
****** ARTICLE CREATION *******
*******************************/

	?>

	<h1>New article</h1>

	<form method="post" action="?action=posts&save=1">
	<label for="title">Title</label>
	<input type="text" name="title"  size=50>
	<br/>
	<textarea class="ckeditor" cols="80" id="editor1" name="content" rows="10">
	</textarea>
	<br/>
	<label for="excerpt">Excerpt</label>
	<textarea cols="50" id="excerpt" name="excerpt" rows="2"></textarea>
	<br/><br/>
	<label for="pubdate">PubDate</label>
	<input type="date" name="pubdate" value="<?php echo date('Y-m-d'); ?>">
	<br/><br/>
	<label for="pubdate">In Gallery</label>
	<input type="checkbox" name="gallery">
	<br/><br/>

	<script type="text/javascript">
	function BrowseServer1()
	{
		var finder = new CKFinder();
		finder.basePath = './ckfinder/';	
		finder.selectActionFunction = SetFileField1;
		finder.popup();
	}
	function SetFileField1( fileUrl )
	{
		document.getElementById( 'coverimage1' ).value = fileUrl;
	}

	function BrowseServer2()
	{
		var finder = new CKFinder();
		finder.basePath = './ckfinder/';	
		finder.selectActionFunction = SetFileField2;
		finder.popup();
	}
	function SetFileField2( fileUrl )
	{
		document.getElementById( 'coverimage2' ).value = fileUrl;
	}

	function BrowseServer3()
	{
		var finder = new CKFinder();
		finder.basePath = './ckfinder/';	
		finder.selectActionFunction = SetFileField3;
		finder.popup();
	}
	function SetFileField3( fileUrl )
	{
		document.getElementById( 'coverimage3' ).value = fileUrl;
	}
	</script>

	<fieldset>

	<label for="cover_image_1">Cover Image 1</label>
	<input type="text" name="cover_image_1" id="coverimage1" value=""><input type="button" value="Browse Server" onclick="BrowseServer1();" /><br/>
	<label for="cover_image_2">Cover Image 2</label>
	<input type="text" name="cover_image_2" id="coverimage2" value=""><input type="button" value="Browse Server" onclick="BrowseServer2();" /><br/>
	<label for="cover_image_3">Cover Image 3</label>
	<input type="text" name="cover_image_3" id="coverimage3" value=""><input type="button" value="Browse Server" onclick="BrowseServer3();" /><br/>
	</fieldset>
	<br/>
	<label for="state">State</label>
	<select name="state">
	<option value=0 >Draft</option>
	<option value=1 >Online</option>
	</select>
	<br/>
	<label for="tag_group">Tags</label>
	<div style="width:200px;height:100px;overflow:auto;border:1px solid #ddd;padding:10px;">
	<?php
	$query  = "SELECT * FROM tags";
	  $result = mysql_query($query);
	  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  {?>
		<input type="checkbox" name="tag_group[]" value="<?php echo $row["id"] ?>" /><?php echo $row["tagname"] ?><br />
	<?php } ?>
	</div>
	<br/>
	<input type="submit" value="Save">
	<input type="submit" value="Preview" name="preview">
	</form>

	<script>
	    var editor = CKEDITOR.replace( 'editor1' );
	    CKFinder.setupCKEditor( editor, 'ckfinder/' );
	</script>

<?php } else { ?>

	<div class="jtable-main-container">
	<div class="jtable-title"><div class="jtable-title-text">Articles</div></div>
	</div>

	<table>
	<tr>
	<th>ID</th>
	<th>Title</th>
	<th>Pubdate</th>
	<th>Gallery</th>
	<th>State</th>
	<th></th>
	<th></th>
	</tr>
	<?php 

		

		  $query  = "SELECT * FROM articles order by pubdate desc";
	  $result = mysql_query($query);

	  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		  {
		  ?>
		  <tr>
		  <td><?php echo $row['id']; ?></td>
		  <td><?php echo $row['title']; ?></td>
		  <td><?php echo $row['pubdate']; ?></td>	
		  <td><?php echo $row['gallery']; ?></td>	
		  <td><?php echo ($row['state'] == "1" ? "Online" : "Draft") ; ?></td>
		  <td><a href="?action=posts&edit=<?php echo $row['id']; ?>"><img src="scripts/jtable/themes/lightcolor/edit.png"></a></td>
		  <td><a href="?action=posts&delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');"><img src="scripts/jtable/themes/lightcolor/delete.png"></a></td>
		  </tr>
		<?php
		} 
	?>
	<tr><td colspan="8" align="right"><a href="?action=posts&new=1">+ New article</a></td></tr>
	</table>
<?php } ?>	