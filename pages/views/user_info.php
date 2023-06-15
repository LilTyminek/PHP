<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informacje</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body >
    <div class="menu">
        <div class="error message">
            <?php
            session_start();
            if(empty($_SESSION["session_id"])){
                echo "<a href='../index.php'>blad</a>";
                exit();
            }
                if(isset($_SESSION["error"])){
                    echo $_SESSION["error"];
                    unset($_SESSION["error"]);
                }
                if(isset($_SESSION["success"])){
                    echo $_SESSION["success"];
                    unset($_SESSION["success"]);
                }
                if(isset($_SESSION["pass-error"])){
                    echo $_SESSION["pass-error"];
                    unset($_SESSION["pass-error"]);
                }
            ?>
        </div>
        <div class="menudiv"><a href="../">Wróć</a></div>
    </div>
    <div class="user-info">
        <?php

            require_once "../../scripts/connect.php";
            $role;
            switch ($_SESSION["role_id"]){
                case 1:
                    $role = "quest";
                    break;
                case 2:
                    $role = "user";
                    break;
                case 3:
                    $role = "admin";
                    break;
            }
            $email = $_SESSION["username"];
        //    $user = $conn->execute_query("")
            echo <<<info
            <p>login: $email</br>rola: $role </p>
info;
        ?>
    </div>
    <div class="pass-change">
        <form method="post">
            <input type="submit" name="change-pass" value="Zmień haslo">
        </form>
        <?php
            if(isset($_POST["change-pass"])){
                echo <<<CHANGEPASS
                <form method="post">
                </br>
                    <input type="password" name="old-pass" placeholder="stare haslo"></br>
                    <input type="password" name="new-pass" placeholder="nowe haslo"></br>
                    <input type="password" name="new-pass2" placeholder="powtorz nowe haslo"></br>
                    <input type="submit" name="change-submit">
                    
</form>
CHANGEPASS;
                }
                if(isset($_POST["change-submit"])){
                    foreach ($_POST as $value){
                        if (empty($value)){
                            $_SESSION["pass-error"] = "Wypełnij wszystkie pola!";
                            exit();
                        }
                    }
                    require_once ("../../scripts/connect.php");
                    $sql = "SELECT password from user_table where email=?";
                    $exe = $conn->execute_query($sql,[$email]);
                    $user = $exe->fetch_assoc();
                    $old_pass = $_POST["old-pass"];

                    if(password_verify($old_pass,$user["password"])){
                        $new_pass = $_POST["new-pass"];
                        $new_pass2 = $_POST["new-pass2"];

                        $error = 0;
                        if(strlen($new_pass)<8){
                            $_SESSION["pass-error"] = "Hasło jest za krótkie!";
                            $error = 1;
                        }
                        if ($new_pass != $new_pass2){
                            $_SESSION["pass-error"] = "Hasła są różne!";
                            $error = 1;
                        }
                        if ($error != 0){
                            exit();
                        }
                        $pass = password_hash($new_pass,PASSWORD_DEFAULT);
                        $sql1 = "UPDATE user_table set password = ? where email = ?";
                        $exe1 = $conn->execute_query($sql1,[$pass,$email]);
//                        $user1 = $exe1->fetch_assoc();
                        if($conn->affected_rows>0){
                            $_SESSION["success"] = "zmieniono pomyslenie haslo";
                        }
                        else{
                            $_SESSION["error"] = "cos poszlo nie tak";
                        }
                    }
                    else {
                        $_SESSION["pass-error"] = "Nie prawidłowe hasło";
                        exit();
                    }
                }
        ?>
    </div>
</body>
</html>