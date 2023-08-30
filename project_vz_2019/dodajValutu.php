<?php
include("zaglavlje.php");
?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="dodajValutu">
          <h1 class="h1sredstva">Dodavanje nove valute</h1><br>
          <form action="dodajValutu.php" method="post">
            <?php
            $upit="SELECT * FROM `korisnik` WHERE tip_korisnika_id = 1";
            $rezultat=upit($bp,$upit);
            if(!isset($_SESSION['tip_kor_id'])){
              header("location:index.php");
            }
            elseif($_SESSION['tip_kor_id']==0){
              echo "<label for=\"moderator\"><b>Moderator: </b></label>";
              echo "<select class=\"listaMod\" name=\"odabirMod\">";
              while($assoc=mysqli_fetch_assoc($rezultat)){
                echo "<option value=\"{$assoc['korisnik_id']}\">{$assoc['korisnicko_ime']}</option>";
              }
              echo "</select><br><br>";
              echo "<label class=\"marginTecaj\" for=\"tecajVal\"><b>Tečaj:</b></label>";
              echo "<input type=\"number\" step=\"any\" name=\"tecajVal\" size=\"30\" value=\"\" placeholder=\"Unesite tecaj valute\"><br><br>";
              echo "<label for=\"imeValute\"><b>Naziv valute:</b></label>";
              echo "<input type=\"text\" name=\"imeValute\" size=\"30\" value=\"\" placeholder=\"Unesite ime valute\"><br><br>";
              echo "<label for=\"slikaUrl\"><b>Slika(URL):</b></label>";
              echo "<input type=\"url\" name=\"slikaUrl\" size=\"30\" value=\"\" placeholder=\"Unesite URL slike\"><br><br>";
              echo "<label for=\"zvukUrl\"><b>Zvuk(URL):</b></label>";
              echo "<input type=\"url\" name=\"zvukUrl\" size=\"30\" value=\"\" placeholder=\"Unesite URL zvuka\"><br><br>";

              echo "<label for=\"sekundeOd\"><b>Aktivno od:</b></label>";
              echo "<input type=\"number\" name=\"sekundeOd\" min=\"0\" max=\"59\" size=\"10\" value=\"00\" placeholder=\"Sekunde\">";
              echo "<input type=\"number\" name=\"minuteOd\" min=\"0\" max=\"59\" size=\"10\" value=\"00\" placeholder=\"Minute\">&nbsp";
              echo "<input type=\"number\" name=\"satiOd\" min=\"0\" max=\"23\" size=\"10\" value=\"00\" placeholder=\"Sati\">&nbsp<br><br>";

              echo "<label for=\"sekundeDo\"><b>Aktivno do:</b></label>";
              echo "<input type=\"number\" name=\"sekundeDo\" min=\"0\" max=\"59\" size=\"10\" value=\"00\" placeholder=\"Sekunde\">";
              echo "<input type=\"number\" name=\"minuteDo\" min=\"0\" max=\"59\" size=\"10\" value=\"00\" placeholder=\"Minute\">&nbsp";
              echo "<input type=\"number\" name=\"satiDo\" min=\"0\" max=\"23\" size=\"10\" value=\"00\" placeholder=\"Sati\">&nbsp<br><br><br>";
              echo "<input class=\"submit\" type=\"submit\" name=\"submit2\" value=\"Dodaj valutu\" /><br><br>";

              if(isset($_POST['submit2'])){
                $modPostId=$_POST['odabirMod'];
                $imePost=$_POST['imeValute'];
                $tecajPost=$_POST['tecajVal'];
                $slikaPost=$_POST['slikaUrl'];
                $zvukPost=$_POST['zvukUrl'];
                $format1=$_POST['satiOd']. ":" . $_POST['minuteOd']. ":" .$_POST['sekundeOd'];
                $format2=$_POST['satiDo']. ":" . $_POST['minuteDo']. ":" .$_POST['sekundeDo'];
                $vrijemeOdHrv=date("H:i:s", strtotime($format1));
                $vrijemeDoHrv=date("H:i:s", strtotime($format2));
                $datumDanas = date("Y-m-d", time());
                if(empty($imePost)){
                  $greska = "<p style=\"color:red;\"><b>Niste unjeli ime valute! </b></p>";
                }
                if(empty($tecajPost)){
                  $greska = "<p style=\"color:red;\"><b>Niste unjeli tečaj valute! </b></p>";
                }
                if(empty($slikaPost)){
                  $greska = "<p style=\"color:red;\"><b>Niste odabrali URL slike! </b></p>";
                }
                if($vrijemeDoHrv <= $vrijemeOdHrv){
                  $greska = "<p style=\"color:red;\"><b>Krajnje vrijeme ne smije biti jednako ili manje od početnog!  </b></p>";
                }
                if(empty($greska)){
                  $upit3="INSERT INTO valuta (moderator_id,naziv,tecaj,slika,zvuk,aktivno_od,aktivno_do,datum_azuriranja)
                  VALUES ('$modPostId','$imePost','$tecajPost','$slikaPost','$zvukPost','$vrijemeOdHrv','$vrijemeDoHrv','$datumDanas')";
                  upit($bp,$upit3);
                  echo "<p style=\"color:green;\"><b>Uspješno ste dodali valutu!</b></p>";
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
