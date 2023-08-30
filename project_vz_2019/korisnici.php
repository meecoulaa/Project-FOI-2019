<?php include("zaglavlje.php"); ?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="korisniciWrap">
          <br><h1 class="h1sredstva">Korisnici</h1><br><br>
          <a style="float:right;" href="registrirajKorisnika.php">Dodaj novog korisnika</a><br><br><br>
          <table>
            <?php
            if(!isset($_SESSION['kor_id']) || $_SESSION['tip_kor_id'] != 0){
              header("location:index.php");
            }
            else{
              if(isset($_GET['stranica'])){
                $stranica=$_GET['stranica'];
              }
              else {
                $stranica=1;
              }

              $rezultat_po_stranici=10;
              $pocetak_od=($stranica-1)*$rezultat_po_stranici;

              $upit="SELECT * FROM korisnik LIMIT $pocetak_od, $rezultat_po_stranici";
              $rezultat=upit($bp, $upit);
              echo "<thead height=\"50\"><tr><th>Korisničko ime</th><th width=\"100\">Lozinka</th><th>Ime</th><th>Prezime</th><th>Email</th><th>Slika</th><th width=\"100\"></th></tr></thead>";
              echo "<tbody>";
              while($assoc=mysqli_fetch_assoc($rezultat)){
                echo "<tr height=\"100\">";
                echo "<td>{$assoc['korisnicko_ime']}</td>";
                echo "<td>{$assoc['lozinka']}</td>";
                echo "<td>{$assoc['ime']}</td>";
                echo "<td>{$assoc['prezime']}</td>";
                echo "<td>{$assoc['email']}</td>";
                echo "<td><img height=\"100\" width=\"80\" src=\"{$assoc['slika']}\"></td>";
                echo "<td><a href=\"azurirajKorisnika.php?korisnik={$assoc['korisnik_id']}\">Ažuriraj</a></td>";
                echo "</tr>";

              }

              echo "</tbody>";
            }
              ?>

          </table><br><br>


          <?php
          $upit2="SELECT * FROM korisnik";
          $rezultat2=upit($bp, $upit2);
          $ukupno_redova=mysqli_num_rows($rezultat2);
          $broj_stranica=ceil($ukupno_redova/$rezultat_po_stranici);

          if($stranica > 1){
            $prethodna = $stranica-1;
            echo "<a href=\"korisnici.php?stranica=$prethodna\">Prethodna</a>";
          }

          for($x=1; $x <= $broj_stranica; $x++){
            echo "<a class=\"stranica$x\" href=\"korisnici.php?stranica=$x\">$x</a>";
          }

          if($stranica < $broj_stranica){
            $sljedeca = $stranica+1;
            echo "<a href=\"korisnici.php?stranica=$sljedeca\">Sljedeća</a>";
          }

          echo "<style>
          .stranica$stranica{
            background-color: rgb(254, 130, 121, 0.4);
          }
          </style>";
          ?>

        </div>

      </div>
    </section>

<?php include("podnozje.php"); ?>
