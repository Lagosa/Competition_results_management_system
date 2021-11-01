<?php
  require 'connectDB.php';

  $pass = $_POST['jelszo'];

  if($pass == ''){
    header("Location: ../index.php?error=emptyPass");
    exit();
  }

  $passDBRes = mysqli_query($dbconn,"SELECT adminJelszo FROM jelszavak");
  $passRow = mysqli_fetch_assoc($passDBRes);

  if($pass == $passRow['adminJelszo']){
    session_regenerate_id();
    session_start();
    $_SESSION['loggedin'] = TRUE;
    header("Location: ../pages/adminOldal.php");
    exit();
  }else{
    header("Location: ../index.php?error=wrongPass");
    exit();
  }
?>
