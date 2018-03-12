<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("LOCATION: index.php");
    }

    if(!isset($_POST['username'])){
        header("Location: ../index.php");
    }
    if(!isset($_POST['password'])){
        header("Location: ../index.php");
    }

    $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error());
    mysqli_select_db($db,"faq");

    $query=mysqli_query($db,"select Username,Password,Classe,prof from Utenti where Username='".$_POST['username']."';");
    if(mysqli_num_rows($query)!=0){
        $riga=mysqli_fetch_array($query);
        $username=$riga['Username'];
        $password=$riga['Password'];
        $classe=$riga['Classe'];
        $docente=$riga['prof'];
        if(password_verify($_POST['password'],$password)){
            echo "true";
            session_start();
            if($docente) {
                $_SESSION['docente'] = true;
                $_SESSION['classe'] = null;
                $query=mysqli_query($db,"select IDUtenteDom from Utenti where Username='".$_POST['username']."';");
                if(mysqli_num_rows($query)!=0){
                    $riga=mysqli_fetch_array($query);
                    $id=$riga['IDUtenteDom'];
                    $_SESSION['id']=$id;
                }
            }else {
                $_SESSION['docente'] = false;
                $_SESSION['classe'] = $classe;
                $query=mysqli_query($db,"select IDUtenteDom from Utenti where Username='".$_POST['username']."';");
                if(mysqli_num_rows($query)!=0){
                    $riga=mysqli_fetch_array($query);
                    $id=$riga['IDUtenteDom'];
                    $_SESSION['id']=$id;
                }
            }
            $_SESSION['username']=$username;
        }
    }
    mysqli_close($db);
    header("Location: ../index.php");
?>