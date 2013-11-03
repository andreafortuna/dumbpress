<?php 

  $query  = "SELECT * FROM articles";
  $result = mysql_query($query);

  while($row = mysql_fetch_array($result, MYSQL_ASSOC))
  {
  ?>
  <article>
    <header>
      <h1><a href="#"><?php echo $row['title']; ?></a></h1>
      <time pubdate datetime="2011-10-09T14:28-08:00"><?php echo $row['pubdate']; ?></time></p>  
    </header>
    <p><?php echo $row['excerpt']; ?></p>
    <footer>
      <p>Pubblicato in TAGLIST</p>
    </footer>
  </article>
  
  <?php
  } 
  ?>
