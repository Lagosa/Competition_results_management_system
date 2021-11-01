<?php
  require '../php/diakBevezetes.php';
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Versenyfüzet bevezetése | Bevezetés</title>
     <link rel="shortcut icon" href="../images/logo.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../stylesheets/formStyles.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/header.css">
    <script type="text/javascript" src="../javascript/responsive.js"></script>
    <link rel="stylesheet" type="text/css" href="../stylesheets/diakBevezetes.css">

    <link rel="stylesheet" type="text/css" href="../stylesheets/status.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <script type="text/javascript" src="../javascript/diakBevezetes.js"></script>
    <script type="text/javascript" src="../javascript/index_javascript.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript">
      function saveInputValue(fieldId){
        var inputValue = document.getElementById(fieldId+"H");
        inputValue.value = document.getElementById(fieldId).value;
        var helperForm = document.getElementById("helperForm");
        helperForm.submit();
      }

      function versenyTipus(){
        var tipus = document.getElementById("vTipus").value;
        var csapatosInput = document.getElementById("tipus");

        if(tipus === "egyeni"){
          csapatosInput.style.display = "none";
        }else if(tipus === "csapatos"){
          csapatosInput.style.display = "block";
        }
      }

      function resetDisplayValues(){
        <?php echo $displayCsapatSzamInput ?>
      }

      function sendValues(){
        document.getElementById("diakSend").value = document.getElementById("diakH").value;
        document.getElementById("tantargySend").value = document.getElementById("tantargyH").value;
        document.getElementById("tanarSend").value = document.getElementById("tanarH").value;
        document.getElementById("kategoriaSend").value = document.getElementById("kategoriaH").value;
        document.getElementById("versenySend").value = document.getElementById("versenyH").value;
        document.getElementById("versenyMasSend").value = document.getElementById("versenyMasH").value;
        document.getElementById("periodusSend").value = document.getElementById("periodusH").value;
        document.getElementById("szakaszSend").value = document.getElementById("szakaszH").value;
        document.getElementById("eredmenySend").value = document.getElementById("eredmenyH").value;
        document.getElementById("tipusSend").value = document.getElementById("vTipusH").value;
        document.getElementById("csapatSzamSend").value = document.getElementById("csapatSzamH").value;
        document.getElementById("sendForm").submit();
      }
      function mezokUritese(){
        document.getElementById("mezokUriteseForm").submit();
      }
  </script>


  </head>
  <body onload="resetDisplayValues()">
    <div id="tartalom">
      <div id="header">
          <div id="image">
            <img src="../images/icon_diak.png">
            <input type='text' value='<?php echo $oszt ?>' id='osztaly' name='osztaly' readonly>
          </div>
          <div class="options" id="optionsId">
            <div class="bevezetes"><a href="diakBevezetes.php"> Verseny bevezetése </a></div>
            <div class="listazas"><a href="diakListazas.php"> Bevezetések listázása </a> </div>
            <div class="modositas"><a href="diakProfilModositas.php"> Profil módosítása </a> </div>
            <div class="kijelentkezes"> <a href="../php/logout.php"> Kijelentkezés </a></div>
            <div class="hamburger"> <a onclick="showMenu()"> <i class="material-icons">menu</i> </a></div>
          </div>
        </div>

      <div id="bevezetes">
          <div id="bevezetesContainer">
            <form action="../php/saveResults.php">
              <table class="fieldTable" id="diakNeveTable">
                <tr>
                  <td class="label">Diák neve</td>
                  <td>
                    <select name='diak' id='diak' class='textInput' onchange='saveInputValue("diak")'>
                      <?php echo $optDiak ?>
                    </select>
                  </td>
                </tr>
              </table>
              <table class="fieldTable">
                <tr>
                  <td class="label">Tantárgy</td>
                  <td>
                    <select name='tantargy' id='tantargy' class='textInput' onchange='saveInputValue("tantargy")'>
                      <?php echo $optTantargy ?>
                    </select>
                  </td>
                </tr>
                </table>
                <table class="fieldTable">
                <tr>
                  <td class="label">Tanár</td>
                  <td>
                    <select name='tanar' id='tanar' class='textInput' onchange='saveInputValue("tanar")'>
                      <?php echo $optTanar ?>
                    </select>
                  </td>
                </tr>
                </table>
                <table class="fieldTable">
                <tr>
                  <td class="label">Kategoria</td>
                  <td>
                    <select id="kategoria" class="textInput" onchange='saveInputValue("kategoria")'>
                      <?php echo $optKategoria ?>
                    </select>
                  </td>
                </tr>
                </table>
                <table class="fieldTable">
                <tr>
                  <td class="label">Verseny neve</td>
                  <td>

                      <?php if($kategoria != "Mas"){
                        ?>
                        <select name='verseny' id='verseny' class='textInput' onchange='saveInputValue("verseny")'>
                        <?php
                        echo  $optVerseny;
                        ?>
                        </select>
                        <?php
                      }else {
                        if($versenyMas != ""){
                          echo $optVersenyMas;
                        }else{
                        ?>
                        <input type='text'  onblur='saveInputValue("versenyMas")' name='versenyMas' id='versenyMas' class='textInput' placeholder='Írd be...'>
                      <?php }} ?>

                  </td>
                </tr>
                </table>
                <table class="fieldTable">
                <tr>
                  <td class="label">Periódus</td>
                  <td>
                    <select id="periodus" class="textInput" onchange='saveInputValue("periodus")'>
                        <?php echo $optPeriodus ?>
                     </select>
                  </td>
                </tr>
                </table>
                <table class="fieldTable">
                <tr>
                  <td class="label">Szakasz</td>
                  <td>
                    <select id="szakasz" class="textInput" onchange='saveInputValue("szakasz")'>
                      <?php echo $optSzakasz ?>
                    </select>
                  </td>
                </tr>
                </table>
                <table class="fieldTable">
                <tr>
                  <td class="label">Elért eredmény</td>
                  <td>
                    <select id="eredmeny" class="textInput" onchange='saveInputValue("eredmeny")'>
                        <?php echo $optEredmeny ?>
                    </select>
                  </td>
                </tr>
                </table>
                <table class="fieldTable">
                <tr>
                  <td class="label">Típus</td>
                  <td>
                    <select id="vTipus" class="textInput" onchange='saveInputValue("vTipus"),versenyTipus()'>
                      <?php echo $optTipus ?>
                    </select>
                  </td>
                  </tr>
                </table>
                <table class="fieldTable" id="tipus">
                <tr>
                  <td class="label">Csapattagok száma</td>
                  <td>
                  <?php
                      if($csapatSzam != ""){
                        echo $optCsapatSzam;
                      }else{
                    ?>
                    <input type="number" onblur = "saveInputValue('csapatSzam')" min="2" max="50" name="csapatSzam" id="csapatSzam" class="textInput" placeholder="Ird be...">
                    <?php } ?>
                  </td>
                </tr>
              </table>
              </form>
              <div class="submit">
                  <button type="submit"  class="submitInput" onclick="sendValues();">Mentés</button>
                  <button class="submitInput" id="mezokUriteseBTN" onclick="mezokUritese()"> Mezők ürítése </button>
              </div>

          </div>
          <form style="visibility:hidden;" action="../php/saveResults.php" id="helperForm" method="post">
            <input type="text" name="diak" id="diakH" value="<?php echo $diak ?>">
            <input type="text" name="tantargy" id="tantargyH" value="<?php echo $tantargy ?>">
            <input type="text" name="tanar" id="tanarH" value="<?php echo $tanar?>">
            <input type="text" name="kategoria" id="kategoriaH" value="<?php echo $kategoria?>">
            <input type="text" name="verseny" id="versenyH" value="<?php echo $verseny ?>">
            <input type="text" name="versenyMas" id="versenyMasH" value="<?php echo $versenyMas ?>">
            <input type="text" name="periodus" id="periodusH" value="<?php echo $periodus ?>">
            <input type="text" name="szakasz" id="szakaszH" value="<?php echo $szakasz ?>">
            <input type="text" name="eredmeny" id="eredmenyH" value="<?php echo $eredmeny ?>">
            <input type="text" name="tipus" id="vTipusH" value="<?php echo $tipus ?>">
            <input type="text" name="csapatSzam" id="csapatSzamH" value="<?php echo $csapatSzam ?>">
          </form>

          <form style="visibility:hidden;" action="../php/sendValues.php" id="sendForm" method="post">
            <input type="text" name="diak" id="diakSend">
            <input type="text" name="tantargy" id="tantargySend">
            <input type="text" name="tanar" id="tanarSend">
            <input type="text" name="kategoria" id="kategoriaSend">
            <input type="text" name="verseny" id="versenySend">
            <input type="text" name="versenyMas" id="versenyMasSend">
            <input type="text" name="periodus" id="periodusSend">
            <input type="text" name="szakasz" id="szakaszSend">
            <input type="text" name="eredmeny" id="eredmenySend">
            <input type="text" name="tipus" id="tipusSend">
            <input type="text" name="csapatSzam" id="csapatSzamSend">
          </form>
          <form style="visibility:hidden;" id="mezokUriteseForm" action="diakBevezetes.php">
          </form>
      </div>

    </div>
    <?php echo $status ?>
  </body>
</html>
