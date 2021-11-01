<?php
  require 'connectDB.php';
  require_once '../files/mpdf/vendor/autoload.php';

  $osztaly  = "";
  $osztaly .= $_POST['osztaly'];

  $pdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
  $pdf -> AddPage();
  $pdf -> SetFont('Arial','B','20');
  $pdf->SHYlang = 'en';
  $pdf->SHYleftmin = 3;
  $pdf -> setFooter('{PAGENO}');
  $pdf -> WriteCell(277,10,'Versenyeredmények',0,0,'C');

  $pdf -> Ln();
  $pdf -> SetFont('Arial','I','17');
  $pdf -> WriteCell(92,10,'',0,0,'C');
  $pdf -> WriteCell(93,10,'~ diákok pontszáma ~',0,0,'C');
  $pdf -> WriteCell(20,10,'',0,0,'C');
  $pdf -> SetFont('Courier','I','15');
  $pdf -> WriteCell(35,10,'osztály: ',0,0,'C');
  $pdf -> SetFont('Courier','B','15');
  $pdf -> WriteCell(37,10,$osztaly,0,0,'L');

  $pdf -> Ln();
  $pdf -> WriteCell(277,20,'',0,0,'L');

  $pdf -> Ln();


  $table = "<style>
  table{hypenate:auto;vertical-align:middle;text-align:center;width:100%;}
  .hTd{font-family:Arial;font-weight:bold;border-bottom:2px solid black; background-color:#cccccc;}
  td{border-bottom:1px solid black;} </style>";

  $sorsz = 1;

  if($osztaly == 'elemi' || $osztaly == 'gimnázium' || $osztaly == 'líceum' || $osztaly == 'osszes'){
    $table .= "<table><tr> <td class='hTd'> Osztály </td><td class='hTd'> Diák neve </td>><td class='hTd'> Pontszám </td></tr>";

    if($osztaly != 'osszes'){
      $osztalyRes = mysqli_query($dbconn,"SELECT osztaly,szak FROM osztalyok WHERE szakasz = '".$osztaly."' ORDER BY osztaly asc, szak asc");

    }else{
      $osztalyRes = mysqli_query($dbconn,"SELECT osztaly,szak FROM osztalyok ORDER BY osztaly asc, szak asc");

    }
    $sorsz = 1;
    while($row = mysqli_fetch_assoc($osztalyRes)){
      $diakRes = mysqli_query($dbdiakconn,"SELECT * from ".$row['osztaly'].$row['szak']);
      $diakNrRes = mysqli_query($dbdiakconn,"SELECT COUNT(id) AS rowNr FROM ".$row['osztaly'].$row['szak']);
      $diakNr = mysqli_fetch_assoc($diakNrRes);

      $elso = 1;

      while($rowDiak = mysqli_fetch_assoc($diakRes)){
        if($sorsz % 2 == 0){
          $color = "#eeeeee";
        }else{
          $color = "white";
        }

        if($elso == 1){
          $table .= "<tr> <td rowspan='".$diakNr['rowNr']."'> ".$row['osztaly'].$row['szak']." </td> <td> ".$rowDiak['vezeteknev']." ".$rowDiak['keresztnev']."</td><td> "
          .$rowDiak['pontszam']." </td></tr>";
          $elso = 0;
        }else{
          $table .= "<tr style='background-color:".$color.";'> <td> ".$rowDiak['vezeteknev']." ".$rowDiak['keresztnev']." </td><td> ".$rowDiak['pontszam']." </td></tr>";
          $sorsz = $sorsz + 1;
        }
      }
    }
  }else{
    $table .= "<table><tr> <td class='hTd'> Diák neve </td><td class='hTd'> Verseny megnevezése </td><td class='hTd'> Szakasz </td>
    <td class='hTd'> Kategória </td><td class='hTd'> Eredmény </td><td class='hTd'> Pontszám </td><td class='hTd'> Összesen </td></tr>";

    $diakRes = mysqli_query($dbdiakconn,"SELECT * FROM ".$osztaly);

    while($row = mysqli_fetch_assoc($diakRes)){
      if($sorsz % 2 == 0){
        $color = "#eeeeee";
      }else{
        $color = "white";
      }
      if($row['pontszam'] != 0){
        $diakVersenyRes = mysqli_query($dbconn,"SELECT megnevezes,pontszamDiak,szakasz,kategoria,eredmeny FROM eredmenyek WHERE diakId = ".$row['id']." AND osztaly = '".$osztaly."'");
        $diakVersenyNrRes = mysqli_query($dbconn,"SELECT COUNT(megnevezes) as rowNr FROM eredmenyek WHERE diakId = ".$row['id'] ." AND osztaly = '".$osztaly."'");
        $diakVersenyNr = mysqli_fetch_assoc($diakVersenyNrRes);

        $elso = "1";
        while($rowEredmeny = mysqli_fetch_assoc($diakVersenyRes)){

          if($elso == "1"){
            $table .= "<tr style='background-color:".$color.";'><td rowspan='".$diakVersenyNr['rowNr']."'>".$row['vezeteknev']." ".$row['keresztnev']."</td><td>".$rowEredmeny['megnevezes']."</td><td>".$rowEredmeny['szakasz']."</td><td>".$rowEredmeny['kategoria']."
            </td><td>".$rowEredmeny['eredmeny']."</td><td>".$rowEredmeny['pontszamDiak']."</td><td rowspan='".$diakVersenyNr['rowNr']."'>".$row['pontszam']."</td></tr>";
            $elso = "0";
          }else{
            $table .= "<tr style='background-color:".$color.";'><td>".$rowEredmeny['megnevezes']."</td><td>".$rowEredmeny['szakasz']."</td><td>".$rowEredmeny['kategoria']."
            </td><td>".$rowEredmeny['eredmeny']."</td><td>".$rowEredmeny['pontszamDiak']."</td></tr>";
          }
        }
      }else{
        $table .= "<tr style='background-color:".$color.";'><td> ".$row['vezeteknev']." ".$row['keresztnev']."</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>0</td></tr>";
      }
      $sorsz = $sorsz + 1;
    }
  }

  $table .= "</table>";
  $pdf -> WriteHTML($table);
  $pdf -> Output("diakok_pontszama_(".$osztaly.").pdf",'I');
?>
