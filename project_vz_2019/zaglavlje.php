<?php
	include("baza.php");
	$bp=spoji();
	session_start();
?>

<!DOCTYPE html>
<html lang="hr">
	<head>
		<title>Virtualna mjenjačnica</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="autor" content="Toni Mijic"/>
		<meta name="godina" content="2021"/>
		<meta charset="utf-8"/>
		<link href="style.css" rel="stylesheet" type="text/css"/>
	</head>
  <body>
    <header>

			<nav>

				<a class="pocetna" href="index.php">Početna</a>
				<?php


				if(isset($_SESSION['tip_kor_id'])){
					if(($_SESSION['tip_kor_id']) == 0){
						echo "<a class=\"sredstva\" href=\"sredstva.php\">Sredstva</a>";
						echo "<a class=\"zahtjevi\" href=\"zahtjevi.php\">Zahtjevi</a>";
						echo "<div class=\"korisnik\">
											<p>{$_SESSION['kor_ime']}</p>
											<img src=\"{$_SESSION['slika']}\" height=\"55\" width=\"50\">
										</div>";
						echo "<a class=\"prijava\" href=\"zaglavlje.php?odjava=1\"><img height=\"20\" width=\"20\" src=\"img/odjava.png\"></a>";

					}
					elseif(($_SESSION['tip_kor_id']) == 1){
						echo "<a class=\"sredstva\" href=\"sredstva.php\">Sredstva</a>";
						echo "<a class=\"zahtjevi\" href=\"zahtjevi.php\">Zahtjevi</a>";
						echo "<div class=\"korisnik\">
											<p>{$_SESSION['kor_ime']}</p>
											<img src=\"{$_SESSION['slika']}\" height=\"55\" width=\"50\">
										</div>";
						echo "<a class=\"prijava\" href=\"zaglavlje.php?odjava=1\"><img height=\"20\" width=\"20\" src=\"img/odjava.png\"></a>";
					}
					elseif(($_SESSION['tip_kor_id']) == 2){
						echo "<a class=\"sredstva\" href=\"sredstva.php\">Sredstva</a>";
						echo "<a class=\"zahtjevi\" href=\"zahtjevi.php\">Zahtjevi</a>";
						echo "<div class=\"korisnik\">
											<p>{$_SESSION['kor_ime']}</p>
											<img src=\"{$_SESSION['slika']}\" height=\"55\" width=\"50\">
										</div>";
						echo "<a class=\"prijava\" href=\"zaglavlje.php?odjava=1\"><img height=\"20\" width=\"20\" src=\"img/odjava.png\"></a>";

					}
				}
				else{

					echo "<a class=\"prijava\" href=\"prijava.php\">Prijava</a>";
				}
				?>
				<h1 id="naslov">VIRTUALNA MJENJAČNICA</h1>

			</nav>
			<nav>
				<?php
				if(isset($_SESSION['tip_kor_id'])){
					if(($_SESSION['tip_kor_id']) == 0){
						echo "<a class=\"prihvati\" href=\"prihvatiZahtjev.php\">Prihvati zahtjev</a>";
						echo "<a class=\"filtriraj\" href=\"filtrirajZahtjeve.php\">Filtriraj zahtjeve</a>";
						echo "<a class=\"korisnici\" href=\"korisnici.php\">Korisnici</a>";
					}
					elseif(($_SESSION['tip_kor_id']) == 1){
						echo "<a class=\"prihvati\" href=\"prihvatiZahtjev.php\">Prihvati zahtjev</a>";
					}
				}
				?>
			</nav>
			<?php
			if(isset($_GET['odjava'])){			
				unset($_SESSION['kor_ime']);
				unset($_SESSION['tip_kor_id']);
				unset($_SESSION['kor_id']);
				unset($_SESSION['ime']);
				unset($_SESSION['slika']);
				session_destroy();
				header("Location: index.php");
			}
			?>
    </header>
		<br>
