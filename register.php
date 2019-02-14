<?php
  include("./connect_db.php");

  function sanitize($raw_data) {
    global $conn;
    $data = htmlspecialchars($raw_data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
  }


  
  // Het email is nu schoongemaakt en fraudebestendig
  $email = sanitize($_POST["email"]);

  // Maak een selectie query voor het ingevulde emailadres
  $sql = "SELECT * FROM `login` WHERE `email` = '$email'";

  // Vuur de query af op de database
  $result = mysqli_query($conn, $sql);

  // Tel het aantal resultaten uit de database voor dat emailadres
  if ( mysqli_num_rows($result) == 1 ) {
    echo '<div class="alert alert-info" role="alert">
            Uw emailadres bestaat al. Kies een ander emailadres...
          </div>';
          header("Refresh: 4; url=./index.php?content=registerform");
  } else {

  // We maken onze insert-query
  $sql = "INSERT INTO `login` (`id`,
                               `email`,
                               `password`)
                    VALUES    (NULL,
                               '$email',
                               'geheim')";

  $result = mysqli_query($conn,$sql);

  // var_dump($result);

  if ($result) {
    echo '<div class="alert alert-success" role="alert">
            U heeft een email gekregen met een activatielink. Klik hierop om het registreren te voltooien
          </div>';
    header("Refresh: 4; url=./index.php?content=registerform");
  } else {
    echo '<div class="alert alert-danger" role="alert">
            Er is iets mis gegaan met de registratie, probeer het opnieuw.
          </div>';
    header("Refresh: 4; url=./index.php?content=registerform");    
  }

}
?>