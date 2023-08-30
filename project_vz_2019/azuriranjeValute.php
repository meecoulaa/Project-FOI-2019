<?php
include("zaglavlje.php");

?>
<?php
$val_id=$_GET['val_id'];
$mod_id=$_GET['mod_id'];
$moderator=$_GET['moderator'];
$naziv=$_GET['naziv'];
$tecaj=$_GET['tecaj'];
$slika=$_GET['slika'];
$zvuk=$_GET['zvuk'];
$aktiv_od=$_GET['aktiv_od'];
$aktiv_do=$_GET['aktiv_do'];
$datum=$_GET['datum'];
$datumDanas = date("Y-m-d", time());
$hrvdatum=date("d.m.Y.",strtotime($datum));

$greska="";

?>
    <section class="sadrzaj">
      <div class="sadrzajWrap">
        <div class="azurVal">
          <h1 class="h1sredstva">Ažuriranje valute</h1><br>

          <?php
            echo "<p>Valuta ID: <b>$val_id</b></p>";
            echo "<p>Ime valute: <b>$naziv</b></p>";
            echo "<p>Moderator: <b>$moderator</b></p><br>";
            ?>
            <form method="POST" action="<?php echo "azuriranjeValute.php?val_id=$val_id&mod_id=$mod_id&moderator=$moderator&naziv=$naziv&tecaj=$tecaj&slika=$slika&zvuk=$zvuk&aktiv_od=$aktiv_od&aktiv_do=$aktiv_do&datum=$datum"; ?> ">

              <?php
                $upit="SELECT * FROM `korisnik` WHERE tip_korisnika_id = 1";
                $rezultat=upit($bp,$upit);
                if (!isset($_SESSION['tip_kor_id']) || $_SESSION['tip_kor_id'] == 2){
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
                  echo "<input type=\"number\" step=\"any\" name=\"tecajVal\" size=\"30\" value=\"$tecaj\" placeholder=\"Unesite tecaj valute\"><br><br>";
                  echo "<label for=\"imeValute\"><b>Naziv valute:</b></label>";
                  echo "<input type=\"text\" name=\"imeValute\" size=\"30\" value=\"$naziv\" placeholder=\"Unesite ime valute\"><br><br>";
                  echo "<label for=\"slikaUrl\"><b>Slika(URL):</b></label>";
                  echo "<input type=\"url\" name=\"slikaUrl\" size=\"30\" value=\"$slika\" placeholder=\"Unesite URL slike\"><br><br>";
                  echo "<label for=\"zvukUrl\"><b>Zvuk(URL):</b></label>";
                  echo "<input type=\"url\" name=\"zvukUrl\" size=\"30\" value=\"$zvuk\" placeholder=\"Unesite URL zvuka\"><br><br>";
                  $aktiv_od_sati=date("H",strtotime($aktiv_od));
                  $aktiv_od_minute=date("i",strtotime($aktiv_od));
                  $aktiv_od_sekunde=date("s", strtotime($aktiv_od));
                  $aktiv_do_sati=date("H",strtotime($aktiv_do));
                  $aktiv_do_minute=date("i",strtotime($aktiv_do));
                  $aktiv_do_sekunde=date("s", strtotime($aktiv_do));
                  echo "<label for=\"sekundeOd\"><b>Aktivno od:</b></label>";
                  echo "<input type=\"number\" name=\"sekundeOd\" min=\"0\" max=\"59\" size=\"10\" value=\"$aktiv_od_sekunde\" placeholder=\"Sekunde\">";
                  echo "<input type=\"number\" name=\"minuteOd\" min=\"0\" max=\"59\" size=\"10\" value=\"$aktiv_od_minute\" placeholder=\"Minute\">";
                  echo "<input type=\"number\" name=\"satiOd\" min=\"0\" max=\"23\" size=\"10\" value=\"$aktiv_od_sati\" placeholder=\"Sati\"><br><br>";

                  echo "<label for=\"sekundeDo\"><b>Aktivno do:</b></label>";
                  echo "<input type=\"number\" name=\"sekundeDo\" min=\"0\" max=\"59\" size=\"10\" value=\"$aktiv_do_sekunde\" placeholder=\"Sekunde\">";
                  echo "<input type=\"number\" name=\"minuteDo\" min=\"0\" max=\"59\" size=\"10\" value=\"$aktiv_do_minute\" placeholder=\"Minute\">";
                  echo "<input type=\"number\" name=\"satiDo\" min=\"0\" max=\"23\" size=\"10\" value=\"$aktiv_do_sati\" placeholder=\"Sati\"><br><br><br>";


                  echo "<input class=\"submit\" type=\"submit\" name=\"submit2\" value=\"Ažuriraj\" /><br><br>";
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
                    if(empty($imePost)){
                      $greska = "<p style=\"color:red;\">Niste unjeli ime valute! </p>";
                    }
                    if(empty($tecajPost)){
                      $greska = "<p style=\"color:red;\">Niste unjeli tečaj valute! </p>";
                    }
                    if(empty($slikaPost)){
                      $greska = "<p style=\"color:red;\">Niste odabrali URL slike! </p>";
                    }
                    if($vrijemeDoHrv <= $vrijemeOdHrv){
                      $greska = "<p style=\"color:red;\">Krajnje vrijeme ne smije biti jednako ili manje od početnog!  </p>";
                    }

                    if(empty($greska)){
                      $upit3="UPDATE valuta SET
                      moderator_id='$modPostId',
                      naziv='$imePost',
                      tecaj='$tecajPost',
                      slika='$slikaPost',
                      zvuk='$zvukPost',
                      aktivno_od='$vrijemeOdHrv',
                      aktivno_do='$vrijemeDoHrv',
                      datum_azuriranja='$datumDanas'
                      WHERE valuta_id='$val_id'";
                      upit($bp,$upit3);
                      echo "<p style=\"color:green;\">Uspješno ste ažurirali valutu!</p>";

                    }
                  }
                }
                elseif($_SESSION['kor_id']==$mod_id){
                  echo "<label for=\"tecajVal\"><b>Tečaj:</b></label>";
                  echo "<input type=\"text\" name=\"tecajVal\" size=\"30\" value=\"$tecaj\"><br><br><br><br>";
                  echo "<input class=\"submit\" type=\"submit\" name=\"submit3\" value=\"Ažuriraj\" /><br><br>";
                  if(isset($_POST['submit3'])){
                    if(empty($_POST['tecajVal'])){
                      $greska="<p style=\"color:red;\">Polje tečaj se mora unjeti!</p>";
                    }
                    if($datum == $datumDanas){
                        $greska="<p style=\"color:red;\">Jednom dnevno je moguće ažurirati valutu!</p>";
                    }
                    if(empty($greska)){
                      $noviTecaj=$_POST['tecajVal'];
                      $upit="UPDATE valuta SET tecaj='$noviTecaj', datum_azuriranja='$datumDanas'  WHERE valuta_id='$val_id'";
                      upit($bp,$upit);
                      echo "<p style=\"color:green;\">Uspješno ste ažurirali valutu!</p>";
                    }
                  }
                }
                if(!empty($greska)){
                  echo $greska;
                }


              ?>

            </form>
        </div>

      </div>
    </section>

<?php include("podnozje.php"); ?>
