<?php 

/*
* DUMBPRESS, a simple, high-configurable, lightweight blogging platform by Andrea Fortuna
*
*/
require_once("dp-config.php");
require_once("dp-sidebar.php");
require_once("dp-functions.php");
require_once("dbconn.php");

/* Version tracking */
$dpVersion = "0.0.1 Beta";
/********************/


/*********** ARTICLES FUNCTIONS *********/

/*
* DumbPress getArticle
*/

function dpGetArticle($articleID) {
	
	$query  = "SELECT * FROM articles where id=$articleID";
  	$result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  ?>
	<article>
		<header>
		<h1><?php echo $row['title']; ?></h1>
		<h3><?php echo $row['excerpt']; ?></h3>
		<p>
		<div class="postGallery">
		<?php if ($row['cover_image_1'] != "") { ?> <a class="group1" href="<?php echo $row['cover_image_1']; ?>"><img src="<?php echo $row['cover_image_1']; ?>" class="postGalleryImg"></a><?php } ?>
		<?php if ($row['cover_image_2'] != "") { ?> <a class="group1" href="<?php echo $row['cover_image_2']; ?>"><img src="<?php echo $row['cover_image_2']; ?>" class="postGalleryImg"></a><?php } ?>
		<?php if ($row['cover_image_3'] != "") { ?> <a class="group1" href="<?php echo $row['cover_image_3']; ?>"><img src="<?php echo $row['cover_image_3']; ?>" class="postGalleryImg"></a><?php } ?>
		</div>
		</p>		
		</header>
		<p>
		<?php 
		echo getOption("preArticle");
		echo $row['content']; 
		echo getOption("postArticle");
		?>
		</p>
		<footer>Footer</footer>
	</article>
  <?php
  } 
}	

function dpCreateArticle($title,$content,$pubdate,$excerpt,$gallery,$cover_image_1,$cover_image_2,$cover_image_3,$state,$tags) {
	$query  = "insert into articles(gallery,title,content,pubdate,excerpt,cover_image_1,cover_image_2,cover_image_3,state) values($gallery,'$title','$content','$pubdate','$excerpt','$cover_image_1','$cover_image_2','$cover_image_3',$state)";
	//echo $query;
	$result = mysql_query($query);
	//Get inserted ID
	$result = mysql_query("SELECT * FROM articles WHERE id = LAST_INSERT_ID();");
	$row = mysql_fetch_array($result);
	$lastinsertid = $row["id"];
	//Remove old tags
	mysql_query("delete from articles_tags where articleID=$lastinsertid");
	// Saving TAGS
    for ($i=0; $i<count($tags); $i++) {
        mysql_query("insert into articles_tags (articleID,tagID) values (".$lastinsertid.",".$tags[$i].")");
    }

	return $result;
}

function dpDeleteArticle($articleID) {
	mysql_query("delete from articles where id=$articleID");
}

function dpUpdateArticle($articleID,$title,$content,$pubdate,$excerpt,$gallery,$cover_image_1,$cover_image_2,$cover_image_3,$state,$tags) {
	$query  = "update articles set gallery=$gallery,title='$title',content='$content',pubdate='$pubdate',excerpt='$excerpt',cover_image_1='$cover_image_1',cover_image_2='$cover_image_2',cover_image_3='$cover_image_3',state=$state where id=$articleID";
	//echo $query;
	$result = mysql_query($query);
	//Remove old tags
	mysql_query("delete from articles_tags where articleID=$articleID");
	// Saving TAGS
    for ($i=0; $i<count($tags); $i++) {
        mysql_query("insert into articles_tags (articleID,tagID) values (".$articleID.",".$tags[$i].")");
    }

	return $result;
}


/*********** UI FUNCTIONS ***************/



/*
* DumbPress Header
*/

function dpHeader() { ?>
	<!DOCTYPE html>
	<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
	<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	    <head>
	        <meta charset="utf-8">
	        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	        <title></title>
	        <meta name="description" content="">
	        <meta name="viewport" content="width=device-width">

	        <link rel="stylesheet" href="css/bootstrap.min.css">
	        <style>
	            body {
	                padding-top: 50px;
	                padding-bottom: 20px;
	            }
	        </style>
	        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
	        <link rel="stylesheet" href="css/colorbox.css" />			
			
	        <link rel="stylesheet" href="themes/<?php echo getTheme() ?>/main.css">

	        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

		

	    </head>
	    <body>
	        <!--[if lt IE 7]>
	            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	        <![endif]-->
	    <div class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	         <a class="navbar-brand" href="#"><?php echo getOption("claim"); ?></a>
	        </div>
	        <div class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	            <li><a href="<?php echo createPermalink(""); ?>">Home</a></li>

	<?php 

	  $query  = "SELECT * FROM tags where inmenu=1 order by menuorder asc";
	  $result = mysql_query($query);

	  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  {
	  ?>
	  <li><a href="<?php echo createPermalink($row['tagslug']); ?>/"><?php echo $row['tagname']; ?></a></li>	  
	  <?php
	  } 
	  ?>

	 </ul>
	        </div><!--/.navbar-collapse -->
	      </div>
	    </div>
	    <div class="jumbotron">
	      <div class="container">
	        <h1><?php echo getOption("sitetitle"); ?> <span class="logo">t</span></h1>
	        <p><?php echo getOption("headline"); ?></p>
	        
	      </div>
	    </div>
	  <div class="container">
<?php 
}

/*
* DumbPress BlogRoll
*/

function dpBlogroll() {

  $query  = "SELECT * FROM articles where pubdate < now() and state=1 and gallery=0 order by pubdate desc";
  $result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  ?>
  <article>
    <header>
      <h1><a href="<?php echo createPermalink("?articleID=".$row['id']); ?>"><?php echo $row['title']; ?></a></h1>
      <time pubdate datetime="2011-10-09T14:28-08:00"><?php echo $row['pubdate']; ?></time></p>  
    </header>
    <p><?php echo $row['excerpt']; ?></p>
    <footer>
      <p>TAG1,TAG2,TAG3</p>
    </footer>
  </article>
  
  <?php
  } 
}


/*
* DumbPress Sidebar
*/

function dpSidebar() {
  global $widgets;
  $query  = "SELECT * FROM widgets order by sidebarorder";
  $result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  ?>
  <div class="widget">
  	<h4><?php echo $row['title']; ?></h3>
  <?php if (array_key_exists($row['content'], $widgets)) { 
  		echo $widgets[$row['content']];
  	} else {	
		echo $row['content'];
	}
	?>
	</div>
	<?php
  } 
}

/*
* DumbPress Gallery
*/

function dpGallery() { 

$query  = "SELECT * FROM articles where pubdate < now() and state=1 and gallery=1 order by pubdate desc limit 3";
  $result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  ?>

	<div class="col-lg-4">
  		<h2><div class="boxLogo">A</div><a href="?articleID=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
  		<p><img src="<?php echo $row['cover_image_1']; ?>" class="imgsx"><?php echo $row['excerpt']; ?></p>          
	</div>

  
  <?php
  } 
}

/*
* DumbPress Footer
*/

function dpFooter() { 
global $dpVersion;
?>
<hr>
    <footer>
      <span style="float:left;">&copy; <?php echo getOption("sitetitle");?> 2013</span>
      <span style="float:right;">Powered by <a href="http://dumbpress.andreafortuna.org">DumbPress</a> - v. <?php echo $dpVersion; ?></span>
    </footer>
</div> <!-- /container -->        

    

    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
<script src="js/vendor/jquery.colorbox.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','<?php echo getOption("ganalyticsID")?>'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='http://www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>

<?php }




?>