<?php
  require 'connectDB.php';


  if(!isset($_POST['jelszo'])){
    header("Location: ../index.php?error=databaseError&details=fieldNotSet");
    exit();
  }
  $pass = $_POST['jelszo'];

  if($pass == ''){
    header("Location: ../index.php?error=emptyFields");
    exit();
  }

  $sql = "SELECT tanarJelszo FROM jelszavak";
  $statement = mysqli_stmt_init($dbconn);
  if(!mysqli_stmt_prepare($statement,$sql)){
    header("Location: ../index.php?error=databaseError");
    exit();
  }
  mysqli_stmt_execute($statement);
  $result = mysqli_stmt_get_result($statement);
  $row = mysqli_fetch_assoc($result);

  if($pass == $row['tanarJelszo']){
    session_regenerate_id();
    session_start();
    $_SESSION['loggedin'] = TRUE;
    header("Location: ../pages/tanarListazas.php");
    exit();
  }else{

    header("Location: ../index.php?error=wrongPass");
    exit();
  }

?>
