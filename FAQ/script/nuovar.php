<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("LOCATION: login.php");
    }

    if(!isset($_POST['inviarP'])&&!isset($_POST['inviarA'])){
        header("location: ../index.php");
    }

    $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error());
    mysqli_select_db($db,"faq");

    if(isset($_POST['inviarP'])){
        $testo=$_POST['nrisp'];
        $IDDomanda=$_POST['IDDom'];
        $IDUtenteRisp=$_POST['IDUtenteRisp'];
        mysqli_query($db,'insert into Risposte values(null,"'.$IDUtenteRisp.'",null,null,"'."$testo".'",curdate(),curtime(),0,"'."$IDDomanda".'");') or die("Errore query: ".mysqli_error($db));
    }
    
    if(isset($_POST['inviarA'])){
        $testo=$_POST['nrisp'];
        $IDDomanda=$_POST['IDDom'];
        $OSR=$_POST['OSR'];
        $IPR=$_POST['IPR'];
        $IDUtenteRisposta=$_POST['IDUtenteRisp'];
        mysqli_query($db,'insert into Risposte values(null,"'."$IDUtenteRisposta".'","'."$IPR".'","'."$OSR".'","'."$testo".'",curdate(),curtime(),0,"'."$IDDomanda".'");') or die("Errore query: ".mysqli_error($db));
    }
    
    mysqli_close($db);
    header("location: ../index.php");
?>