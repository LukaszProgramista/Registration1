<?php 
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<body>

<div class="header">
	<h2>Home Page</h2>
    witaj ziomek
</div>
<div class="content">
    <!-- logged in user information -->
      	<p>
  		lista tam czegos <a href="lista.php">lista/cokolwiek z baza danych</a>
  	</p>
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>
		
</body>
</html>