<html>
    <head>
        <title>FAQ ITIS Dell'Erba</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    
    <body>
    <?php
        session_start();
        if(!isset($_SESSION['username'])){
            header("LOCATION: login.php");
        }
        if(!isset($_POST['inviad'])){
            header("location: ../index.php");
        }

        $docente=$_SESSION['docente'];
        $classe=$_SESSION['classe'];
        $alunno=$_SESSION['username'];
        
        $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error($db));
        mysqli_select_db($db,"faq");
        
        if(isset($_POST['inviad'])){
            $Testo=$_POST['testo'];
            $Titolo=$_POST['titolodom'];
            $IDUtenteDom=$_POST['IDUtenteDom'];
            $IPD=$_POST['IPD'];
            $OSD=$_POST['OSD'];
            $Classe=$_POST['Classe'];
			$sim=0;
            $query=mysqli_query($db,'select Domanda,IDDomanda from Domande;') or die("Errore query: ".mysqli_error($db));;
            if(mysqli_num_rows($query)==0){
                mysqli_query($db,'insert into Domande values(null,"'.$IDUtenteDom.'","'.$IPD.'","'.$OSD.'","'.$Titolo.'","'.$Testo.'",curdate(),curtime());') or die("Errore query: ".mysqli_error($db));
                header("location: ../index.php");
            }else{
                $riga=mysqli_fetch_array($query);
                while($riga){
                    $TitoloDom=$riga['Domanda'];
                    $IDDomanda=$riga['IDDomanda'];
                    similar_text($Titolo,$TitoloDom,$percentTit);
                    if($percentTit>=80.0){
                        $sim++;
                    }
                    $riga=mysqli_fetch_array($query);
                }
                
                if($sim>0){
                    echo '<div id="bo"></div>';
                    echo '<div id="header">';
                        echo '<div id="titolo">FAQ ITIS Dell\'Erba</div>';
                        echo '<div id="info">'.$alunno." ".$classe.' '.date("D j/m/y").'</div>';
                    echo '</div>';


                    echo '<div id="navbar" class="z-depth-2">';
                        echo '<div id="navbut"><div id="navtxt"><center><a href="../index.php" class="buttonlinks">Domande classe</a></center></div></div>';
                        echo '<div id="navbut"><div id="navtxt"><center><a href="../pag2.php" class="buttonlinks">Tue domande</a></center></div></div>';
                    echo '</div>';
                    
                    echo '<div id="middle">';
                        echo '<div id="container" class="z-depth-1"><div style="padding: 20px 20px 20px 20px; font-family: Roboto-Regular; font-size: 20px; color: rgba(0,0,0,0.87);">Sembra che una domanda simile sia gia\' esistente. Controlla fra le domande gia\' presenti.</div></div>';
                    echo '</div>';
                    header("refresh:3 , ../index.php");
                }else{
                    mysqli_query($db,'insert into Domande values(null,"'.$IDUtenteDom.'","'.$IPD.'","'.$OSD.'","'.$Titolo.'","'.$Testo.'",curdate(),curtime());') or die("Errore query: ".mysqli_error($db));
                    header("location: ../index.php");
                }
            }
        }
        mysqli_close($db);    
    ?>
    </body>
</html>