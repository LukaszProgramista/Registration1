<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'salonfryzjerski');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);


  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Brak nazwy uzytkownika!!"); }
  if (empty($email)) { array_push($errors, "Brak Emaila!!"); }
  if (empty($password_1)) { array_push($errors, "Brak hasla!!"); }
  if(strlen($password_1) < 8) { array_push($errors, "Hasło musi zawierać conajmniej 8 znaków"); }



  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM rejestracja WHERE nazwa='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['nazwa'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO rejestracja (nazwa, haslo, email) 
  			  VALUES('$username', '$password', '$email')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	header('location: index.php');
  }
}
// LOGIN USER
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
// dodawanie ksiazek czy tam czegos do bazy lista

if(isset($_POST['wizyta']))
{
  $nazwa = mysqli_real_escape_string($db,$_SESSION['username']);
  $email = mysqli_real_escape_string($db,$_SESSION['email']);
  $godzina_wizyty =mysqli_real_escape_string($db, $_POST['godzina_wizyty']);
  $rodzaj_wizyty =mysqli_real_escape_string($db, $_POST['usluga_wizyty']);
  $query = "SELECT * FROM wizyty WHERE godzina='$godzina_wizyty'";
  $result = mysqli_query($db, $query);
  if (mysqli_num_rows($result) == 0)
  {
    $sqlWstaw = "INSERT INTO `wizyty` (`godzina`, `nazwa`, `email`,`usluga`,`status`,`termin`) VALUES ('$godzina_wizyty','$nazwa','$email','$rodzaj_wizyty','Oczekiwanie na akceptacje','zajete')";
    mysqli_query($db, $sqlWstaw);
  }
  else
  {
    array_push($errors, "Godzina zajęta, wybierz inny termin");
  }
 }

 if(isset($_POST['wizytaDel']))
{
  $query = "DELETE FROM wizyty";
  $result = mysqli_query($db, $query);
}

if(isset($_POST['wizytaAkc']))
{
  for($i=10;$i<19;$i++)
  {
    if(isset($_POST[$i]))
    {
      $sqlAkcp="UPDATE wizyty SET status='Zaakceptowane' WHERE godzina=$i";
      mysqli_query($db,$sqlAkcp);
    }
  }
}

if(isset($_POST['wizytaOdw']))
{
  for($i=10;$i<19;$i++)
  {
    if(isset($_POST[$i]))
    {
      $sqlAkcp="UPDATE wizyty SET status='Odwolane' WHERE godzina=$i";
      mysqli_query($db,$sqlAkcp);
    }
  }
}

if(isset($_POST['update'])) {
  $nazwa = mysqli_real_escape_string($db,$_SESSION['username']);
  $email = mysqli_real_escape_string($db,$_POST['email']);
  $starehaslo = mysqli_real_escape_string($db, $_POST['starehaslo']);
  $nowehaslo = mysqli_real_escape_string($db, $_POST['nowehaslo']);
  $nowehasloSzyfr = md5($nowehaslo);
  $starehaslo_w_bazie = mysqli_real_escape_string($db, $_SESSION['password']);
  echo md5($starehaslo)."<br>";
  echo $starehaslo_w_bazie;

  if (empty($email)) {
  	array_push($errors, "Wprowadz email");
  }
  if (empty($nowehaslo)) {
  	array_push($errors, "Wprowadz nowe haslo");
  }
  if(md5($starehaslo) !== $starehaslo_w_bazie)
  {
    if (empty($starehaslo)) {
      array_push($errors, "Wprowadz stare haslo");
    }
    else if(strlen($starehaslo) < 8)
    {
      array_push($errors, "Hasło musi zawierać conajmniej 8 znaków");
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