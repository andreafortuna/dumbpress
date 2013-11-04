<?php

function parse_mysql_dump($url,$nowhost,$nowdatabase,$nowuser,$nowpass){
	$link = mysql_connect($nowhost, $nowuser, $nowpass);
		if (!$link) {
		   die('Not connected : ' . mysql_error());
		}
		
		// make foo the current db
		$db_selected = mysql_select_db($nowdatabase, $link);
		if (!$db_selected) {
		   die ('Can\'t use foo : ' . mysql_error());
		}
   $file_content = file($url);
   foreach($file_content as $sql_line){
     if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
	 //echo $sql_line . '<br>';
       mysql_query($sql_line);
     }
   }
  }





?>