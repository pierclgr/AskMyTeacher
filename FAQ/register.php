<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("LOCATION: index.php");
    }
?>


<html>
<head>
    <title>FAQ ITIS Dell'Erba</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="register_form centered z-depth-2" style="position: fixed;">
    <div class="banner-100 z-depth-1">
        <b>FAQ ITIS Dell'Erba</b>
    </div>
    <div class="form">
        <form class="form" action="script/register.php" method="POST">
            <input class="textfield" id="logform" type="text" name="nome" placeholder="Nome" required>
            <br><br><br>
            <input class="textfield" id="logform" type="text" name="cognome" placeholder="Cognome" required>
            <br><br><br>
            <input class="textfield" id="logform" type="text" name="classe" placeholder="Classe" required>
            <br><br><br>
            <input class="textfield" id="logform" type="text" name="username" placeholder="Username" required>
            <br><br><br>
            <input class="textfield" id="logform" type="password" name="password" placeholder="Password" required>
            <br><br><br>
            <input type="submit" class="button_blue" value="Registrati">
            <br><br><br>
            <a href="login.php">Login</a>
        </form>
    </div>
</div>
</body>
</html>

