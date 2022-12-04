<?php include('server.php') ?>
<!DOCTYPE html>
<html>

<body>
  <div class="header">
  	<h2>Logowanie</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Nazwa</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Hasło</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" name="login_user">Logowanie</button>
  	</div>
  	<p>
  		Jeszcze nie masz konta? <a href="register.php">Zarejestruj się</a>
  	</p>
  </form>
</body>
</html>