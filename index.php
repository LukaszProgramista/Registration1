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


// Stworzenie połączenie z bazą
$conn = mysqli_connect('localhost', 'root', '', 'salonfryzjerski');
// Sprawdzanie czy połączenie z bazą się udało
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
 
$sql = 'SELECT * FROM wizyty';


//formularz dodawania do bd

?>
<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href='css/style.css'>
    <title>Salonik fryzjerski Nożyczki</title>
</head>
<body>
  <div class="navbar">
    <div class="container">
      <a class ="logo" href="index.php">Salonik Długie<span>Włochy</span></a>
        <?php echo"Witaj ".$_SESSION['username'];?>

        <img id="mobile-cta" class="mobile-menu" src="images/menu.svg" alt="Open Navigation">
          <nav>
          <!-- logged in user information -->
          <img id="mobile-exit" class="mobile-menu-exit" src="images/exit.svg" alt="Close Navigation">
          <?php  if (isset($_SESSION['username'])) : ?>
            <li class="logout"><a href="index.php?logout='1'">Wyloguj</a></li>
            <li class="profil"><a href="user.php">Profil</a></li>
          <?php endif ?>
        </nav>
      </div>
  </div>
  <section>
    <div class = "table">

  <form action="index.php" method="POST">
  <?php
    if($_SESSION['username']=='admin') // jeśli użytkownik jest administratorem
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
          if(intval($row['godzina'])==$i) //intval - parsowanie stringa do inta
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
    else //jeśli loguje się zwykły użytkownik
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
          if(intval($row['godzina'])==$i) // intval parsuje stringa na inta
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
    }?>	
    </div>
  </section>
    <div class="data">
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
    </div>
    <div class= "services">
      <p> Wybierz usługę
        <select name="usluga_wizyty">
          <option value="strzyzenie">strzyzenie</option>
          <option value="modelowanie">modelowanie</option>
          <option value="farbowanie">farbowanie</option>
      </select></p>
    </div>
  <div class="clicls">
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
  </div>
  <section class = "contact-section">
    <div class="container">
      <div class="contact-right">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14818.120960507431!2d-72.17172145!3d21.7984347!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x894b4fed6c2311cb%3A0xfd61c3d39411c53d!2sGrace%20Bay%20TKCA%201ZZ%2C%20Turks%20i%20Caicos!5e0!3m2!1spl!2spl!4v1670153053748!5m2!1spl!2spl" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>
  </form>

  <script>

        const mobileBtn = document.getElementById('mobile-cta')
              nav = document.querySelector('nav')
              mobileBtnExit = document.getElementById('mobile-exit');

        mobileBtn.addEventListener('click', () => {
            nav.classList.add('menu-btn');
        })

        mobileBtnExit.addEventListener('click', () => {
            nav.classList.remove('menu-btn');
        })



    </script>
    
</body>
</html>