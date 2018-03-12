<!-- Codice PHP per le funzioni di verifica Docente/ Studente -->

<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("LOCATION: login.php");
    }
    
    function getOS() { 
        $user_agent=$_SERVER['HTTP_USER_AGENT'];
        $os_platform="Unknown OS Platform";
        $os_array=array(
			'/windows nt 10.0/i'     =>  'Windows 10',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7', 
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );
        foreach ($os_array as $regex => $value) { 
            if (preg_match($regex, $user_agent)) {
                $os_platform=$value;
            }
        }   
        return $os_platform;
    }
    
    function getIP() {
    if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function getClasse(){
        $classe=$_SESSION['classe'];
        return $classe;
    }

    function getAlunno(){
        $alunno=$_SESSION['username'];
        return $alunno;
    }

    function getIDAlunno(){
        $id=$_SESSION['id'];
        return $id;
    }
    $docente=$_SESSION['docente'];
?>

<html>
    
    <!-- Script per rendere dinamica (in base al contenuto) l'altezza di una textarea -->
    
    <script>
        function textAreaAdjust(o) {
        o.style.height = "1px";
        o.style.height = (25+o.scrollHeight)+"px";
        }
    </script>
    
    <!-- Creazione pagina standard -->
    
    <head>
        <title>FAQ ITIS Dell'Erba</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <?php
            echo '<div id="bo"></div>';
            
            //Modulo di pagina per il docente
            //Info iniziali in alto
            
            if($docente==true){
                echo '<div id="header">';
                    echo '<div id="titolo">FAQ ITIS Dell\'Erba</div>';
                    echo '<div id="info">'.getAlunno().' '.date("D j/m/y").'<a class="button" style="margin-left: 30px; color: white;"href="script/logout.php">Logout</a>'.'</div>';
                echo '</div>';
                
                //Navbar
                
                echo '<div id="navbar" class="z-depth-2">';
                    echo '<a href="index.php" class="buttonlinks"><div id="navbut"><div id="nav1txt"><center>Domande studenti</center></div></div></a>';
                echo '</div>';
                
                //Div middle per il contenimento delle domande/risposte e moduli nuova domanda/nuova risposta
                
                echo '<div id="middle">';
                    
                    //Query SQL per ricerca delle domande della classe attuale e stampa dei div necessari alla visualizzazione
                    
                    $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error($db));
                    mysqli_select_db($db,"faq");
                    $ris=mysqli_query($db,"select Utenti.Nome, Utenti.Cognome, Utenti.Classe, Utenti.IDUtenteDom, Domande.* from Domande join Utenti on Domande.IDUtenteDom=Utenti.IDUtenteDom order by DataDom desc,OraDom desc;") or die('<div id="container" class="z-depth-1">Errore nella query: '.mysqli_error($db).'</div>');
                    if(mysqli_num_rows($ris)==0){
                        echo '<div id="container" class="z-depth-1"><div style="padding: 20px 20px 20px 20px; font-family: Roboto-Regular; font-size: 20px; color: rgba(0,0,0,0.87);">Nessuna domanda fatta dagli studenti!</div></div>';
                    }else if(mysqli_num_rows($ris)>0){
                        $riga=mysqli_fetch_array($ris);
                        while($riga){
                            $Titolo=$riga['Domanda'];
                            $TestoD=$riga['Testo'];
                            $IDDomanda=$riga['IDDomanda'];
                            $IDUtenteDom=$riga['IDUtenteDom'];
                            $nome=$riga['Nome'];
                            $cognome=$riga['Cognome'];
                            $ClasseUtenteD=$riga['Classe'];
                            $IPD=$riga['IP'];
                            $OSD=$riga['OS'];
                            $DataDom=$riga['DataDom'];
                            $OraDom=$riga['OraDom'];
                            echo '<div id="container" class="z-depth-1">';
                                echo '<div class="dcont">';
                                    echo '<div class="domtit">'."$Titolo".'</div>';
                                    echo '<div class="infodom">'."$TestoD".'</div>';
                                    echo '<div class="infoutd">'."<b>$nome $cognome $ClasseUtenteD</b> $IPD $OSD $DataDom $OraDom".'</div>';
                                    echo '<div id="bottt" style="margin-right: 10px;">';
                                        echo '<form name="cancd" style="float: right;" method="post" action="script/delete.php">';
                                            echo '<input type="hidden" name="IDDom" value="'.$IDDomanda.'">';
                                            echo '<input type="submit" name="cancdP" class="button" value="Cancella">';
                                        echo '</form>';
                                        echo '<form action="script/modify.php" method="post" id="interact">';
                                            echo '<input type="hidden" name="IDDom" value="'.$IDDomanda.'">';
                                            echo '<input type="submit" method="post" class="button" id="cancr" name="modd" value="Modifica domanda">';
                                        echo '</form>';
                                    echo '</div>';
                                echo '</div>';
                                echo '<div class="divider"></div>';
                                echo '<div class="rcont">';
                                    $query2=mysqli_query($db,"SELECT * FROM Risposte JOIN Utenti on Risposte.IDUtenteRisp=Utenti.IDUtenteDom where Risposte.IDDomanda=".$IDDomanda." and Utenti.prof=1 order by Risposte.DataRisp desc,Risposte.OraRisp desc;");
                                    if(mysqli_num_rows($query2)==0){
                                    }else{
                                        $riga4=mysqli_fetch_array($query2);
                                        while($riga4){
                                            $idutenterisp=$riga4['IDUtenteRisp'];
                                            $idrisp=$riga4['IDRisposta'];
                                            $data=$riga4['DataRisp'];
                                            $ora=$riga4['OraRisp'];
                                            $testo=$riga4['Testo'];
                                            $nome=$riga4['Nome'];
                                            $cognome=$riga4['Cognome'];
                                            echo '<div class="risp"><b>'."$testo".'</b></div>';
                                            echo '<div class="infoutr">'."<b>Prof. $nome $cognome $data $ora".'</b></a></div>';
                                            if($idutenterisp==getIDAlunno()){
                                                echo '<div style="margin-top: 5px;">';
                                                echo '<div id="bottt">';
                                                echo '<form action="script/delete.php" method="post" id="interactr">';
                                                echo '<input type="hidden" name="IDRisp" value="'.$idrisp.'">';
                                                echo '<input type="submit" method="post" class="button" id="cancr" name="cancrP" value="Cancella">';
                                                echo '</form>';
                                                echo '<form action="script/modify.php" method="post" id="interact">';
                                                echo '<input type="hidden" name="IDRisp" value="'.$idrisp.'">';
                                                echo '<input type="submit" method="post" class="button" id="cancr" name="modr" value="Modifica risposta">';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            $riga4=mysqli_fetch_array($query2);
                                        }
                                    }
                                    $ris2=mysqli_query($db,"SELECT * FROM Risposte JOIN Utenti on Risposte.IDUtenteRisp=Utenti.IDUtenteDom where Risposte.IDDomanda=".$IDDomanda." and Utenti.prof=false order by Risposte.VotiRisp desc,Risposte.DataRisp desc,Risposte.OraRisp desc;") or die('<div id="container" class="z-depth-1">Errore nella query: '.mysqli_error($db).'</div>');
                                    if(mysqli_num_rows($ris2)==0){
                                    }else if(mysqli_num_rows($ris2)>0){
                                        $riga2=mysqli_fetch_array($ris2);
                                        while($riga2){
                                            $IDRisposta=$riga2['IDRisposta'];
                                            $IDUtenteRisp=$riga2['IDUtenteRisp'];
                                            $ClasseUtenteR=$riga2['Classe'];
                                            $nome=$riga2['Nome'];
                                            $cognome=$riga2['Cognome'];
                                            $IPR=$riga2['IP'];
                                            $OSR=$riga2['OS'];
                                            $TestoR=$riga2['Testo'];
                                            $DataRisp=$riga2['DataRisp'];
                                            $OraRisp=$riga2['OraRisp'];
                                            $VotiRisp=$riga2['VotiRisp'];
                                            echo '<div class="risp">'."$TestoR".'</div>';
                                            echo '<div class="infoutr">'."<b>$nome $cognome $ClasseUtenteR</b> $IPR $OSR $DataRisp $OraRisp".' <a style="color: #FFC107;">'."$VotiRisp&#9733;".'</a></div>';
                                            echo '<div style="margin-top: 5px;">';
                                                echo '<div id="bottt">';
                                                    echo '<div style="margin-top: 7.5px; margin-left: 45px; margin-bottom: 7.5px; font-family: Roboto-Regular; font-size: 15px; float:left;">';
                                                        $query=mysqli_query($db,'select N_stelle,IDVotazione from Votazioni where IDUtenteVotazione="'.getIDAlunno().'" and IDRisposta="'."$IDRisposta".'";') or die("Errore query: ".mysqli_error($db));
                                                        if(mysqli_num_rows($query)==0){
                                                            echo '<div style="float:left;"><a style="color: rgba(0,0,0,0.54);">Vota la risposta:</a></div>';
                                                            for($i=0;$i<5;$i++){
                                                                echo '<form class="stars" action="script/vote.php" method="post" style="float: left;">';
                                                                    echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                                                    echo '<input type="hidden" name="IDUtenteVot" value="'.getIDAlunno().'">';
                                                                    echo '<input type="hidden" name="nstelle" value="'.($i+1).'">';
                                                                    echo '<input name="starP" method="post" type="submit" value="&#9733;" class="star">';
                                                                echo '</form>';
                                                            }
                                                        }else{
                                                            $riga3=mysqli_fetch_array($query);
                                                            $nstelle=$riga3['N_stelle'];
                                                            $IDVotazione=$riga3['IDVotazione'];
                                                            echo '<div style="float:left;"><a style="color: rgba(0,0,0,0.54);">Risposta gi&agrave; votata:</a></div>';
                                                            for($i=0;$i<$nstelle;$i++){
                                                                echo '<div style="line-height: 20px; margin-left: 5px;  float: left; color:rgba(0,0,0,0.54); font-size:22.5px; font-family: Roboto-Regular;">&#9733;</div>';
                                                            }
                                                            for($i=0;$i<(5-$nstelle);$i++){
                                                                echo '<div style="line-height: 20px; margin-left: 5px;  float: left; color:rgba(0,0,0,0.26); font-size:22.5px; font-family: Roboto-Regular;">&#9733;</div>';
                                                            }
                                                        }
                                                    echo '</div>';
                                                    echo '<form action="script/delete.php" method="post" id="interactr">';
                                                        echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                                        echo '<input type="submit" method="post" class="button" id="cancr" name="cancrP" value="Cancella">';
                                                    echo '</form>';
                                                    echo '<form action="script/modify.php" method="post" id="interact">';
                                                        echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                                        echo '<input type="submit" method="post" class="button" id="cancr" name="modr" value="Modifica risposta">';
                                                    echo '</form>';
                                                    if(mysqli_num_rows($query)>0){
                                                        echo '<form action="script/annullavot.php" method="post" id="interact">';
                                                        echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                                        echo '<input type="hidden" name="N_stelle" value="'.$nstelle.'" >';
                                                        echo '<input type="hidden" name="IDVot" value="'.$IDVotazione.'" >';
                                                        echo '<input type="submit" name="annullavoto" method="post" id="cancr" class="button" value="Annulla voto">';
                                                        echo '</form>';
                                                    }
                                                echo '</div>';
                                            echo '</div>';
                                            $riga2=mysqli_fetch_array($ris2);
                                        }
                                    }
                            echo '</div>';
                            echo '<div class="divider"></div>';
                            $query2=mysqli_query($db,"SELECT * FROM Risposte JOIN Utenti on Risposte.IDUtenteRisp=Utenti.IDUtenteDom where Utenti.prof=1 and Risposte.IDDomanda=".$IDDomanda." and Utenti.IDUtenteDom=".getIDAlunno().";");
                            if(mysqli_num_rows($query2)==0){
                                echo '<div class="ncont">';
                                    echo '<a style="font-size: 15px; font-family: Roboto-Regular; color: rgba(0,0,0,0.87); margin-left: 10px;">Nuova risposta</a>';
                                    echo '<form id="nuovar" action="script/nuovar.php" method="post">';
                                        echo '<textarea rows="1" onkeyup="textAreaAdjust(this);" id="nrisp" class="textfield" name="nrisp" placeholder="Risposta (max 400 caratteri)" maxlength="400" required></textarea>';
                                        echo '<br>';
                                        echo '<br>';
                                        echo '<div id="bottt">';
                                            echo '<input type="hidden" name="IDDom" value="'.$IDDomanda.'">';
                                            echo '<input type="hidden" name="IDUtenteRisp" value="'.getIDAlunno().'">';
                                            echo '<input type="submit" name="inviarP" id="invia" method="post" class="button" value="Rispondi">';
                                        echo '</div>';
                                    echo '</form>';
                                echo '</div>';
                            }else{
                                echo '<div class="ncont" style="color: rgba(0,0,0,0.87);">Hai gi&agrave; risposto a questa domanda, puoi rispondere una sola volta.</div>';
                            }
                            echo '</div>';
                            $riga=mysqli_fetch_array($ris);
                        }
                    }
                    mysqli_close($db);
                echo '</div>';
                
                //Modulo di pagina per gli studenti
                //Info iniziali in alto
                
            }elseif($docente==false){
                
                echo '<div id="header">';
                    echo '<div id="titolo">FAQ ITIS Dell\'Erba</div>';
                    echo '<div id="info">'.getAlunno()." ".getClasse().' '.date("D j/m/y").'<a class="button" style="margin-left: 30px; color: white;"href="script/logout.php">Logout</a>'.'</div><br>';
                    echo '<div id="info"></div>';
                echo '</div>';
                
                //Navbar
				
                echo '<b><a href="#nuova" class="buttonlinks"><div id="pulsantep" class="z-depth-3"><center><div id="testop">+</div></center></div></a></b>';
                echo '<div id="navbar" class="z-depth-2">';
                    echo '<a href="index.php" class="buttonlinks"><div id="navbut"><div id="nav1txt"><center>Domande studenti</center></div></div></a>';
                    echo '<a href="pag2.php" class="buttonlinks"><div id="navbut"><div id="navtxt"><center>Tue domande</center></div></div></a>';
                echo '</div>';
                
                echo '<div id="middle">';
                    $db=mysqli_connect("localhost","root","") or die("Errore connessione: ".mysqli_error());
                    mysqli_select_db($db,"faq");
                    $ris=mysqli_query($db,"select Utenti.Nome, Utenti.Cognome, Utenti.Classe, Utenti.IDUtenteDom, Domande.* from Domande join Utenti on Domande.IDUtenteDom=Utenti.IDUtenteDom order by DataDom desc,OraDom desc;") or die('<div id="container" class="z-depth-1">Errore nella query: '.mysqli_error($db).'</div>');
                    if(mysqli_num_rows($ris)==0){
                        echo '<div id="container" class="z-depth-1"><div style="padding: 20px 20px 20px 20px; font-family: Roboto-Regular; font-size: 20px; color: rgba(0,0,0,0.87);">Nessuna domanda fatta dagli studenti!</div></div>';
                    }else if(mysqli_num_rows($ris)>0){
                        $riga=mysqli_fetch_array($ris);
                        while($riga){
                            $Titolo=$riga['Domanda'];
                            $TestoD=$riga['Testo'];
                            $IDDomanda=$riga['IDDomanda'];
                            $nome=$riga['Nome'];
                            $cognome=$riga['Cognome'];
                            $IDUtenteDom=$riga['IDUtenteDom'];
                            $ClasseUtenteD=$riga['Classe'];
                            $OSD=$riga['OS'];
                            $DataDom=$riga['DataDom'];
                            $OraDom=$riga['OraDom'];
                            echo '<div id="container" class="z-depth-1">';
                                echo '<div class="dcont">';
                                    echo '<div class="domtit">'."$Titolo".'</div>';
                                    echo '<div class="infodom">'."$TestoD".'</div>';
                                    echo '<div class="infoutd">'."<b>$nome $cognome $ClasseUtenteD</b> $OSD $DataDom $OraDom".'</div>';
                                    if($IDUtenteDom==getIDAlunno()){
                                        echo '<div id="bottt" style="margin-right: 10px;">';
                                            echo '<form name="cancd" style="float: right;" method="post" action="script/delete.php">';
                                                echo '<input type="hidden" name="IDDom" value="'.$IDDomanda.'">';
                                                echo '<input type="submit" name="cancdP" class="button" value="Cancella">';
                                            echo '</form>';
                                            echo '<form action="script/modify.php" method="post" id="interact">';
                                                echo '<input type="hidden" name="IDDom" value="'.$IDDomanda.'">';
                                                echo '<input type="submit" method="post" class="button" id="cancr" name="modd" value="Modifica domanda">';
                                            echo '</form>';
                                        echo '</div>';
                                    }
                                echo '</div>';
                                echo '<div class="divider"></div>';
                                echo '<div class="rcont">';
                                    $query2=mysqli_query($db,"SELECT * FROM Risposte JOIN Utenti on Risposte.IDUtenteRisp=Utenti.IDUtenteDom where Risposte.IDDomanda=".$IDDomanda." and Utenti.prof=1 order by Risposte.DataRisp desc,Risposte.OraRisp desc;") or die('<div id="container" class="z-depth-1">Errore nella query: '.mysqli_error($db).'</div>');
                                    if(mysqli_num_rows($query2)==0){
                                    }else{
                                        $riga4=mysqli_fetch_array($query2);
                                        while($riga4){
                                            $idrisp=$riga4['IDRisposta'];
                                            $data=$riga4['DataRisp'];
                                            $ora=$riga4['OraRisp'];
                                            $testo=$riga4['Testo'];
                                            $nome=$riga4['Nome'];
                                            $cognome=$riga4['Cognome'];
                                            echo '<div class="risp"><b>'."$testo".'</b></div>';
                                            echo '<div class="infoutr">'."<b>Prof. $nome $cognome $data $ora".'</b></a></div>';
                                            echo '<div style="margin-top: 5px;">';
                                            echo '<div id="bottt"></div>';
                                            echo '</div>';
                                            $riga4=mysqli_fetch_array($query2);
                                        }
                                    }
                                    $ris2=mysqli_query($db,"SELECT * FROM Risposte JOIN Utenti on Risposte.IDUtenteRisp=Utenti.IDUtenteDom where Risposte.IDDomanda=".$IDDomanda." and Utenti.prof=false order by Risposte.VotiRisp desc,Risposte.DataRisp desc,Risposte.OraRisp desc;") or die('<div id="container" class="z-depth-1">Errore nella query: '.mysqli_error($db).'</div>');
                                    if(mysqli_num_rows($ris2)==0){
                                    }else if(mysqli_num_rows($ris2)>0){
                                        $riga2=mysqli_fetch_array($ris2);
                                        while($riga2){
                                            $IDRisposta=$riga2['IDRisposta'];
                                            $IDUtenteRisp=$riga2['IDUtenteRisp'];
                                            $ClasseUtenteR=$riga2['Classe'];
                                            $nome=$riga2['Nome'];
                                            $cognome=$riga2['Cognome'];
                                            $OSR=$riga2['OS'];
                                            $TestoR=$riga2['Testo'];
                                            $DataRisp=$riga2['DataRisp'];
                                            $OraRisp=$riga2['OraRisp'];
                                            $VotiRisp=$riga2['VotiRisp'];
                                            echo '<div class="risp">'."$TestoR".'</div>';
                                            echo '<div class="infoutr">'."<b>$nome $cognome $ClasseUtenteR</b> $OSR $DataRisp $OraRisp".' <a style="color: #FFC107;">'."$VotiRisp&#9733;".'</a></div>';
                                            echo '<div style="margin-top: 5px;">';
                                                echo '<div id="bottt">';
                                                    echo '<div style="margin-top: 7.5px; margin-left: 45px; margin-bottom: 7.5px; font-family: Roboto-Regular; font-size: 15px; float:left;">';
                                                        $query=mysqli_query($db,'select N_stelle,IDVotazione from Votazioni where IDUtenteVotazione="'.getIDAlunno().'" and IDRisposta="'."$IDRisposta".'";') or die("Errore query: ".mysqli_error());
                                                        if(mysqli_num_rows($query)==0){
                                                            echo '<div style="float:left;"><a style="color: rgba(0,0,0,0.54);">Vota la risposta:</a></div>';
                                                            for($i=0;$i<5;$i++){
                                                                echo '<form class="stars" action="script/vote.php" method="post" style="float: left;">';
                                                                    echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                                                    echo '<input type="hidden" name="nstelle" value="'.($i+1).'">';
                                                                    echo '<input type="hidden" name="IDUtenteVot" value="'.getIDAlunno().'">';
                                                                    echo '<input type="hidden" name="Classe" value="'.getClasse().'">';
                                                                    echo '<input name="starA" method="post" type="submit" value="&#9733;" class="star">';
                                                                echo '</form>';
                                                            }
                                                        }else{
                                                            $riga3=mysqli_fetch_array($query);
                                                            $nstelle=$riga3['N_stelle'];
                                                            $IDVotazione=$riga3['IDVotazione'];
                                                            echo '<div style="float:left;"><a style="color: rgba(0,0,0,0.54);">Risposta gi&agrave; votata:</a></div>';
                                                            for($i=0;$i<$nstelle;$i++){
                                                                echo '<div style="line-height: 20px; margin-left: 5px;  float: left; color:rgba(0,0,0,0.54); font-size:22.5px; font-family: Roboto-Regular;">&#9733;</div>';
                                                            }
                                                            for($i=0;$i<(5-$nstelle);$i++){
                                                                echo '<div style="line-height: 20px; margin-left: 5px;  float: left; color:rgba(0,0,0,0.26); font-size:22.5px; font-family: Roboto-Regular;">&#9733;</div>';
                                                            }
                                                        }
                                                    echo '</div>';
                                                    if($IDUtenteRisp==getIDAlunno()){
                                                        echo '<form action="script/delete.php" method="post" id="interactr">';
                                                        echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                                        echo '<input type="submit" method="post" class="button" id="cancr" name="cancrP" value="Cancella">';
                                                        echo '</form>';
                                                        echo '<form action="script/modify.php" method="post" id="interact">';
                                                        echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                                        echo '<input type="submit" method="post" class="button" id="cancr" name="modr" value="Modifica risposta">';
                                                        echo '</form>';
                                                    }
                                                    if(mysqli_num_rows($query)>0){
                                                        echo '<form action="script/annullavot.php" method="post" id="interact">';
                                                        echo '<input type="hidden" name="IDRisp" value="'.$IDRisposta.'">';
                                                        echo '<input type="hidden" name="N_stelle" value="'.$nstelle.'" >';
                                                        echo '<input type="hidden" name="IDVot" value="'.$IDVotazione.'" >';
                                                        echo '<input type="submit" name="annullavoto" method="post" id="cancr" class="button" value="Annulla voto">';
                                                        echo '</form>';
                                                    }
                                                echo '</div>';
                                            echo '</div>';
                                            $riga2=mysqli_fetch_array($ris2);
                                        }
                                    }
                                echo '</div>';
                                echo '<div class="divider"></div>';
                                $query3=mysqli_query($db,"select * from Risposte join Utenti on Risposte.IDUtenteRisp=Utenti.IDUtenteDom where Risposte.IDDomanda='$IDDomanda' and Risposte.IDUtenteRisp='".getIDAlunno()."' and Utenti.prof=0;") or die('Errore nella query: '.mysqli_error($db));
                                if(mysqli_num_rows($query3)==0){
                                    echo '<div class="ncont">';
                                        echo '<a style="font-size: 15px; font-family: Roboto-Regular; color: rgba(0,0,0,0.87); margin-left: 10px;">Nuova risposta</a>';
                                        echo '<form id="nuovar" action="script/nuovar.php" method="post">';
                                            echo '<textarea rows="1" onkeyup="textAreaAdjust(this);" id="nrisp" class="textfield" name="nrisp" placeholder="Risposta (max 400 caratteri)" maxlength="400" required></textarea>';
                                            echo '<br>';
                                            echo '<br>';
                                            echo '<div id="bottt">';
                                                echo '<input type="hidden" name="IDDom" value="'.$IDDomanda.'">';
                                                echo '<input type="hidden" name="IDUtenteRisp" value="'.getIDAlunno().'">';
                                                echo '<input type="hidden" name="Classe" value="'.getClasse().'">';
                                                echo '<input type="hidden" name="OSR" value="'.getOS().'">';
                                                echo '<input type="hidden" name="IPR" value="'.getIP().'">';
                                                echo '<input type="submit" name="inviarA" id="invia" method="post" class="button" value="Rispondi">';
                                            echo '</div>';
                                        echo '</form>';
                                    echo '</div>';
                                }else{
                                    echo '<div class="ncont" style="color: rgba(0,0,0,0.87);">Hai gi&agrave; risposto a questa domanda, puoi rispondere una sola volta.</div>';
                                }
                            echo '</div>';
                            $riga=mysqli_fetch_array($ris);
                        }
                    }
                    mysqli_close($db);
                    echo '<a name="nuova"></a>';
                    echo '<div id="container" class="z-depth-1">';
                        echo '<div class="ncont">';
                            echo '<form id="nuovad" action="script/nuovad.php" method="post">';
                                echo '<input type="text" id="ndom" class="textfield" name="titolodom" placeholder="Nuova domanda (max 200 caratteri)" maxlength="200" required>';
                                echo '<br>';
                                echo '<br>';
                                echo '<textarea rows="1" onkeyup="textAreaAdjust(this);" id="ndom" class="textfield" maxlength="400" name="testo" placeholder="Descrizione nuova domanda (max 400 caratteri, facoltativa)"></textarea>';
                                echo '<br>';
                                echo '<br>';
                                echo '<div id="bottt">';
                                    echo '<input type="hidden" name="IDUtenteDom" value="'.getIDAlunno().'">';
                                    echo '<input type="hidden" name="Classe" value="'.getClasse().'">';
                                    echo '<input type="hidden" name="OSD" value="'.getOS().'">';
                                    echo '<input type="hidden" name="IPD" value="'.getIP().'">';
                                    echo '<input type="submit" name="inviad" id="invia" method="post" class="button" value="Invia">';
                                echo '</div>';
                            echo '</form>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                
            echo '</div>';
            }
        ?>
    </body>    
</html>