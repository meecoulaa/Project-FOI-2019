<?php

function spoji(){
  $posluzitelj="localhost";
  $baza="iwa_2019_vz_projekt";
  $bazaKorisnik=""; // Enter the username that you use to access your database
  $bazaLozinka=""; // Enter the password that you use to access your database
  $charset="utf8";

  $dbc=mysqli_connect($posluzitelj,$bazaKorisnik,$bazaLozinka,$baza);
  mysqli_set_charset($dbc,$charset);
  if(!$dbc || mysqli_error($dbc)!==""){
    echo "Problem sa spajanjem na bazu;".mysqli_connect_error();
    mysqli_error($dbc);
  }
  return $dbc;
}

function upit($dbc, $upit){
  $rezultat=mysqli_query($dbc,$upit);
  if(mysqli_error($dbc)!==""){
    echo "Problem sa upitom u skripti baza.php funkcija obaviUpit ".mysqli_error($dbc);
  }
  return $rezultat;
}

function zatvori($dbc){
  mysqli_close($dbc);
}

?>
