<?php
include("zaglavlje.php");

?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="valute">
          <?php
          $upit="SELECT * FROM valuta";
          $rezultat=upit($bp,$upit);

          while($assoc=mysqli_fetch_assoc($rezultat)){
            $val_id=$assoc['valuta_id'];
            $mod_id=$assoc['moderator_id'];
            $naziv=$assoc['naziv'];
            $tecaj=$assoc['tecaj'];
            $slika=$assoc['slika'];
            $zvuk=$assoc['zvuk'];
            $aktiv_od=$assoc['aktivno_od'];
            $aktiv_do=$assoc['aktivno_do'];
            $datum=$assoc['datum_azuriranja'];

            echo "<a href=\"valuta.php?val_id=$val_id&mod_id=$mod_id&naziv=$naziv&tecaj=$tecaj&slika=$slika&zvuk=$zvuk&aktiv_od=$aktiv_od&aktiv_do=$aktiv_do&datum=$datum\"><img src=\"$slika\" height=\"150\" width=\"250\" ></a>";

          }

          ?>
        </div>
        <br><br><br>

        <div class="dodajWrap">
        <?php
        if(isset($_SESSION['tip_kor_id'])){
          if($_SESSION['tip_kor_id'] == 0){
            echo "<a class=\"dodaj\" href=\"dodajValutu.php\">Dodaj valutu<p>+</p></a>";
          }
        }

        ?>
        </div>
      </div>
    </section>

<?php include("podnozje.php"); ?>
