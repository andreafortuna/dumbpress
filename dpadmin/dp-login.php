<?php 
require_once("../includes/dumbpress.php");
require_once("../includes/dp-security.php");
if (isset($_POST["login"])) {

	if (login($_POST["login"],$_POST["password"])) {
		header("location:index.php");
	} else {
		header("location:dp-login.php?err=1");
	}
}

require("includes/header.php"); ?>
<style>
	.loginBox {
		border:1px solid #ccc;
		box-shadow: 2px 2px #ccc;
    border-radius:5px;
		width:320px;
		height:220px;
		padding:30px;
	}
  .loginBox label {
    width:60px;  
  }

	h4 {
		color:red;
	}
</style>
<div class="row">
  

  <div class="col-lg-4"></div>
  <div class="col-lg-4">
  	<div class='loginBox'>
  	<form id="loginform" method="post" action="dp-login.php">
  		<label for="login">Username</label>
  		<input type="text" name="login" placeholder="Admin username">
  		<br/><br/>
  		<label for="password">Password</label>
  		<input type="password" name="password" placeholder="Admin password">
  		<br/><br/>
  		<input type="submit" value="Login">
  		<?php 
  			if (isset($_GET["err"])) {
  				echo "<h4>Wrong username/password!</h4>";
  			}
  		?>
  	</form>
  	</div>
  </div>
  <div class="col-lg-4"></div>


</div>


<?php require("includes/footer.php"); ?>