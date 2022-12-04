<?php
session_start();

// deklarowanie zmiennych
$username = "";
$email    = "";
$errors = array(); 

// połączenie z bazą danych
$db = mysqli_connect('localhost', 'root', '', 'salonfryzjerski');

// Rejestracja użytkownika
if (isset($_POST['reg_user'])) {
  // Odebranie wszystkich danych z formularza
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);


  // Sprawdzenie czy formularz jest prawidłowo wypełniony
  // poprzed dodawanie do tablicy $errors konkretne błędy
  if (empty($username)) { array_push($errors, "Brak nazwy uzytkownika!!"); }
  if (empty($email)) { array_push($errors, "Brak Emaila!!"); }
  if (empty($password_1)) { array_push($errors, "Brak hasla!!"); }
  if(strlen($password_1) < 8) { array_push($errors, "Hasło musi zawierać conajmniej 8 znaków"); }



  // Sprawdzenie czy w bazie istneej już użytkownik z taką samą nazwą lub/i adresem email
  $user_check_query = "SELECT * FROM rejestracja WHERE nazwa='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // jeśli użytkownik istnieje
    if ($user['nazwa'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Rejestracja użytkownika jeśli nie pojawiły się żadne błędy
  if (count($errors) == 0) {
  	$password = md5($password_1);//szyfrowanie hasła zanim wpiszemy go do bazy

  	$query = "INSERT INTO rejestracja (nazwa, haslo, email) 
  			  VALUES('$username', '$password', '$email')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	header('location: index.php');
  }
}
// Logowanie użytkownika
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }
  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM rejestracja WHERE nazwa='$username' AND haslo='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
      while($data = mysqli_fetch_assoc($results))
      {
        $_SESSION['username'] = $data['nazwa'];
        $_SESSION['password'] = $data['haslo'];
        $_SESSION['email'] = $data['email'];
      }
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Nieprawidlowy login lub haslo");
  	}
  }
}
// Wstawianie do bazy wizyty | Zarezerwowanie wizyty na konkretną godzinę
if(isset($_POST['wizyta']))
{
  $nazwa = mysqli_real_escape_string($db,$_SESSION['username']);
  $email = mysqli_real_escape_string($db,$_SESSION['email']);
  $godzina_wizyty =mysqli_real_escape_string($db, $_POST['godzina_wizyty']);
  $rodzaj_wizyty =mysqli_real_escape_string($db, $_POST['usluga_wizyty']);
  $query = "SELECT * FROM wizyty WHERE godzina='$godzina_wizyty'";
  $result = mysqli_query($db, $query);
  if (mysqli_num_rows($result) == 0)// jeśli nie znalazło wiersza z konkretną godziną, wtedy zapisz wizytę, w innym wypadku wyświetl błąd
  {
    $sqlWstaw = "INSERT INTO `wizyty` (`godzina`, `nazwa`, `email`,`usluga`,`status`,`termin`) VALUES ('$godzina_wizyty','$nazwa','$email','$rodzaj_wizyty','Oczekiwanie na akceptacje','zajete')";
    mysqli_query($db, $sqlWstaw);
  }
  else 
  {
    array_push($errors, "Godzina zajęta, wybierz inny termin");
  }
 }

 //Usuwanie wizyt z tabelki
 if(isset($_POST['wizytaDel']))
{
  $query = "DELETE FROM wizyty";
  $result = mysqli_query($db, $query);
}

//Akceptacja zaznaczonych wizyt
if(isset($_POST['wizytaAkc']))
{
  for($i=10;$i<19;$i++)
  {
    if(isset($_POST[$i])) // $i to wartość z selecta w index.php
    {
      $sqlAkcp="UPDATE wizyty SET status='Zaakceptowane' WHERE godzina=$i";
      mysqli_query($db,$sqlAkcp);
    }
  }
}
//Odwołanie zaznaczonych wizyt
if(isset($_POST['wizytaOdw']))
{
  for($i=10;$i<19;$i++)
  {
    if(isset($_POST[$i])) // $i to wartość z selecta w index.php
    {
      $sqlAkcp="UPDATE wizyty SET status='Odwolane' WHERE godzina=$i";
      mysqli_query($db,$sqlAkcp);
    }
  }
}

//Aktualizowanie danych użytkownika | Profil

if(isset($_POST['aktualizuj'])) {
  $nazwa = mysqli_real_escape_string($db,$_SESSION['username']);
  $email = mysqli_real_escape_string($db,$_POST['email']);
  $starehaslo = mysqli_real_escape_string($db, $_POST['starehaslo']);
  $nowehaslo = mysqli_real_escape_string($db, $_POST['nowehaslo']);
  $nowehasloSzyfr = md5($nowehaslo); // szyfrowanie nowego hasła
  $starehaslo_w_bazie = mysqli_real_escape_string($db, $_SESSION['password']);

  if (empty($email)) {
  	array_push($errors, "Wprowadz email");
  }
  if (empty($nowehaslo)) {
  	array_push($errors, "Wprowadz nowe haslo");
  }
  else if(strlen($nowehaslo) < 8)
  {
    array_push($errors, "Hasło musi zawierać conajmniej 8 znaków");
  }
  if(md5($starehaslo) !== $starehaslo_w_bazie)
  {
    if (empty($starehaslo)) {
      array_push($errors, "Wprowadz stare haslo");
    }
    else
    {
    array_push($errors, "Podałeś nieprawidłowe stare hasło");
    }
  }
  else
  {
    $sqlZmiana = "UPDATE rejestracja SET email='$email',haslo='$nowehasloSzyfr' WHERE nazwa='$nazwa'";
    mysqli_query($db,$sqlZmiana);
  }
}
?>