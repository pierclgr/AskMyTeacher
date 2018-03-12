<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("LOCATION: login.php");
    }

    if(!isset($_POST['starP'])&&!isset($_POST['starA'])){
        header("location: ../index.php");
    }

    $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error($db));
    mysqli_select_db($db,"faq");
    
    if(isset($_POST['starP'])){
        $IDRisposta=$_POST['IDRisp'];
        $nstelle=$_POST['nstelle'];
        $IDUtenteVotazione=$_POST['IDUtenteVot'];
        mysqli_query($db,'insert into Votazioni values(null,"'."$IDUtenteVotazione".'","'."$nstelle".'","'."$IDRisposta".'");') or die("Errore query: ".mysqli_error($db));
        mysqli_query($db,'update Risposte set VotiRisp=VotiRisp+"'."$nstelle".'" where IDRisposta="'."$IDRisposta".'";') or die("Errore query: ".mysqli_error($db));
    }
    
    if(isset($_POST['starA'])){
        $IDRisposta=$_POST['IDRisp'];
        $nstelle=$_POST['nstelle'];
        $IDUtenteVotazione=$_POST['IDUtenteVot'];
        mysqli_query($db,'insert into Votazioni values(null,"'."$IDUtenteVotazione".'","'."$nstelle".'","'."$IDRisposta".'");') or die("Errore query: ".mysqli_error($db));
        mysqli_query($db,'update Risposte set VotiRisp=VotiRisp+"'."$nstelle".'" where IDRisposta="'."$IDRisposta".'";') or die("Errore query: ".mysqli_error($db));
    }
    
    mysqli_close($db);
    
    header("location: ../index.php");
?>