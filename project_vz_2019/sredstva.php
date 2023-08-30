<?php include("zaglavlje.php"); ?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="sredstvaWrap">
          <br><h1 class="h1sredstva">Dodaj nova sredstva</h1>
          <?php
            $upit4="SELECT korisnik_id, valuta_id FROM `sredstva` WHERE korisnik_id = {$_SESSION['kor_id']}";
            $rezultat4=upit($bp,$upit4);
            $array = array();
            while($assoc4=mysqli_fetch_assoc($rezultat4)){
              $array[] = $assoc4['valuta_id'];
            }
            $upit5="SELECT * FROM `valuta`";
            $rezultat5=upit($bp,$upit5);
            $array2 = array();
            while($assoc5=mysqli_fetch_assoc($rezultat5)){
              $array2[] = $assoc5['valuta_id'];
            }
            $array3 = array_diff($array2,$array);
          ?>
          <form class="dodajSredstvaform" action="sredstva.php" method="post">
            <label for="odabirValute"><b>Odaberi valutu:</b></label><br>
            <select class="" name="odabirValute">
              <?php
              foreach ($array3 as $value){
                $upit6="SELECT * FROM `valuta` WHERE valuta_id = $value";
                $rezultat6=upit($bp,$upit6);
                $assoc6=mysqli_fetch_assoc($rezultat6);
                echo "<option value=\"{$assoc6['naziv']}\">{$assoc6['naziv']}</option>";
              }
              ?>
            </select><br><br>
            <label for="odabirIznosa"><b>Iznos:</b></label><br>
            <input class="numberIznos" step="any" type="number" min="1" name="odabirIznosa" placeholder="Unesite iznos novca" ><br><br>
            <input class="submit" type="submit" name="submit" value="Dodaj iznos">
            <?php
              if(isset($_POST['submit'])){
                $iznos=$_POST['odabirIznosa'];
                $naziv=$_POST['odabirValute'];
                $kor_id=$_SESSION['kor_id'];

                $upit7="SELECT * FROM `valuta` WHERE naziv = '$naziv'";
                $rezultat7=upit($bp, $upit7);
                $assoc7=mysqli_fetch_assoc($rezultat7);
                $valuta_id=$assoc7['valuta_id'];
                $upit8="INSERT INTO sredstva (korisnik_id,valuta_id,iznos)
                VALUES ('$kor_id','$valuta_id','$iznos')";
                upit($bp, $upit8);
                header("location:sredstva.php");
              }
            ?>
          </form><br><br>
          <h1 class="h1sredstva">Raspoloživa sredstva</h1>
          <table >
              <?php
              if(!isset($_SESSION['kor_id'])){
                header("location:index.php");
              }
              elseif(isset($_SESSION['kor_id'])){
                $upit="SELECT * FROM `sredstva` WHERE korisnik_id= {$_SESSION['kor_id']}";
                $rezultat=upit($bp, $upit);

                $upit3="SELECT * FROM `sredstva` WHERE korisnik_id= {$_SESSION['kor_id']}";
                $rezultat3=upit($bp, $upit3);
                if(!$assoc3=mysqli_fetch_assoc($rezultat3)){
                  echo "<p style=\"color:red;\">Nemate raspoloživih sredstava!<p>";
                }
                else{
                  echo "<thead><tr><th>Naziv</th><th width=\"100\">Iznos</th><th>Ažuriraj sredstva</th></tr></thead>";
                  echo "<tbody>";
                  while($assoc=mysqli_fetch_assoc($rezultat)){
                    $upit2="SELECT * FROM `valuta` WHERE valuta_id={$assoc['valuta_id']}";
                    $rezultat2=upit($bp, $upit2);
                    $assoc2=mysqli_fetch_assoc($rezultat2);
                    echo "<tr height=\"45\">";
                    echo "<td>{$assoc2['naziv']}</td>";
                    echo "<td>{$assoc['iznos']}</td>";
                    echo "<td><a href=\"azurirajSredstva.php?sredstva_id={$assoc['sredstva_id']}&naziv={$assoc2['naziv']}&iznos={$assoc['iznos']}\">Ažuriraj</a></td>";
                    echo "</tr>";
                  }
                  echo "</tbody>";
                }
              }

               ?>
          </table>


        </div>



      </div>
    </section>

<?php include("podnozje.php"); ?>
