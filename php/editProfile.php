<?php
    require 'connectDB.php';
    require 'sessionInformation.php';
    $uvnev = $_POST['vezeteknev'];
    $uknev = $_POST['keresztnev'];
    $ujelszo = $_POST['jelszo'];
    $ujelszo_ujra = $_POST['jelszoUjra'];

    if(empty($uvnev) or empty($uknev) or empty($ujelszo) or empty($ujelszo_ujra)){
      header("Location: ../pages/diakProfilModositas.php?error=emptyFields");
      exit();
    }else if($ujelszo !== $ujelszo_ujra){
      header("Location: ../pages/diakProfilModositas.php?error=passwordNotTheSame");
      exit();
    }else{
        $sql = "UPDATE osztalyok SET jelszo='$ujelszo',vezeteknev='$uvnev',keresztnev='$uknev' WHERE id = '$uid'";
        
        $res = mysqli_query($dbconn,$sql);

        if($res != 0 ){
          $_SESSION['vnev'] = $uvnev;
          $_SESSION['knev'] = $uknev;
          $_SESSION['jelszo'] = $ujelszo;
          header("Location: ../pages/diakProfilModositas.php?success");
          exit();
        }
        else
        {
          header("Location: ../pages/diakProfilModositas.php?error=somethingWentWrong");
          exit();
        }



    }



?>
