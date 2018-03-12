<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("LOCATION: index.php");
    }

    if(!isset($_POST['nome'])){
        header("Location: ../index.php");
    }
    if(!isset($_POST['cognome'])){
        header("Location: ../index.php");
    }
    if(!isset($_POST['username'])){
        header("Location: ../index.php");
    }
    if(!isset($_POST['password'])){
        header("Location: ../index.php");
    }
    if(!isset($_POST['classe'])){
        header("Location: ../index.php");
    }

    $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error());
    mysqli_select_db($db,"faq");

    $query=mysqli_query($db,"select * from Utenti where Username='".$_POST['username']."';");
    if(mysqli_num_rows($query)==0){
        $username=$_POST['username'];
        $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
        $classe=$_POST['classe'];
        $nome=$_POST['nome'];
        $cognome=$_POST['cognome'];
        if(mysqli_query($db,"insert into Utenti values(null,false,'".$nome."','".$cognome."','".$username."','".$password."','".$classe."');")){
            session_start();
            $_SESSION['docente']=false;
            $_SESSION['username']=$username;
            $_SESSION['classe']=$classe;
            $query=mysqli_query($db,"select IDUtenteDom from Utenti where Username='".$username."';");
            if(mysqli_num_rows($query)!=0){
                $riga=mysqli_fetch_array($query);
                $id=$riga['IDUtenteDom'];
                $_SESSION['id']=$id;
            }
        }
    }
    mysqli_close($db);
    header("Location: ../index.php");

?>