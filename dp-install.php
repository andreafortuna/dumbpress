<?php
require_once("includes/dp-config.php");
ini_set('memory_limit', '5120M');
set_time_limit ( 0 );

function remove_comments(&$output)
{
   $lines = explode("\n", $output);
   $output = "";
   $linecount = count($lines);
   $in_comment = false;
   for($i = 0; $i < $linecount; $i++)
   {
      if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
      {
         $in_comment = true;
      }
      if( !$in_comment )
      {
         $output .= $lines[$i] . "\n";
      }
      if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
      {
         $in_comment = false;
      }
   }
   unset($lines);
   return $output;
}


function remove_remarks($sql)
{
   $lines = explode("\n", $sql);
   $sql = "";
   $linecount = count($lines);
   $output = "";
   for ($i = 0; $i < $linecount; $i++)
   {
      if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
      {
         if (isset($lines[$i][0]) && $lines[$i][0] != "#")
         {
            $output .= $lines[$i] . "\n";
         }
         else
         {
            $output .= "\n";
         }
         $lines[$i] = "";
      }
   }
   return $output;
}


function split_sql_file($sql, $delimiter)
{
   $tokens = explode($delimiter, $sql);
   $sql = "";
   $output = array();
   $matches = array();
   $token_count = count($tokens);
   for ($i = 0; $i < $token_count; $i++)
   {
      if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
      {
         $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
         $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
         $unescaped_quotes = $total_quotes - $escaped_quotes;
         if (($unescaped_quotes % 2) == 0)
         {
            $output[] = $tokens[$i];
            $tokens[$i] = "";
         }
         else
         {
            $temp = $tokens[$i] . $delimiter;
            $tokens[$i] = "";
            $complete_stmt = false;
            for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
            {
               $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
               $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
               $unescaped_quotes = $total_quotes - $escaped_quotes;
               if (($unescaped_quotes % 2) == 1)
               {
                  $output[] = $temp . $tokens[$j];
                  $tokens[$j] = "";
                  $temp = "";
                  $complete_stmt = true;
                  $i = $j;
               }
               else
               {
                  $temp .= $tokens[$j] . $delimiter;
                  $tokens[$j] = "";
               }
            }
         }
      }
   }

   return $output;
}

$dbms_schema = 'dumbpress.sql';
$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('problem ');
$sql_query = remove_remarks($sql_query);
$sql_query = split_sql_file($sql_query, ';');
$host = 'localhost';
$user = 'user';
$pass = 'pass';
$db = 'database_name';
mysql_connect($dbhost,$dbusername,$dbpassword) or die('error connection');
mysql_select_db($dbname) or die('error database selection');
$i=1;
foreach($sql_query as $sql){
echo $i++;
echo "
";
mysql_query($sql) or die('error in query');
}

?>