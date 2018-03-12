<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("LOCATION: login.php");
    }

    if(!isset($_POST['modr'])&&!isset($_POST['modd'])){
        header("location: ../index.php");
    }
    if(isset($_POST['modr'])){
        $IDRisposta=$_POST['IDRisp'];
        $testo=$_POST['Testo'];
        $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error());
        mysqli_select_db($db,"faq");
        mysqli_query($db,'update Risposte set Testo="'.$testo.'", DataRisp=curdate(), OraRisp=curtime() where IDRisposta="'.$IDRisposta.'";') or die("Errore query: ".mysqli_error($db));
        mysqli_close($db);
        header("location: ../index.php");
    }else if(isset($_POST["modd"])){
        $IDDomanda=$_POST['IDDom'];
        $testo=$_POST['Testo'];
        $titolo=$_POST['titolodom'];
        $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error());
        mysqli_select_db($db,"faq");
        mysqli_query($db,'update Domande set Testo="'.$testo.'", Domanda="'.$titolo.'", DataDom=curdate(), OraDom=curtime() where IDDomanda="'.$IDDomanda.'";') or die("Errore query: ".mysqli_error($db));
        mysqli_close($db);
        header("location: ../index.php");
    }
?>