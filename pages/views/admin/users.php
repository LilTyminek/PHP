<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body >
<div class="menu">
    <div class="error message">
        <?php
        session_start();
        if(isset($_SESSION["error"])) echo $_SESSION["error"];
        ?>
    </div>
    <div class="menudiv"><a href="../">Wróć</a></div>
</div>
    <div class="users">
        <?php
            echo<<<SHOWUSERS
            <table>
                
            
            
</table>
SHOWUSERS;

        ?>
    </div>
    <div class="pass-change">
        <form method="post">
            <input type="submit" name="change-pass" value="Zmień haslo">
        </form>
        <?php

        ?>
    </div>
</body>
</html>