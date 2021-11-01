<!--
	PHP section
-->

<?php
	session_start();

	$status = "";
	if(isset($_GET['error'])){
		if($_GET['error'] === 'emptyPass'){
			  $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'> Üresen maradt a jelszó mező!</td></tr></table>";
		}else
		if($_GET['error'] === 'databaseError'){
			  $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'> Hiba történt. <br> Próbáld újra!</td></tr></table>";
		}else
		if($_GET['error'] === 'wrongPass'){
			  $status = "<table class='errors'><tr><td id='wtd'><i class='material-icons'>warning</i></td><td id='ttd'> Helytelen jelszó! </td></tr></table>";
		}
	}else
	if(isset($_GET['success'])){
    $status = "<table class='success'><tr><td id='wtd'><i class='material-icons'>done</i></td><td id='ttd'>Sikeresen bejelentkezve!</td></tr></table>";
	}


?>

<?php
		require 'php/connectDB.php';
		$oszt_query = "SELECT osztaly,szak FROM osztalyok ORDER BY osztaly asc, szak asc";

		$result = mysqli_query($dbconn,$oszt_query) or die ("Bad SQL: { $oszt_query } Adatbázis nincs inicializálva! ");

		$opt = "<select name='osztaly' id='osztaly' required>";
		while($row = mysqli_fetch_assoc($result)){
			$opt .= "<option value='{$row['osztaly']}.{$row['szak']}'>{$row['osztaly']}.{$row['szak']}</option>";
		}

		$opt .= "</select>";

?>

<!--
	HTML section
-->

<!DOCTYPE html>
<html>
	<head>
		<title>Versenyfüzet bevezetése | Bejelentkezés</title>

		<link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">

		<charset meta="utf-8">

		<link rel="stylesheet" type="text/css" href="stylesheets/formStyles.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="stylesheets/index.css">
		<link rel="stylesheet" type="text/css" href="stylesheets/status.css">

		<script type="text/javascript" src="javascript/index_javascript.js"></script>
	</head>
	<body>
		<div id="teljes_oldal">
			<div id="header">
				<div id="h_text">
					Versenyfüzet bevezetése
				</div>
			</div>
			<div id="container">
				<div id="content">
	<!-- Kiválasztó gombok -->
					<div>
						<button id="diak" onclick="display('diakForm','adminForm','tanarForm')">
								<img src="images/icon_diak.png">
								Diák
						</button>

						<button id="tanar" onclick="display('tanarForm','diakForm','adminForm')">
								<img src="images/icon_tanar.png">
								 Tanár
						</button>
						<button id="admin" onclick="display('adminForm','diakForm','tanarForm')">
								<img src="images/icon_admin.png">
								 Admin
						</button>
<!-- Bejelentkezési panelok -->
					</div>
				</div>
					<div id="login">
						<!-- Diák bejelentkezése -->
							<form id="diakForm" action="php/diakLogin.php" method="post">
								<table class="fieldTable">
									<tr>
										<td> <i class="material-icons">class</i></td>
										<td>
											<?php echo $opt ?>
									</td>
								</tr>
								</table>
								<table class="fieldTable">
									<tr>
										<td> <i class="material-icons">lock</i></td>
										<td><input type="password" name="jelszo" id="jelszoDiak" class="textInput" placeholder=" Jelszó..."></td>
										<td> <div onclick="showPass('jelszoDiak')" id="showPass"> <i class="material-icons">remove_red_eye</i></div></td>
									</tr>
								</table>
								<div id="submit">
								<input type="submit"  value="Bejelentkezés" class="submitInput">
								</div>
							</form>
							<!-- Tanár bejelentkezése -->
							<form id="tanarForm" action="php/tanarLogin.php" method="post">
								<table class="fieldTable">
									<tr>
										<td> <i class="material-icons">lock</i></td>
										<td><input type="password" name="jelszo" id="jelszoTanar" class="textInput" placeholder=" Jelszó..."></td>
										<td><div onclick="showPass('jelszoTanar')" id="showPass"> <i class="material-icons">remove_red_eye</i></div></td>
									</tr>
								</table>
								<div id="submit">
								<input type="submit"  value="Bejelentkezés" class="submitInput">
							</div>
							</form>
							<!-- Admin bejelentkezése -->
							<form id="adminForm" action="php/adminLogin.php" method="post">
								<table class="fieldTable">
									<tr>
										<td> <i class="material-icons">lock</i></td>
										<td><input type="password" name="jelszo" id="jelszoAdmin" class="textInput"  placeholder=" Jelszó..."></td>
										<td><div onclick="showPass('jelszoAdmin')" id="showPass"> <i class="material-icons">remove_red_eye</i></div></td>
									</tr>
								</table>
								<div id="submit">
								<input type="submit"  value="Bejelentkezés" class="submitInput">
							</div>
							</form>

					</div>
			</div>
			<?php echo $status ?>
		</div>
	</body>
</html>
