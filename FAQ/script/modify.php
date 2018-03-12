<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("LOCATION: login.php");
    }

    if(!isset($_POST['modr'])&&!isset($_POST['modd'])){
        header("location: ../index.php");
    }

    $docente=$_SESSION['docente'];
    $classe=$_SESSION['classe'];
    $alunno=$_SESSION['username'];
?>

<html>
    
    <script>
        function textAreaAdjust(o) {
            o.style.height = "1px";
            o.style.height = (25+o.scrollHeight)+"px";
        }
    </script>
    
    <head>
        <title>FAQ ITIS Dell'Erba</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>
    <body>
        <?php
            echo '<div id="bo"></div>';
            
            if($docente==true){
                echo '<div id="header">';
                    echo '<div id="titolo">FAQ ITIS Dell\'Erba</div>';
                    echo '<div id="info">'."$alunno"." ".date("D j/m/y").'<a class="button" style="margin-left: 30px; color: white;"href="script/logout.php">Logout</a>'.'</div>';
                echo '</div>';
                echo '<div id="navbar" class="z-depth-2">';
                echo '<a href="../index.php" class="buttonlinks"><div id="navbut"><div id="navtxt"><center>Domande studenti</center></div></div></a>';
                echo '</div>';
                
            }elseif($docente==false){
                echo '<div id="header">';
                    echo '<div id="titolo">FAQ ITIS Dell\'Erba</div>';
                    echo '<div id="info">'."$alunno"." "."$classe"." ".date("D j/m/y").'<a class="button" style="margin-left: 30px; color: white;"href="script/logout.php">Logout</a>'.'</div>';
                echo '</div>';
                echo '<div id="navbar" class="z-depth-2">';
                    echo '<a href="../index.php" class="buttonlinks"><div id="navbut"><div id="navtxt"><center>Domande studenti</center></div></div></a>';
                    echo '<a href="../pag2.php" class="buttonlinks"><div id="navbut"><div id="navtxt"><center>Tue domande</center></div></div></a>';
                echo '</div>';
            }
            
            $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error($db));
            mysqli_select_db($db,"faq");
            
            if(isset($_POST["modr"])){
                $IDRisposta=$_POST['IDRisp'];
                
                $query=mysqli_query($db,'select Testo from Risposte where IDRisposta="'.$IDRisposta.'";') or die("Errore query: ".mysqli_error($db));
                $riga=mysqli_fetch_array($query);
                $testo=$riga['Testo'];
                
                echo '<div id="middle">';
                    echo '<div id="container" class="z-depth-1">';
                        echo '<div class="ncont">';
                            echo '<a style="font-size: 15px; font-family: Roboto-Regular; color: rgba(0,0,0,0.87); margin-left: 10px;">Modifica risposta</a>';
                            echo '<form id="nuovar" action="mod.php" method="post">';
                                echo '<textarea rows="1" onkeyup="textAreaAdjust(this);" id="nrisp" class="textfield" name="Testo" placeholder="Risposta (max 400 caratteri)" maxlength="400" required>'.$testo.'</textarea>';
                                echo '<br>';
                                echo '<br>';
                                echo '<div id="bottt">';
                                    echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                    echo '<input type="submit" name="modr" id="invia" method="post" class="button" value="Modifica">';
                                echo '</div>';
                            echo '</form>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }else if(isset($_POST["modd"])){
                $IDDomanda=$_POST['IDDom'];
                
                $query=mysqli_query($db,'select Testo,Domanda from Domande where IDDomanda="'.$IDDomanda.'";') or die("Errore query: ".mysqli_error($db));
                $riga=mysqli_fetch_array($query);
                $testo=$riga['Testo'];
                $titolo=$riga['Domanda'];

                echo '<div id="middle">';
                    echo '<div id="container" class="z-depth-1">';
                        echo '<div class="ncont">';
                            echo '<a style="font-size: 15px; font-family: Roboto-Regular; color: rgba(0,0,0,0.87); margin-left: 10px;">Modifica domanda</a>';
                            echo '<form id="nuovar" action="mod.php" method="post">';
                            echo '<br>';
                                echo '<input type="text" id="ndom" class="textfield" name="titolodom" placeholder="Domanda" value="'.$titolo.'" required>';
                                echo '<script>
                                        document.getElementById("ndom").setAttribute("value","'.$titolo.'"); 
                                      </script>';
                                echo '<br>';
                                echo '<br>';
                                echo '<textarea rows="1" onkeyup="textAreaAdjust(this);" id="ndom" class="textfield" name="Testo" maxlength="400" placeholder="Descrizione domanda (max 400 caratteri, facoltativa)" required>'.$testo.'</textarea>';
                                echo '<br>';
                                echo '<br>';
                                echo '<div id="bottt">';
                                    echo '<input type="hidden" name="IDDom" value="'.$IDDomanda.'">';
                                    echo '<input type="submit" name="modd" id="invia" method="post" class="button" value="Modifica">';
                                echo '</div>';
                            echo '</form>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            }
            
            mysqli_close($db);
        ?>
    </body>    
</html>