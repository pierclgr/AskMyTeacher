<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("LOCATION: login.php");
    }

	if(!isset($_POST['annullavoto'])){
		header("location: ../index.php");	
	}

	$db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error($db));
	mysqli_select_db($db,"faq");
	$IDVotazione=$_POST['IDVot'];
	$N_stelle=$_POST['N_stelle'];
	$IDRisposta=$_POST['IDRisp'];
	mysqli_query($db,"delete from Votazioni where IDVotazione='$IDVotazione';") or die("Errore query: ".mysqli_error($db));
	mysqli_query($db,'update Risposte set VotiRisp=VotiRisp-"'.$N_stelle.'" where IDRisposta="'.$IDRisposta.'";') or die("Errore query2: ".mysqli_error($db));
	mysqli_close($db);
	header("location: ../index.php");	
?>