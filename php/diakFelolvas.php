<?php
  require_once '../files/mpdf/vendor/autoload.php';
  require 'connectDB.php';

  $osztaly= "";
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
  $pdf -> WriteCell(93,10,'~ diákok felolvasására ~',0,0,'C');
  $pdf -> WriteCell(20,10,'',0,0,'C');
  $pdf -> SetFont('Courier','I','15');
  $pdf -> WriteCell(35,10,'osztály: ',0,0,'C');
  $pdf -> SetFont('Courier','B','15');
  $pdf -> WriteCell(37,10,$osztaly,0,0,'L');

  $pdf -> Ln();
  $pdf -> WriteCell(277,20,'',0,0,'L');

  $pdf -> Ln();
  $sorsz = 1;
  $pdf -> SetFont('Courier','','10');
  $table = "<style>
  table{hypenate:auto;vertical-align:middle;text-align:center;width:100%;}
  .hTd{font-family:Arial;font-weight:bold;border-bottom:2px solid black; background-color:#cccccc;}
  td{border-bottom:1px solid black;} </style>";

  if($osztaly == 'elemi' || $osztaly == 'gimnázium' || $osztaly == 'líceum'){
    $table .= "<table> <tr > <td class='hTd'> Osztály </td> <td class='hTd'> Diák </td><td class='hTd'> Verseny </td><td class='hTd'> Szakasz </td>
    <td class='hTd'> Kategória </td><td class='hTd'> Eredmény </td><td class='hTd'> Típus </td><td class='hTd'> Csapat. Szám. </td></tr>";

    $osztalyok = mysqli_query($dbconn,"SELECT osztaly,szak FROM osztalyok WHERE szakasz = '".$osztaly."' ORDER BY osztaly asc, szak asc");
    while($row = mysqli_fetch_assoc($osztalyok)){
      // Lekéri az eredményeket
        $eredmenyekRes = mysqli_query($dbconn,"SELECT * FROM eredmenyek WHERE osztaly = '".$row['osztaly'].$row['szak']."' AND felolvasva = 0 ORDER BY diakId asc, megnevezes asc");
     // Meghatározza hány eredmény van abból az osztályból
        $eredmenyekNrRes = mysqli_query($dbconn,"SELECT COUNT(id) AS rowNr FROM eredmenyek WHERE osztaly = '".$row['osztaly'].$row['szak']."'");
        $eredmenyekNr = mysqli_fetch_assoc($eredmenyekNrRes);
        $first = "1";
        while($rowEredmeny = mysqli_fetch_assoc($eredmenyekRes)){
          if($sorsz % 2 == 0){
            $color = "#eeeeee";
          }else{
            $color = "white";
          }
          $diakNeveRes = mysqli_query($dbdiakconn,"SELECT vezeteknev,keresztnev FROM ".$rowEredmeny['osztaly']." WHERE id = ".$rowEredmeny['diakId']);
          $diakNeveRow = mysqli_fetch_assoc($diakNeveRes);
      // Létrehozza a sorokat, egy akkora első oszlopos egybe olvasztással, ahány eredmény volt abból a bizonyos osztályból
          if($first == "1"){
            $table .= "<tr style='background-color:".$color.";'><td style='background-color:white;' rowspan='".$eredmenyekNr['rowNr']."'>" . $rowEredmeny['osztaly'] . "</td><td>".$diakNeveRow['vezeteknev']." ".$diakNeveRow['keresztnev']."</td><td>".$rowEredmeny['megnevezes'].
            "</td><td>".$rowEredmeny['szakasz']."</td><td>".$rowEredmeny['kategoria']."</td><td>".$rowEredmeny['eredmeny']."
            </td><td>".$rowEredmeny['tipus']."</td><td>".$rowEredmeny['csapatSzam']."</td> </tr>";
            $first = "0";
          }else {
            $table .= "<tr style='background-color:".$color.";'><td>".$diakNeveRow['vezeteknev']." ".$diakNeveRow['keresztnev']."</td><td>".$rowEredmeny['megnevezes'].
            "</td><td>".$rowEredmeny['szakasz']."</td><td>".$rowEredmeny['kategoria']."</td><td>".$rowEredmeny['eredmeny']."
            </td><td>".$rowEredmeny['tipus']."</td><td>".$rowEredmeny['csapatSzam']."</td> </tr>";
          }

          $sorsz = $sorsz + 1;
        }
    }
  }else if($osztaly == 'osszes'){
    $table .= "<table> <tr > <td class='hTd'> Osztály </td> <td class='hTd'> Diák </td><td class='hTd'> Verseny </td><td class='hTd'> Szakasz </td>
    <td class='hTd'> Kategória </td><td class='hTd'> Eredmény </td><td class='hTd'> Típus </td><td class='hTd'> Csapat. Szám. </td></tr>";

    $osztalyok = mysqli_query($dbconn,"SELECT osztaly,szak FROM osztalyok ORDER BY osztaly asc, szak asc");
    while($row = mysqli_fetch_assoc($osztalyok)){
        $eredmenyekRes = mysqli_query($dbconn,"SELECT * FROM eredmenyek WHERE osztaly = '".$row['osztaly'].$row['szak']."' AND felolvasva = 0 ORDER BY diakId asc, megnevezes asc");
        $eredmenyekNrRes = mysqli_query($dbconn,"SELECT COUNT(id) AS rowNr FROM eredmenyek WHERE osztaly = '".$row['osztaly'].$row['szak']."'");
        $eredmenyekNr = mysqli_fetch_assoc($eredmenyekNrRes);
        $first = "1";
        while($rowEredmeny = mysqli_fetch_assoc($eredmenyekRes)){
          if($sorsz % 2 == 0){
            $color = "#eeeeee";
          }else{
            $color = "white";
          }
          $diakNeveRes = mysqli_query($dbdiakconn,"SELECT vezeteknev,keresztnev FROM ".$rowEredmeny['osztaly']." WHERE id = ".$rowEredmeny['diakId']);
          $diakNeveRow = mysqli_fetch_assoc($diakNeveRes);
          if($first == "1"){
            $table .= "<tr style='background-color:".$color.";'><td style='background-color:white;' rowspan='".$eredmenyekNr['rowNr']."'>" . $rowEredmeny['osztaly'] . "</td><td>".$diakNeveRow['vezeteknev']." ".$diakNeveRow['keresztnev']."</td><td>".$rowEredmeny['megnevezes'].
            "</td><td>".$rowEredmeny['szakasz']."</td><td>".$rowEredmeny['kategoria']."</td><td>".$rowEredmeny['eredmeny']."
            </td><td>".$rowEredmeny['tipus']."</td><td>".$rowEredmeny['csapatSzam']."</td> </tr>";
            $first = "0";
          }else {
            $table .= "<tr style='background-color:".$color.";'><td>".$diakNeveRow['vezeteknev']." ".$diakNeveRow['keresztnev']."</td><td>".$rowEredmeny['megnevezes'].
            "</td><td>".$rowEredmeny['szakasz']."</td><td>".$rowEredmeny['kategoria']."</td><td>".$rowEredmeny['eredmeny']."
            </td><td>".$rowEredmeny['tipus']."</td><td>".$rowEredmeny['csapatSzam']."</td> </tr>";
          }

          $sorsz = $sorsz + 1;
        }
    }
  }else{
    $table .= "<table> <tr > <td class='hTd'> Sorsz. </td> <td class='hTd'> Diák </td><td class='hTd'> Verseny </td><td class='hTd'> Szakasz </td>
    <td class='hTd'> Kategória </td><td class='hTd'> Eredmény </td><td class='hTd'> Típus </td><td class='hTd'> Csapat. Szám. </td></tr>";

    $eredmenyekRes = mysqli_query($dbconn,"SELECT * FROM eredmenyek WHERE osztaly = '".$osztaly."'  AND felolvasva = 0 ORDER BY diakId asc, megnevezes asc");
    while($rowEredmeny = mysqli_fetch_assoc($eredmenyekRes)){
      if($sorsz % 2 == 0){
        $color = "#eeeeee";
      }else{
        $color = "white";
      }
      $diakNeveRes = mysqli_query($dbdiakconn,"SELECT vezeteknev,keresztnev FROM ".$osztaly." WHERE id = ".$rowEredmeny['diakId']);
      $diakNeveRow = mysqli_fetch_assoc($diakNeveRes);
      $table .= "<tr style='background-color:".$color.";'><td>" . $sorsz . "</td><td>".$diakNeveRow['vezeteknev']." ".$diakNeveRow['keresztnev']."</td><td>".$rowEredmeny['megnevezes'].
      "</td><td>".$rowEredmeny['szakasz']."</td><td>".$rowEredmeny['kategoria']."</td><td>".$rowEredmeny['eredmeny']."
      </td><td>".$rowEredmeny['tipus']."</td><td>".$rowEredmeny['csapatSzam']."</td> </tr>";

      $sorsz = $sorsz + 1;
    }
  }


  $table .= "</table>";
  $pdf -> WriteHTML($table);

  $pdf -> Output("diakok_felolvasasa_(".$osztaly.").pdf",'I');

?>
