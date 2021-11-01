<?php
    require 'connectDB.php';

      $oszt = $_POST['osztaly'];
      $pass = $_POST['jelszo'];

      if(empty($pass)){
        header("Location: ../index.php?error=emptyPass");
        exit();
      }else {
        $sql = "SELECT * FROM osztalyok WHERE osztaly=? AND szak=?;";
        $statement = mysqli_stmt_init($dbconn);

        if(!mysqli_stmt_prepare($statement,$sql)){
          header("Location: ../index.php?error=databaseError");
          exit();
        }else{
          $osztaly_szam = strtok($oszt,".");
          $osztaly_szak = strtok(".");
          mysqli_stmt_bind_param($statement,"ss",$osztaly_szam,$osztaly_szak);
          mysqli_stmt_execute($statement);

          $result = mysqli_stmt_get_result($statement);

          $row = mysqli_fetch_assoc($result);
          if($pass === $row['jelszo']){
            session_regenerate_id();
            session_start();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['osztaly'] = "{$osztaly_szam}{$osztaly_szak}";
            $_SESSION['vnev'] = $row['vezeteknev'];
            $_SESSION['knev'] = $row['keresztnev'];
            $_SESSION['jelszo'] = $row['jelszo'];
            $_SESSION['uid'] = $row['id'];

            header("Location: ../pages/diakBevezetes.php");
            exit();
          }else{
            header("Location: ../index.php?error=wrongPass");
            exit();
          }
        }
      }
?>
