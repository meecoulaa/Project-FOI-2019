<?php include("zaglavlje.php"); ?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="filtrirajZahtjeve">
          <h1 class="h1sredstva">Filtriranje zahtjeva</h1><br><br>
          <form action="filtrirajZahtjeve.php" method="post">
            <?php
            $upit="SELECT * FROM `korisnik` WHERE tip_korisnika_id = 1";
            $rezultat=upit($bp,$upit);
            echo "<label for=\"moderator\"><b>Moderator: </b></label>";
            echo "<select class=\"listaMod\" name=\"odabirMod\">";
            while($assoc=mysqli_fetch_assoc($rezultat)){
              echo "<option value=\"{$assoc['korisnik_id']}\">{$assoc['korisnicko_ime']}</option>";
            }
            echo "</select><br><br>";
            echo "<label for=\"sekundeOd\"><b>Vrijeme od:</b></label>";
            echo "<input required type=\"number\" name=\"sekundeOd\" min=\"0\" max=\"59\" size=\"10\" value=\"00\" placeholder=\"Sekunde\">";
            echo "<input required type=\"number\" name=\"minuteOd\" min=\"0\" max=\"59\" size=\"10\" value=\"00\" placeholder=\"Minute\">&nbsp";
            echo "<input required type=\"number\" name=\"satiOd\" min=\"0\" max=\"23\" size=\"10\" value=\"00\" placeholder=\"Sati\">&nbsp<br><br>";

            echo "<label for=\"godinaOd\"><b>Datum od:</b></label>";
            echo "<input required type=\"number\" name=\"godinaOd\" min=\"1990\" max=\"2150\" size=\"10\" value=\"1990\" placeholder=\"Godina\">";
            echo "<input required type=\"number\" name=\"mjesecOd\" min=\"0\" max=\"12\" size=\"10\" value=\"01\" placeholder=\"Mjesec\">";
            echo "<input required type=\"number\" name=\"danOd\" min=\"0\" max=\"31\" size=\"10\" value=\"01\" placeholder=\"Dan\"><br><br><br><br>";

            echo "<label for=\"sekundeDo\"><b>Vrijeme do:</b></label>";
            echo "<input required type=\"number\" name=\"sekundeDo\" min=\"0\" max=\"59\" size=\"10\" value=\"00\" placeholder=\"Sekunde\">";
            echo "<input required type=\"number\" name=\"minuteDo\" min=\"0\" max=\"59\" size=\"10\" value=\"00\" placeholder=\"Minute\">&nbsp";
            echo "<input required type=\"number\" name=\"satiDo\" min=\"0\" max=\"23\" size=\"10\" value=\"00\" placeholder=\"Sati\">&nbsp<br><br>";

            echo "<label for=\"godinaDo\"><b>Datum do:</b></label>";
            echo "<input required type=\"number\" name=\"godinaDo\" min=\"1990\" max=\"2150\" size=\"10\" value=\"2150\" placeholder=\"Godina\">";
            echo "<input required type=\"number\" name=\"mjesecDo\" min=\"0\" max=\"12\" size=\"10\" value=\"01\" placeholder=\"Mjesec\">";
            echo "<input required type=\"number\" name=\"danDo\" min=\"0\" max=\"31\" size=\"10\" value=\"01\" placeholder=\"Dan\"><br><br><br>";



            echo "<input class=\"submit\" type=\"submit\" name=\"submit\" value=\"Filtriraj\" /><br><br>";
            ?>
          </form>
          <br><br><h1 class="h1sredstva">Ukupan zbroj iznosa prihvaćenih zahtjeva</h1><br>
          <?php
            if($_SESSION['tip_kor_id'] == 0){
              if(!isset($_POST['submit'])){

                echo "<table>";
                echo "<thead><tr><th>Valuta</th><th width=\"230\">Ukupno</th></tr></thead>";
                echo "<tbody>";

                $upit2="SELECT * FROM valuta";
                $rezultat2=upit($bp, $upit2);
                while($assoc2=mysqli_fetch_assoc($rezultat2)){
                  echo "<tr height=\"45\">";
                  $upit3="SELECT SUM(iznos) FROM zahtjev WHERE prihvacen=1 AND prodajem_valuta_id ={$assoc2['valuta_id']}";
                  $rezultat3=upit($bp, $upit3);
                  while($assoc3=mysqli_fetch_array($rezultat3)){
                    echo "<td>{$assoc2['naziv']}</td>";
                    echo "<td>{$assoc3[0]}</td>";
                    echo "</tr>";
                  }
                }
                echo "</tbody>";
                echo "</table>";
              }
              else{
                $greska="";
                $moderator=$_POST['odabirMod'];
                $format1=$_POST['godinaOd']."-" .$_POST['mjesecOd']."-" .$_POST['danOd']." ".$_POST['satiOd']. ":" . $_POST['minuteOd']. ":" .$_POST['sekundeOd'];
                $format2=$_POST['godinaDo']."-" .$_POST['mjesecDo']."-" .$_POST['danDo']." ".$_POST['satiDo']. ":" . $_POST['minuteDo']. ":" .$_POST['sekundeDo'];
                $vrijemeOdHrv=date("Y-m-d H:i:s", strtotime($format1));
                $vrijemeDoHrv=date("Y-m-d H:i:s", strtotime($format2));
                if($vrijemeDoHrv <= $vrijemeOdHrv){
                  $greska = "<p style=\"color:red;\">Krajnje vrijeme ne smije biti jednako ili manje od početnog!  </p>";
                }
                if(!empty($greska)){
                  echo $greska;
                }
                else {
                  echo "<p><b>Moderator ID: $moderator <br> Vremenski period od: $vrijemeOdHrv <br> Vremenski period do: $vrijemeDoHrv </b></p>";
                  echo "<table>";
                  echo "<thead><tr><th>Valuta</th><th width=\"230\">Ukupno</th></tr></thead>";
                  echo "<tbody>";

                  $upit4="SELECT * FROM valuta WHERE moderator_id=$moderator";
                  $rezultat4=upit($bp, $upit4);
                  while($assoc4=mysqli_fetch_assoc($rezultat4)){
                    echo "<tr height=\"45\">";
                    $upit5="SELECT SUM(iznos) FROM zahtjev WHERE prihvacen=1 AND prodajem_valuta_id ={$assoc4['valuta_id']} AND datum_vrijeme_kreiranja BETWEEN '$vrijemeOdHrv' AND '$vrijemeDoHrv'";
                    $rezultat5=upit($bp, $upit5);
                    while($assoc5=mysqli_fetch_array($rezultat5)){
                      echo "<td>{$assoc4['naziv']}</td>";
                      echo "<td>{$assoc5[0]}</td>";
                      echo "</tr>";
                    }
                  }
                  echo "</tbody>";
                  echo "</table>";
                }
              }
            }
            else {
              header("location:index.php");
            }
          ?>

        </div>




      </div>
    </section>

<?php include("podnozje.php"); ?>
