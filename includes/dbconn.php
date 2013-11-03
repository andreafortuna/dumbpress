<?php
require_once("dp-config.php");
$link = mysql_connect($dbhost, $dbusername, $dbpassword);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbname, $link) or die('Could not select database.');
?>