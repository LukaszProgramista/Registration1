<?php include('server.php') ?>

<?php
 

  if (!isset($_SESSION['username'])) {
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }


// Create connection
$conn = mysqli_connect('localhost', 'root', '', 'registration');
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT id, nazwa, autor, opis FROM lista";
$result = mysqli_query($conn, $sql);

//////////////////////////////////////
// usuwanie ksiazek itp
//if (isset($_POST['nid'])) {
 // $dlt = sprintf("DELETE FROM lista WHERE , $_POST['nid']);

//za pomoc¹ funkcji sprintf() wymuszany jest w³aœciwy typ danych (%d)
////////////////////////////////

// wyswietlane w tabeli na stronie z opcja usun
if (mysqli_num_rows($result) > 0) {
    echo '<table><tr>
    <th>id</th>
    <th>nazwa</th>
    <th>autor</th>
    <th>opis</th>
    </tr>';

    while( $row = mysqli_fetch_assoc($result)) {
  vprintf('<tr>
            <td>%s</td>
            <td>%s</td>
            <td>%s</td>
            <td></td>
        <td><form action="" method="post">
        <input type="hidden" name="nid" value="%s">
        <input type="submit" name="s" value="usun">      
        </form></td>
        </tr>', $row);

}
    while($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>{$row['nazwa']}</td><td>{$row['autor']}</td><td>{$row['opis']}</td></tr>";
    }
    echo '</table>';
}





    
//formularz dodawania do bd
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<body>
 <form method="post" action="lista.php">
  	<div class="input-group">
  	  <label>nazwa</label>
  	  <input type="text" name="nazwa">
  	</div>
  	<div class="input-group">
  	  <label>autor</label>
  	  <input type="text" name="autor">
  	</div>
    <div class="input-group">
  	  <label>opis</label>
  	  <input type="text" name="opis">
  	</div>

  	<div class="input-group">
  	  <button type="submit" class="btn" name="dodaj">dodaj ksiazke</button>
  	</div>
  </form>


<div class="content">

      	<p>
  		<a href="index.php">wroc</a>
  	</p>

</div>
		
</body>
</html>