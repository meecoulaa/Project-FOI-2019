<?php include("zaglavlje.php"); ?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="prihvatiZahtjev" >
          <h1 class="h1sredstva">Prihvati zahtjeve</h1><br>
          <table>
          <?php
          if (!isset($_SESSION['tip_kor_id']) || $_SESSION['tip_kor_id'] == 2){
            header("location:index.php");
          }
          elseif($_SESSION['tip_kor_id'] == 0 || $_SESSION['tip_kor_id'] == 1){
            $upit4="SELECT * FROM `zahtjev` WHERE prihvacen= 2";
            $rezultat4=upit($bp, $upit4);
            if(!$assoc4=mysqli_fetch_assoc($rezultat4)){
              echo "<p class=\"nemaZahtjeva\" style=\"color:red;\">Nemate aktivnih zahtjeva!<p>";

            }
            else {
              echo "<thead><tr><th>Korisnik_ID</th><th width=\"100\">Iznos</th><th>Prodajna valuta</th><th>Kupovna valuta</th><th>Datum i vrijeme kreiranja</th><th>Prihvaćen</th><th>Akcija</th></tr></thead>";
              echo "<tbody>";
              $upit="SELECT * FROM `zahtjev` WHERE prihvacen= 2";
              $rezultat=upit($bp, $upit);
              while($assoc=mysqli_fetch_assoc($rezultat)){
                $upit2="SELECT * FROM `valuta` WHERE valuta_id={$assoc['prodajem_valuta_id']}";
                $rezultat2=upit($bp, $upit2);
                $assoc2=mysqli_fetch_assoc($rezultat2);
                $upit3="SELECT * FROM `valuta` WHERE valuta_id={$assoc['kupujem_valuta_id']}";
                $rezultat3=upit($bp, $upit3);
                $assoc3=mysqli_fetch_assoc($rezultat3);
                echo "<tr height=\"45\">";
                echo "<td>{$assoc['korisnik_id']}</td>";
                echo "<td>{$assoc['iznos']}</td>";
                echo "<td>{$assoc2['naziv']}</td>";
                echo "<td>{$assoc3['naziv']}</td>";
                $formatHrv=date("d.m.Y | H:i:s",strtotime($assoc['datum_vrijeme_kreiranja']));
                echo "<td>$formatHrv</td>";
                echo "<td style=\"background-color:grey;\">?</td>";
                if($_SESSION['tip_kor_id'] == 1){
                  $aktivno_od=$assoc2['aktivno_od'];
                  $aktivno_do=$assoc2['aktivno_do'];
                  $hrvdatum=date("H:i:s",time());
                  if($hrvdatum > $aktivno_od && $hrvdatum < $aktivno_do){
                    echo
                    "<td>
                      <a href=\"prihvatiZahtjev.php?prihvacen=1&tecaj1={$assoc2['tecaj']}&tecaj2={$assoc3['tecaj']}&zahtjevId={$assoc['zahtjev_id']}&korisnik_id={$assoc['korisnik_id']}&prodajna_valuta_id={$assoc['prodajem_valuta_id']}&kupovna_valuta_id={$assoc['kupujem_valuta_id']}&iznos={$assoc['iznos']}\">Prihvati</a>
                      <a href=\"prihvatiZahtjev.php?prihvacen=0&zahtjevId={$assoc['zahtjev_id']}\">Odbij</a>
                    </td>";
                  }
                  else{
                    echo "<td><p style=\"color:red;\">Valuta nije aktivna<p></td>";
                  }
                }
                if($_SESSION['tip_kor_id'] == 0){
                  echo
                  "<td>
                    <a href=\"prihvatiZahtjev.php?prihvacen=1&tecaj1={$assoc2['tecaj']}&tecaj2={$assoc3['tecaj']}&zahtjevId={$assoc['zahtjev_id']}&korisnik_id={$assoc['korisnik_id']}&prodajna_valuta_id={$assoc['prodajem_valuta_id']}&kupovna_valuta_id={$assoc['kupujem_valuta_id']}&iznos={$assoc['iznos']}\">Prihvati</a>
                    <a href=\"prihvatiZahtjev.php?prihvacen=0&zahtjevId={$assoc['zahtjev_id']}\">Odbij</a>
                  </td>";
                }


              echo "</tr>";
              echo "</tbody>";
            }
          }
          if(isset($_GET['zahtjevId'])){
            $prihvacen=$_GET['prihvacen'];
            $zahtjevId=$_GET['zahtjevId'];
            switch($_GET['prihvacen']){
              case 0:
                $upit5="UPDATE zahtjev SET
                prihvacen='$prihvacen'
                WHERE zahtjev_id='$zahtjevId'";
                upit($bp,$upit5);
                header("location:prihvatiZahtjev.php");
                break;
              case 1:
                $prodajna_valuta_id=$_GET['prodajna_valuta_id'];
                $kupovna_valuta_id=$_GET['kupovna_valuta_id'];
                $iznos=$_GET['iznos'];
                $korisnik_id=$_GET['korisnik_id'];
                $tecaj1=$_GET['tecaj1'];
                $tecaj2=$_GET['tecaj2'];

                $upit6="SELECT * FROM `sredstva` WHERE korisnik_id = $korisnik_id AND valuta_id = $prodajna_valuta_id";
                $rezultat6=upit($bp, $upit6);
                $assoc6=mysqli_fetch_assoc($rezultat6);
                $sredstva_prod_valuta=$assoc6['iznos'];

                $upit7="SELECT * FROM `sredstva` WHERE korisnik_id = $korisnik_id AND valuta_id = $kupovna_valuta_id";
                $rezultat7=upit($bp, $upit7);
                $assoc7=mysqli_fetch_assoc($rezultat7);
                $sredstva_kupovna_valuta=$assoc7['iznos'];

                if($iznos > $sredstva_prod_valuta){
                  echo "<p style=\"color:red;\">Iznos sredstava korisnika nije dovoljan za prihvaćanje zahtjeva!<p>";
                }
                else{
                  $dodajem_sredstva=(($iznos*$tecaj1)/$tecaj2)+$sredstva_kupovna_valuta;
                  $oduzimam_sredstva=$sredstva_prod_valuta-$iznos;

                  $upit8="UPDATE sredstva SET
                  iznos='$oduzimam_sredstva'
                  WHERE korisnik_id='$korisnik_id' AND valuta_id='$prodajna_valuta_id'";
                  upit($bp,$upit8);

                  $upit9="UPDATE sredstva SET
                  iznos='$dodajem_sredstva'
                  WHERE korisnik_id='$korisnik_id' AND valuta_id='$kupovna_valuta_id'";
                  upit($bp,$upit9);

                  $upit10="UPDATE zahtjev SET
                  prihvacen='$prihvacen'
                  WHERE zahtjev_id='$zahtjevId'";
                  upit($bp,$upit10);
                  header("location:prihvatiZahtjev.php");
                  break;
                }
            }
          }
        }
          ?>
          </table>
        </div>
      </div>
    </section>

<?php include("podnozje.php"); ?>
