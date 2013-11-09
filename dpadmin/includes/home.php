<script>
function refreshStatistics() {
	$("#facebookShares").text("Updating...");
	$("#facebookComments").text("Updating...");
	$.get( "includes/fbStats.php", function( data ) {
	  datas = data.split("-");
	  $("#facebookShares").text(datas[0]);
	  $("#facebookComments").text(datas[1]);
	});

}
</script
<?php 
require_once("../includes/dumbpress.php");
$result = mysql_query("select count(*) as numArticles from articles where pubdate <= now() and state=1");
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$onlinearticles=$row["numArticles"];

$result = mysql_query("select count(*) as numArticles from articles where pubdate > now() and state=1");
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$scheduledarticles=$row["numArticles"];

$result = mysql_query("select count(*) as numArticles from articles where state=0");
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$drafts=$row["numArticles"];



?>
<h3><i class="glyphicon glyphicon-pencil"></i>Articles Statistics</h3>
<ul>
<li>Articles Online:<strong><?php echo $onlinearticles; ?></strong></li>
<li>Scheduled Articles:<strong><?php echo $scheduledarticles; ?></strong></li>
<li>Drafts:<strong><?php echo $drafts; ?></strong></li>
</ul>

<h3><i class="glyphicon glyphicon-share"></i>Social Statistics</h3><a href="#" onclick="refreshStatistics();"><i class="glyphicon glyphicon-refresh"></i></a>
<ul>
<li>Facebook Shares:<strong><span id="facebookShares"><?php echo getOption("facebookShares");?></span></strong></li>
<li>Facebook Comments:<strong><span id="facebookComments"><?php echo getOption("facebookComments");?></span></strong></li>
</ul>
