<?php
include("zaglavlje.php");
$bp=spoji();
?>

    <section class="sadrzaj">
      <div class="sadrzajWrap">

        <div class="azurirajSredstva">
          <?php
          if(!isset($_SESSION['kor_id'])){
            header("location:index.php");
          }
          echo "<p style=\"font-size:22px;\"><b>Valuta: {$_GET['naziv']}</b></p><br>";
          echo "<form action=\"azurirajSredstva.php?sredstva_id={$_GET['sredstva_id']}&naziv={$_GET['naziv']}&iznos={$_GET['iznos']}\" method=\"post\">"
          ?>
            <label for="odabirIznosa2"><b>Iznos:</b></label><br>
            <input class="numberIznos" type="number" min="1" name="odabirIznosa2" value="<?php echo $_GET['iznos'];?>" placeholder="Unesite novi iznos" ><br><br>
            <br><input class="submit" type="submit" name="submit" value="Ažuriraj iznos">
          </form><br>
          <?php
          if(isset($_POST['submit'])){
            $sredstva_id=$_GET['sredstva_id'];
            $iznos2=$_POST['odabirIznosa2'];

            $upit="UPDATE sredstva SET
            iznos='$iznos2'
            WHERE sredstva_id=$sredstva_id";
            upit($bp,$upit);
            header("location:sredstva.php");
          }

          ?>
        </div>

      </div>
    </section>

<?php include("podnozje.php"); ?>
