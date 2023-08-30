<?php
include("zaglavlje.php");

?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="noviZahtjevWrap">
          <h1 class="h1sredstva">Dodaj novi zahtjev</h1>
          <form class="dodajSredstvaform" action="noviZahtjev.php" method="post">
            <label for="iznosNum"><b>Iznos:</b></label><br>
            <input class="numberIznos" step="any" type="number" name="iznosNum" min="1" placeholder="Unesite iznos"><br><br>
            <label for="odabirProdajna"><b>Prodajna valuta:</b></label><br>
            <select name="odabirProdajna">

              <?php

              if(!isset($_SESSION['kor_id'])){
                header("location:index.php");
              }
              elseif(isset($_SESSION['kor_id'])){
                $upit="SELECT * FROM `sredstva` WHERE korisnik_id= {$_SESSION['kor_id']}";
                $rezultat=upit($bp, $upit);

                while($assoc=mysqli_fetch_assoc($rezultat)){
                  $upit2="SELECT * FROM `valuta` WHERE valuta_id={$assoc['valuta_id']}";
                  $rezultat2=upit($bp, $upit2);
                  $assoc2=mysqli_fetch_assoc($rezultat2);
                  echo "<option value=\"{$assoc['valuta_id']}\">{$assoc2['naziv']}</option>";
                }
              }
              ?>

            </select><br><br>
            <label for="odabirKupovna"><b>Kupovna valuta:</b></label><br>
            <select name="odabirKupovna">
              <?php
              $upit3="SELECT * FROM `valuta` ";
              $rezultat3=upit($bp, $upit3);
              while($assoc3=mysqli_fetch_assoc($rezultat3)){
                echo "<option value=\"{$assoc3['valuta_id']}\">{$assoc3['naziv']}</option>";
              }
              ?>
            </select><br><br><br>
            <input class="submit" type="submit" name="submit" value="Novi zahtjev">

          </form><br>
          <?php
          $greska ="";
          if(isset($_POST['submit'])){
            $iznos= $_POST['iznosNum'];
            $kupovnaVal=$_POST['odabirKupovna'];
            $vrijemeHrv= date("Y-m-d H:i:s", time());
            $status= 2;
            $kor_id=$_SESSION['kor_id'];
            if(isset($_POST['odabirProdajna'])){
              $prodajnaVal=$_POST['odabirProdajna'];
              if(empty($iznos)){
                $greska = "<p style=\"color:red;\"><b>Niste unjeli iznos! </b></p>";
              }
              else{
                  $upit4="SELECT * FROM `sredstva` WHERE korisnik_id =$kor_id AND valuta_id=$prodajnaVal";
                  $rezultat4=upit($bp, $upit4);
                  $assoc4=mysqli_fetch_assoc($rezultat4);
                  $stanjeSredstva=$assoc4['iznos'];
                  if($iznos > $stanjeSredstva){
                    $greska = "<p style=\"color:red;\"><b>Nemate dovoljno raspoloživih sredstava!</b> </p>";
                  }
                  if($prodajnaVal == $kupovnaVal){
                    $greska = "<p style=\"color:red;\"><b>Prodajna i kupovna valuta se moraju razlikovati!</b> </p>";
                  }
              }
            }
            elseif(!isset($_POST['prodajnaVal'])){
              $greska = "<p style=\"color:red;\"><b>Nemate sredstva u ni jednoj valuti za novi zahtjev! </b></p>";
            }
            if(empty($greska)){
              $upit5="INSERT INTO zahtjev (korisnik_id,iznos,prodajem_valuta_id,kupujem_valuta_id, datum_vrijeme_kreiranja,prihvacen)
              VALUES ('$kor_id','$iznos','$prodajnaVal','$kupovnaVal','$vrijemeHrv','$status')";
              upit($bp,$upit5);
              echo "<p style=\"color:green;\"><b>Generirali ste novi zahtjev! </b></p>";
            }
            if(!empty($greska)){
              echo $greska;
            }
          }


          ?>
        </div>

      </div>
    </section>

<?php include("podnozje.php"); ?>
