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


// Create connection
$conn = mysqli_connect('localhost', 'root', '', 'salonfryzjerski');
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
 
$sql = 'SELECT * FROM wizyty';


//formularz dodawania do bd

?>
<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='style.css'>
</head>
<body>

<div class="header">
	<h2>Home Page</h2>
    <?php echo"Witaj ".$_SESSION['username'];?>
</div>
<div class="content">
    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
      <p> <a href="user.php" style="color: green;">profil</a> </p>
    <?php endif ?>
</div>
<form action="index.php" method="POST">
<?php
  if($_SESSION['username']=='admin')
  {
    
    echo 
    '<table>
      <tr>
        <th>Godzina</th>
        <th>Nazwa</th>
        <th>Email</th>
        <th>Usługa</th>
        <th>Status</th>
        <th colspan="2">Termin</th>
      </tr>';
    for($i=10;$i<19;$i++)
    {
      $result = mysqli_query($conn,$sql);
      while($row = mysqli_fetch_assoc($result))
      {
        if(intval($row['godzina'])==$i)
        {
            echo 
            '<tr>
              <td>'.$row['godzina'].'</td>
              <td>'.$row['nazwa'].'</td>
              <td>'.$row['email'].'</td>
              <td>'.$row['usluga'].'</td>
              <td>'.$row['status'].'</td>
              <td>'.$row['termin'].'</td>
              <td>
                <input type="checkbox" name="'.$i.'"value ="yes">
              </td>
            </tr>';
            goto wolne;
        }
      }
      if(true)
      {
          echo 
          '<tr>
            <td>'.$i.'</td>
            <td colspan="6">Wolny termin</td>
          </tr>';
      }
      wolne:
    }
    echo'</table>';
  }
  else
  {
    echo '<table>
    <tr>
      <th>Godzina</th>
      <th>Nazwa</th>
      <th>Email</th>
      <th>Usluga</th>
      <th>Status</th>
      <th>Termin</th>
    </tr>';
    for($i=10;$i<19;$i++)
    {
      $result = mysqli_query($conn,$sql);
      while($row = mysqli_fetch_assoc($result))
      {
        if(intval($row['godzina'])==$i)
        {
            echo 
            '<tr>
              <td>'.$row['godzina'].'</td>
              <td colspan="5">Zajete</td>
            </tr>';
            goto wolne1;
        }
      }
      if(true)
      {
          echo 
          '<tr>
            <td>'.$i.'</td>
            <td colspan="5">Wolny termin</td>
          </tr>';
      }
      wolne1:
    }
    echo '</table>';
  }

  
?>	
  <p> Wybierz godzinę wizyty 
    <select name="godzina_wizyty">
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
</select></p>
<p> Wybierz usługę
  <select name="usluga_wizyty">
    <option value="strzyzenie">strzyzenie</option>
    <option value="modelowanie">modelowanie</option>
    <option value="farbowanie">farbowanie</option>
</select></p>

<input type=submit name="wizyta" value="Zamow wizyte">
<?php
if($_SESSION['username']=='admin')
{
  ?>
  <input type=submit name="wizytaDel" value="Wyczysc wizyty" onclick="return confirm('Czy na pewno usunąć wszystkie wizyty?')">
  <input type=submit name="wizytaAkc" value="Zaakceptuj wybrane wizyty" onclick="return confirm('Czy na pewno zaakceptować wszystkie wybrane wizyty?')">
  <input type=submit name="wizytaOdw" value="Odwołaj wybrane wizyty" onclick="return confirm('Czy na pewno odwołać wszystkie wybrane wizyty?')">
  <?php
}
include('errors.php'); 
mysqli_close($conn);
?>
</form>
</body>
</html>