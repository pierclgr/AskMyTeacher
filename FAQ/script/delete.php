<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("LOCATION: login.php");
    }

	if(!isset($_POST['cancdP'])){
		header("location: ../index.php");	
	}
	
	if(!isset($_POST['cancrP'])){
		header("location: ../index.php");	
	}

	$db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error());
	mysqli_select_db($db,"faq");
	
	if(isset($_POST['cancdP'])){
		$IDDomanda=$_POST['IDDom'];
		mysqli_query($db,"delete from Domande where IDDomanda='$IDDomanda';") or die("Errore query: ".mysqli_error());
	}
	
	if(isset($_POST['cancrP'])){
		$IDRisposta=$_POST['IDRisp'];
		mysqli_query($db,"delete from Risposte where IDRisposta='$IDRisposta';") or die("Errore query: ".mysqli_error());
	}
	
	mysqli_close($db);
	header("location: ../index.php");	
?>