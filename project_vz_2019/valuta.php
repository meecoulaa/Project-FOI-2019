<?php
include("zaglavlje.php");
?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">
      <?php
      $val_id=$_GET['val_id'];
      $mod_id=$_GET['mod_id'];
      $naziv=$_GET['naziv'];
      $tecaj=$_GET['tecaj'];
      $slika=$_GET['slika'];
      $zvuk=$_GET['zvuk'];
      $aktiv_od=$_GET['aktiv_od'];
      $aktiv_do=$_GET['aktiv_do'];
      $datum=$_GET['datum'];
      $hrvdatum=date("d.m.Y.",strtotime($datum));


      $upit="SELECT * FROM `korisnik` WHERE korisnik_id = '$mod_id'";
      $rezultat=upit($bp,$upit);
      $assoc=mysqli_fetch_assoc($rezultat);
      $moderator=$assoc['korisnicko_ime'];
      ?>
        <div class="valuta">
          <?php
            echo "<h1>Valuta: $naziv</h1>";
            echo "<img src=\"$slika\" height=\"150\" width=\"250\"><br>";
            echo "<audio controls><source src=\"$zvuk\"></audio>";
            echo "<p>Moderator: <b>$moderator</b></p>";
            echo "<p>Tečaj: <b>$tecaj</b> HRK<p>";
            echo "<p>Aktivno od: <b>$aktiv_od</b></p>";
            echo "<p>Aktivno do: <b>$aktiv_do</b></p>";
            echo "<p class=\"azur\">Zadnje ažuriranje: <b>$hrvdatum</b></p>";
            if(isset($_SESSION['kor_id'])){
              if($mod_id == $_SESSION['kor_id']){
                echo "<a href=\"azuriranjeValute.php?val_id=$val_id&mod_id=$mod_id&moderator=$moderator&naziv=$naziv&tecaj=$tecaj&slika=$slika&zvuk=$zvuk&aktiv_od=$aktiv_od&aktiv_do=$aktiv_do&datum=$datum\">Ažuriranje valute</a>";
              }
              if($_SESSION['tip_kor_id'] == 0){
                echo "<a href=\"azuriranjeValute.php?val_id=$val_id&mod_id=$mod_id&moderator=$moderator&naziv=$naziv&tecaj=$tecaj&slika=$slika&zvuk=$zvuk&aktiv_od=$aktiv_od&aktiv_do=$aktiv_do&datum=$datum\">Ažuriranje valute</a>";
              }
            }
            

          ?>
        </div>

      </div>
    </section>

<?php include("podnozje.php"); ?>
