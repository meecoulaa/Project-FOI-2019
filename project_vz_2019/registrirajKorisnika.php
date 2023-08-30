<?php
include("zaglavlje.php");
?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="dodajKorisnika">
          <h1 class="h1sredstva">Dodavanje novog korisnika</h1><br>
          <form action="registrirajKorisnika.php" method="post">
            <?php
            $upit="SELECT * FROM `tip_korisnika`";
            $rezultat=upit($bp,$upit);
            if(!isset($_SESSION['kor_id']) || $_SESSION['tip_kor_id'] != 0){
              header("location:index.php");
            }
            else{

              echo "<label for=\"tipKorisnika\"><b>Tip korisnika: </b></label>";
              echo "<select class=\"listaMod\" name=\"tipKorisnika\">";
              while($assoc=mysqli_fetch_assoc($rezultat)){
                echo "<option value=\"{$assoc['tip_korisnika_id']}\">{$assoc['naziv']}</option>";
              }
              echo "</select><br><br>";

              echo "<label for=\"korIme\"><b>Korisničko ime:</b></label>";
              echo "<input type=\"text\" name=\"korIme\" size=\"30\" value=\"\" placeholder=\"Unesite korisničko ime\"><br><br>";

              echo "<label class=\"marginTecaj\" for=\"lozinka\"><b>Lozinka:</b></label>";
              echo "<input type=\"password\" name=\"lozinka\" size=\"30\" value=\"\" placeholder=\"Unesite lozinku\"><br><br>";

              echo "<label for=\"Ime\"><b>Ime:</b></label>";
              echo "<input type=\"text\" name=\"Ime\" size=\"30\" value=\"\" placeholder=\"Unesite ime korisnika\"><br><br>";

              echo "<label for=\"Prezime\"><b>Prezime:</b></label>";
              echo "<input type=\"text\" name=\"Prezime\" size=\"30\" value=\"\" placeholder=\"Unesite prezime korisnika\"><br><br>";

              echo "<label for=\"eMail\"><b>E-mail:</b></label>";
              echo "<input type=\"text\" name=\"eMail\" size=\"30\" value=\"\" placeholder=\"Unesite e-Mail\"><br><br>";

              echo "<label for=\"slikaUrl\"><b>Slika(URL)</b></label>";
              echo "<input type=\"text\" name=\"slikaUrl\" size=\"30\" value=\"\" placeholder=\"Unesite URL slike\"><br><br><br>";

              echo "<input class=\"submit\" type=\"submit\" name=\"submit\" value=\"Dodaj korisnika\" /><br><br>";

              if(isset($_POST['submit'])){
                $greska="";
                $tip_korisnika_id=$_POST['tipKorisnika'];
                $korime=$_POST['korIme'];
                $lozinka=$_POST['lozinka'];
                $ime=$_POST['Ime'];
                $prezime=$_POST['Prezime'];
                $email=$_POST['eMail'];
                $slikaUrl=$_POST['slikaUrl'];

                if(empty($korime)){
                  $greska = "<p style=\"color:red;\"><b>Sva polja su obavezna! </b></p>";
                }
                if(empty($lozinka)){
                  $greska = "<p style=\"color:red;\"><b>Sva polja su obavezna!  </b></p>";
                }
                if(empty($ime)){
                  $greska = "<p style=\"color:red;\"><b>Sva polja su obavezna!  </b></p>";
                }
                if(empty($prezime)){
                  $greska = "<p style=\"color:red;\"><b>Sva polja su obavezna!  </b></p>";
                }
                if(empty($email)){
                  $greska = "<p style=\"color:red;\"><b>Sva polja su obavezna!  </b></p>";
                }
                if(empty($slikaUrl)){
                  $greska = "<p style=\"color:red;\"><b>Sva polja su obavezna!  </b></p>";
                }

                if(empty($greska)){
                  $upit2="INSERT INTO korisnik (tip_korisnika_id,korisnicko_ime,lozinka,ime,prezime,email,slika)
                  VALUES ('$tip_korisnika_id','$korime','$lozinka','$ime','$prezime','$email','$slikaUrl')";
                  upit($bp,$upit2);
                  echo "<p style=\"color:green;\"><b>Uspješno ste dodali novog korisnika!</b></p>";
                }
              }
              if(!empty($greska)){
                echo $greska;
              }
            }

            ?>
          </form>

        </div>

      </div>
    </section>

<?php include("podnozje.php"); ?>
