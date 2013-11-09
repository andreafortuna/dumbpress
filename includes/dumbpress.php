<?php 

/*
* DUMBPRESS, a simple, high-configurable, lightweight blogging platform by Andrea Fortuna
*
*/
session_start();
require_once("dp-config.php");
require_once("dp-sidebar.php");
require_once("dp-functions.php");
require_once("dbconn.php");

/* Version tracking */
$dpVersion = "0.0.3 Beta";
/********************/




/*********** UI FUNCTIONS ***************/



/*
* DumbPress Header
*/

function dpHeader() {
	$pagetitle = getOption("sitetitle");
	$pagedescription = getOption("headline");	
	if (isset($_GET["articleID"])) {
		$articleObject = dpGetArticleObject($_GET["articleID"]);
		$pagedescription = $articleObject["excerpt"];
		$pagetitle = $articleObject["title"]." - ".$pagetitle;
		$imagefull = getOption("sitelink")."/".$articleObject['cover_image_1'];
	}

	?>
	<!DOCTYPE html>
	<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
	<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	    <head>
	        <meta charset="utf-8">
	        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	        <title><?php echo $pagetitle; ?></title>
	        <meta name="description" content="<?php echo $pagedescription; ?>">
	        <meta name="viewport" content="width=device-width">
	        <link rel="shortcut icon" href="<?php echo getOption("sitelink"); ?>/themes/<?php echo getTheme() ?>/favicon.ico">
			<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo getOption("sitelink"); ?>/feed/" />
	        <link rel="stylesheet" href="<?php echo getOption("sitelink"); ?>/css/bootstrap.min.css">
	        <style>
	            body {
	                padding-top: 50px;
	                padding-bottom: 20px;
	            }
	        </style>
	        <link rel="stylesheet" href="<?php echo getOption("sitelink"); ?>/css/bootstrap-theme.min.css">
	        <link rel="stylesheet" href="<?php echo getOption("sitelink"); ?>/css/colorbox.css" />			
			<link rel="stylesheet" href="<?php echo getOption("sitelink"); ?>/css/main.css">
	        <link rel="stylesheet" href="<?php echo getOption("sitelink"); ?>/themes/<?php echo getTheme() ?>/main.css">

			<!-- Facebook properties -->
			<meta property="og:site_name" content="<?php echo getOption("sitetitle"); ?>"/>
			<meta property="og:locale" content="it_IT" />
			<meta property="fb:admins" content="<?php echo getOption("facebookAdminID"); ?>" />
			<meta property="fb:app_id" content="<?php echo getOption("facebookAppID"); ?>"/>
			<meta property="og:title" content="<?php echo $pagetitle; ?>"/>
			<meta property="og:description" content="<?php echo $pagedescription; ?>" />
			<?php if (isset($_GET["articleID"])) { ?>				
				<meta property="og:image" content="<?php echo $imagefull; ?>"/>				
				
			<?php } else {?>
				<meta property="og:type" content="website"/> 
			<?php } ?>
	        <script src="<?php echo getOption("sitelink"); ?>/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>



	    </head>
	    <body>
	        <!--[if lt IE 7]>
	            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	        <![endif]-->

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo getOption("facebookAppID"); ?>";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

	    <div class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	         <a class="navbar-brand" href=""><?php echo getOption("claim"); ?></a>
	        </div>
	        <div class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	            <li><a href="<?php echo createPermalink(""); ?>">Home</a></li>

	<?php 

	  $query  = "SELECT * FROM tags where inmenu=1 order by menuorder asc";
	  $result = mysql_query($query);

	  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  {
	  
	   echo "<li><a href='".getOption("sitelink")."/arguments/".$row['id']."/".$row['tagslug']."/'>".$row['tagname']."</a></li>";  
	
	  } 
	  ?>

	 </ul>
	        </div><!--/.navbar-collapse -->
	      </div>
	    </div>
	    <div class="jumbotron">
	      <div class="container">
	        <h1><?php echo getOption("sitetitle"); ?> <!-- <span class="logo">t</span> --></h1>
	        <p><?php echo getOption("headline"); ?></p>
	        
	      </div>
	    </div>
	  <div class="container">
 <?php 
}


/*
* DumbPress BlogRoll
*/

function dpBlogroll($page=0, $tagid=0) { ?>
   <h1>
   <?php 
	   $tagslug="";
	   //If tag archive, set TagName in title
	   if ($tagid!=0) {
	   		$result = mysql_query("select * from tags where id=".$tagid);
	   		$row = mysql_fetch_array($result, MYSQL_ASSOC);
	   		echo $row["tagname"];
	   		$tagslug = $row["tagslug"];
	   } else {
	   		echo getOption("blogrollTitle");
	   }
   ?></h1>
   <hr>
	<?php
	$pagesize = getOption("pagesize");
	if ($pagesize=="") $pagesize=5;
	if ($page =="") $page="0";

	//CREATE QUERY
	$query  = "SELECT * FROM articles ";
	if ($tagid!=0) $query .=" inner join articles_tags on articles_tags.articleID = articles.id ";
	$query .=" where pubdate < now() ";
	if ($tagid != 0) $query .=" and articles_tags.tagID=".$tagid;
	$query .=" and state=1 ";
	if ($tagid==0) $query .=" and gallery=0 ";
	$query .=" order by pubdate desc limit ".($page * $pagesize).",".$pagesize;
 
	//echo $query;

  	$result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  ?>
  <article>
    <header>
      <h1><a href="<?php echo createArticlePermalink($row['id'],$row['title']); ?>"><?php echo $row['title']; ?></a></h1>
      <time pubdate datetime="2011-10-09T14:28-08:00"><?php echo $row['pubdate']; ?></time></p>  
    </header>
    <p><?php echo $row['excerpt']; ?></p>
    <footer>
      <p>Posted in: <?php echo getTags($row['id']); ?></p>
    </footer>
  </article>  
  <?php }


  //NAVIGATION
  if ($tagid != 0) {?>
	  <?php if ($page>0) { ?><div style="float:left;"><a href="<?php echo getOption("sitelink")."/arguments/".$tagid."/".$tagslug."/page/".$page; ?>">Previous</a></div> <?php } ?>
	  <div style="float:right;"><a href="<?php echo getOption("sitelink")."/arguments/".$tagid."/".$tagslug."/page/".($page + 2); ?>">Next</a></div>
  <?php } else { ?>
 	  <?php if ($page>0) { ?><div style="float:left;"><a href="<?php echo getOption("sitelink")."/page/".$page; ?>">Previous</a></div> <?php } ?>
	  <div style="float:right;"><a href="<?php echo getOption("sitelink")."/page/".($page + 2); ?>">Next</a></div>

  <?php } ?>

 <?php 
}



/*
*	Search results
*/

function dpSearch($searchString) { ?>
	<h1>Search results for "<?php echo $searchString; ?>"</h1> 
	<?php
		$query  = "SELECT * FROM articles where excerpt like '%$searchString%' or title like '%$searchString%'";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
		?>
		  <article>
		    <header>
		      <h1><a href="<?php echo createArticlePermalink($row['id'],$row['title']); ?>"><?php echo $row['title']; ?></a></h1>
		      <time pubdate datetime="2011-10-09T14:28-08:00"><?php echo $row['pubdate']; ?></time></p>  
		    </header>
		    <p><?php echo $row['excerpt']; ?></p>
		    <footer>
		      <p>Posted in: <?php echo getTags($row['id']); ?></p>
		    </footer>
		  </article>  
		<?php }
	?>
 <?php 
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
  		echo call_user_func($widgets[$row['content']]);
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

function dpGallery() { ?>
	 
	<h1><?php echo getOption("galleryTitle");?></h1>
      <hr>
      <div class="row">
	
    <?php
	$query  = "SELECT * FROM articles where pubdate < now() and state=1 and gallery=1 order by pubdate desc limit 3";
	  $result = mysql_query($query);

	  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	  {
	  ?>

		<div class="col-lg-4">
	  		<h2><a href="<?php echo createArticlePermalink($row['id'],$row['title']); ?>"><?php echo $row['title']; ?></a></h2>
	  		<p><img src="<?php echo $row['cover_image_1']; ?>" class="imgsx"><?php echo $row['excerpt']; ?></p>          
		</div>

	  
	  <?php
	  } ?>
	  </div>
	  <br/>
 <?php
}

/*
* DumbPress Footer
*/

function dpFooter() { 
	global $dpVersion,$enableDebug;

	?>
	<hr>
	    <footer>
	      <span style="float:left;">&copy; <?php echo getOption("sitetitle");?> 2013</span>
	      <span style="float:right;">Powered by <a href="http://dumbpress.andreafortuna.org">DumbPress</a> - v. <?php echo $dpVersion; ?> - <a href="<?php echo getOption("sitelink");?>/dpadmin/"><i class="glyphicon glyphicon-lock"></i></a></span>
	    </footer>
	</div> <!-- /container -->        

	<?php if (getOption("enableAddThisBox") == "on") {?>
	    <!-- AddThis Smart Layers BEGIN -->
		<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-527d2d5f6c864b69"></script>
		<script type="text/javascript">
		  addthis.layers({
		    'theme' : 'transparent',
		    'share' : {
		      'position' : 'right',
		      'numPreferredServices' : 6
		    }   
		  });
		</script>
		<!-- AddThis Smart Layers END -->
		<?php } ?> 


		<?php if (getOption("enablePinterest") == "on") {?>
		<script type="text/javascript">
		(function(d){
		  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
		  p.type = 'text/javascript';
		  p.setAttribute('data-pin-hover', true);
		  p.async = true;
		  p.src = '//assets.pinterest.com/js/pinit.js';
		  f.parentNode.insertBefore(p, f);
		}(document));
		</script>
		<?php } ?> 


	    <script>window.jQuery || document.write('<script src="<?php echo getOption("sitelink"); ?>/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
	<script src="<?php echo getOption("sitelink"); ?>/js/vendor/jquery.colorbox.js"></script>
	        <script src="<?php echo getOption("sitelink"); ?>/js/vendor/bootstrap.min.js"></script>

	        <script src="<?php echo getOption("sitelink"); ?>/js/main.js"></script>

	        <script>
	            var _gaq=[['_setAccount','<?php echo getOption("ganalyticsID")?>'],['_trackPageview']];
	            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	            g.src='http://www.google-analytics.com/ga.js';
	            s.parentNode.insertBefore(g,s)}(document,'script'));
	        </script>
	    </body>
	</html>

	
<?php }

/*
* DEBUG
*/


function dpDebugStart() {
	global $enableDebug; 
	//DEBUG**/
	if ($enableDebug=="1") {
		$res = mysql_query("SHOW SESSION STATUS LIKE 'Questions'");
		$row = mysql_fetch_array($res, MYSQL_ASSOC);
		define("START_QUERIES",$row['Value']);
		define("START_TIME",microtime(true));
	}
	/*******/
}

function dpDebugStop() {
	global $enableDebug;

	/*** DEBUG ****/
	if ($enableDebug=="1") {
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		$res = mysql_query("SHOW SESSION STATUS LIKE 'Questions'");
		$row = mysql_fetch_array($res, MYSQL_ASSOC);
		define("STOP_QUERIES",$row['Value']);
		define("STOP_TIME",microtime(true));
		echo "<!-- No of queries: ".(STOP_QUERIES-START_QUERIES-1)." - Page generate in ".round((STOP_TIME - START_TIME)*1000)." ms-->";	
	}
	/**************/
}

?>