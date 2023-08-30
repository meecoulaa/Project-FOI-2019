<?php

include("zaglavlje.php");
?>
    <section class="sadrzaj">
      <div class="sadrzajWrap" >
        <?php
        $greska="";
        if(isset($_SESSION['tip_kor_id'])){
          header("location:index.php");
        }
        elseif(isset($_POST['submit'])) {
          $korime=($_POST['korime']);
          $lozinka=($_POST['lozinka']);
          if(empty($korime) || empty($lozinka)){
            $greska="<p>Unesite korisničko ime i lozinku!<p>";
          }
          else {
            $upit="SELECT * FROM `korisnik` WHERE korisnicko_ime = '$korime' AND lozinka = '$lozinka'";
            $rezultat=upit($bp,$upit);
            if($assoc=mysqli_fetch_assoc($rezultat)){
              $_SESSION['kor_ime']=$assoc['korisnicko_ime'];
              $_SESSION['tip_kor_id']=$assoc['tip_korisnika_id'];
              $_SESSION['kor_id']=$assoc['korisnik_id'];
              $_SESSION['ime']=$assoc['ime'];
              $_SESSION['slika']=$assoc['slika'];
              header("location:index.php");
            }
            else {
              $greska="<p>Unjeli ste krivo korisnicko ime ili lozinku!<p>";
            }
          }
        }
        ?>
      <br><br>
        <div class="prijavaWrap">

          <h2 >Obrazac za prijavu</h2>
          <?php
          if(!empty($greska)){
            echo $greska;
          }

          ?>
          <form  id="prijava" method="post" action="prijava.php">
            <label for="korime">Korisničko ime:</label><br>
            <input id="korime" name="korime" type="text" size="40" placeholder="Unesite korisničko ime"><br><br>
            <label for="lozinka">Lozinka:</label><br>
            <input id="lozinka" name="lozinka" type="password" size="40" placeholder="Unesite lozinku"><br>
            <input class="submit" type="submit" name="submit" value="Prijavi se" />
          </form>

        </div>
        
      <br><br>


      </div>
    </section>

<?php
include("podnozje.php");
?>
