<?php 

  $query  = "SELECT * FROM widgets";
  $result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  ?>
  <div class="widget">
  	<?php echo $row['content']; ?>
  </div>
  
  <?php
  } 
  ?>