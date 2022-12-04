<?php include('server.php') ?>

<?php

  if (!isset($_SESSION['username'])) {
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['email']);
  	header("location: login.php");
  }

  // Tworzenie połączenia z bazą
$conn = mysqli_connect('localhost', 'root', '', 'salonfryzjerski');
// Sprawdzenie czy połączenie się udało
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$nazwa = mysqli_real_escape_string($db,$_SESSION['username']);
$sql = "SELECT * FROM wizyty WHERE nazwa='$nazwa'";
$result = mysqli_query($conn,$sql);

  ?>
<html>
<head>	
	<title>Edit Data</title>
  <head>
    <link rel='stylesheet' href='css/style.css'>
</head>
</head>
<body>
<div class="navbar">
    <div class="container">
      <div class="header">
        <h2>Dane uzytkownika</h2>
          <?php echo"Witaj ".$_SESSION['username'];?>
      </div>
      <div class="content">
          <?php  if (isset($_SESSION['username'])) : ?>
            <p> <a href="index.php?logout='1'" style="color: red;">Wyloguj</a> </p>
            <p> <a href="index.php" style="color: green;">Strona główna</a> </p>
          <?php endif ?>
      </div>
    </div>
</div>
          <form method="post" action="user.php">
              Email: <input type="email" name="email"></br>
              Stare hasło: <input type="password" name="starehaslo"></br>
              Nowe hasło: <input type="password" name="nowehaslo"></br>
              <input type="submit" name="aktualizuj" value="Aktualizuj"></td>
          </form>
          <?php include('errors.php'); ?>
          <p> Twoje zarezerwowane wizyty </p>
<?php
echo 
'<table>
  <tr>
    <th>Godzina</th>
    <th>Usługa</th>
    <th>Status</th>
    <th colspan="2">Termin</th>
  </tr>';
while($row = mysqli_fetch_assoc($result))
{
      echo 
      '<tr>
        <td>'.$row['godzina'].'</td>
        <td>'.$row['usluga'].'</td>
        <td>'.$row['status'].'</td>
        <td>'.$row['termin'].'</td>
      </tr>';
}
?>

</body>
</html>


