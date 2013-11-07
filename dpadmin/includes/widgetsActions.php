<?php
require("../../includes/dbconn.php");
try
{
	if($_GET["action"] == "list")
	{
		$result = mysql_query("SELECT * FROM widgets;");
		
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
		$result = mysql_query("INSERT INTO widgets(title, content, sidebarorder) VALUES('" . $_POST["title"] . "', '" . $_POST["content"] . "',".$_POST["sidebarorder"].");");
		
		$result = mysql_query("SELECT * FROM widgets WHERE id = LAST_INSERT_ID();");
		$row = mysql_fetch_array($result);

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "update")
	{
		$result = mysql_query("UPDATE widgets SET title = '" . $_POST["title"] . "', content = '" . $_POST["content"] . "', sidebarorder=" . $_POST["sidebarorder"] . " WHERE id = " . $_POST["id"] . ";");

		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "delete")
	{
		$result = mysql_query("DELETE FROM widgets WHERE id = " . $_POST["id"] . ";");

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