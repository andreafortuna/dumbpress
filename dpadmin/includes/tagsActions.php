<?php
require("../../includes/dbconn.php");
try
{
	if($_GET["action"] == "list")
	{
		$result = mysql_query("SELECT * FROM tags;");
		$rows = array();
		while($row = mysql_fetch_array($result))
		{
		    $rows[] = $row;
		}
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Records'] = $rows;
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "create")
	{
		$result = mysql_query("INSERT INTO tags(tagname, tagslug, inmenu,menuorder) VALUES('" . $_POST["tagname"] . "', '" . $_POST["tagslug"] . "',".$_POST["inmenu"].",".$_POST["menuorder"].");");
		$result = mysql_query("SELECT * FROM tags WHERE id = LAST_INSERT_ID();");
		$row = mysql_fetch_array($result);

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "update")
	{
		$result = mysql_query("UPDATE tags SET tagname = '" . $_POST["tagname"] . "', tagslug = '" . $_POST["tagslug"] . "', inmenu=" . $_POST["inmenu"] . ", menuorder=".$_POST["menuorder"]." WHERE id = " . $_POST["id"] . ";");

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "delete")
	{
		$result = mysql_query("DELETE FROM tags WHERE id = " . $_POST["id"] . ";");

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	mysql_close($link);

}
catch(Exception $ex)
{
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
	
?>