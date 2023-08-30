<?php
include("zaglavlje.php");
?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="azurirajKorisnika">
          <h1 class="h1sredstva">Ažuriranje korisnika</h1><br>
          <?php $korisnik=$_GET['korisnik']; ?>
          <form action="azurirajKorisnika.php?korisnik=<?php echo $korisnik; ?>" method="post">
            <?php
            $upit="SELECT * FROM `tip_korisnika`";
            $rezultat=upit($bp,$upit);
            $upit2="SELECT * FROM korisnik WHERE korisnik_id = $korisnik";
            $rezultat2=upit($bp,$upit2);
            $assoc2=mysqli_fetch_assoc($rezultat2);
            if(!isset($_SESSION['kor_id']) || $_SESSION['tip_kor_id'] != 0){
              header("location:index.php");
            }
            else{

              echo "<p style=\"text-align:center;\"><b>Korisnik ID: $korisnik <b></p>";
              echo "<label for=\"tipKorisnika\"><b>Tip korisnika: </b></label>";
              echo "<select class=\"listaMod\" name=\"tipKorisnika\">";
              while($assoc=mysqli_fetch_assoc($rezultat)){
                echo "<option value=\"{$assoc['tip_korisnika_id']}\">{$assoc['naziv']}</option>";
              }
              echo "</select><br><br>";

              echo "<label for=\"korIme\"><b>Korisničko ime:</b></label>";
              echo "<input type=\"text\" name=\"korIme\" size=\"30\" value=\"{$assoc2['korisnicko_ime']}\" placeholder=\"Unesite korisničko ime\"><br><br>";

              echo "<label class=\"marginTecaj\" for=\"lozinka\"><b>Lozinka:</b></label>";
              echo "<input type=\"text\" name=\"lozinka\" size=\"30\" value=\"{$assoc2['lozinka']}\" placeholder=\"Unesite lozinku\"><br><br>";

              echo "<label for=\"Ime\"><b>Ime:</b></label>";
              echo "<input type=\"text\" name=\"Ime\" size=\"30\" value=\"{$assoc2['ime']}\" placeholder=\"Unesite ime korisnika\"><br><br>";

              echo "<label for=\"Prezime\"><b>Prezime:</b></label>";
              echo "<input type=\"text\" name=\"Prezime\" size=\"30\" value=\"{$assoc2['prezime']}\" placeholder=\"Unesite prezime korisnika\"><br><br>";

              echo "<label for=\"eMail\"><b>E-mail:</b></label>";
              echo "<input type=\"text\" name=\"eMail\" size=\"30\" value=\"{$assoc2['email']}\" placeholder=\"Unesite e-Mail\"><br><br>";

              echo "<label for=\"slikaUrl\"><b>Slika(URL)</b></label>";
              echo "<input type=\"text\" name=\"slikaUrl\" size=\"30\" value=\"{$assoc2['slika']}\" placeholder=\"Unesite URL slike\"><br><br><br>";

              echo "<input class=\"submit\" type=\"submit\" name=\"submit\" value=\"Ažuriraj korisnika\" /><br><br>";

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
                  $upit3="UPDATE korisnik SET
                  tip_korisnika_id='$tip_korisnika_id',
                  korisnicko_ime='$korime',
                  lozinka='$lozinka',
                  ime='$ime',
                  prezime ='$prezime',
                  email='$email',
                  slika='$slikaUrl'
                  WHERE korisnik_id='$korisnik'";
                  upit($bp,$upit3);
                  echo "<p style=\"color:green;\">Uspješno ste ažurirali korisnika!</p>";
              }
              if(!empty($greska)){
                echo $greska;
              }
            }
          }
            ?>
          </form>
        </div>

      </div>
    </section>

<?php include("podnozje.php"); ?>
