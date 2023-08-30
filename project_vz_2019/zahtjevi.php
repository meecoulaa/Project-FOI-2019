<?php include("zaglavlje.php"); ?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="zahtjeviWrap"><br><br>
          <h1 class="h1sredstva"> Lista zahtjeva </h1><br>
          <?php


          ?>
          <table>
            <?php
            if(!isset($_SESSION['kor_id'])){
              header("location:index.php");
            }
            elseif(isset($_SESSION['kor_id'])){
              $upit4="SELECT * FROM `zahtjev` WHERE korisnik_id= {$_SESSION['kor_id']}";
              $rezultat4=upit($bp, $upit4);
              if(!$assoc4=mysqli_fetch_assoc($rezultat4)){
                echo "<p class=\"nemaZahtjeva\" style=\"color:red;\">Nemate aktivnih zahtjeva!<p>";

              }
              else {
                echo "<thead><tr height=\"30\"><th width=\"100\">Iznos</th><th>Prodajna valuta</th><th>Kupovna valuta</th><th>Datum i vrijeme kreiranja</th><th>Prihvaćen</th></tr></thead>";
                echo "<tbody>";
                $upit="SELECT * FROM `zahtjev` WHERE korisnik_id= {$_SESSION['kor_id']}";
                $rezultat=upit($bp, $upit);
                while($assoc=mysqli_fetch_assoc($rezultat)){
                  $upit2="SELECT * FROM `valuta` WHERE valuta_id={$assoc['prodajem_valuta_id']}";
                  $rezultat2=upit($bp, $upit2);
                  $assoc2=mysqli_fetch_assoc($rezultat2);
                  $upit3="SELECT * FROM `valuta` WHERE valuta_id={$assoc['kupujem_valuta_id']}";
                  $rezultat3=upit($bp, $upit3);
                  $assoc3=mysqli_fetch_assoc($rezultat3);
                  echo "<tr height=\"45\">";
                  echo "<td>{$assoc['iznos']}</td>";
                  echo "<td>{$assoc2['naziv']}</td>";
                  echo "<td>{$assoc3['naziv']}</td>";
                  $formatHrv=date("d.m.Y | H:i:s",strtotime($assoc['datum_vrijeme_kreiranja']));
                  echo "<td>$formatHrv</td>";
                  switch ($assoc['prihvacen']){
                    case 1:
                      echo "<td style=\"background-color:green;\">DA</td>";
                      break;
                    case 0:
                      echo "<td style=\"background-color:red;\">NE</td>";
                      break;
                    case 2:
                      echo "<td style=\"background-color:grey;\">?</td>";
                      break;
                  }
                  echo "</tr>";
                }
                echo "</tbody>";
              }
            }
              ?>

          </table><br><br><br>
          <a class="noviZahtjev" href="noviZahtjev.php">Novi zahtjev</a>
        </div><br>




      </div>
    </section>

<?php include("podnozje.php"); ?>
