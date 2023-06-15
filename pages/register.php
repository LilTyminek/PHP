<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body class="hold-transition register-page">
    <?php
    session_start();
        if(isset($_SESSION["error"])){
            echo $_SESSION["error"];
        }
        if(isset($_SESSION["SUCCESS"])){
            echo $_SESSION["SUCCESS"];
        }
    ?>
    <div class="register-container">
        <form method="post">
            <input type="text" placeholder="imie" name="name"><br>
            <input type="text" placeholder="nazwisko" name="surname"><br>
            <input type="text" placeholder="login" name="email" ><br>
            <input type="text" placeholder="powtorz login" name="email2" ><br>
            <input type="password" placeholder="haslo" name="new-pass"><br>
            <input type="password" placeholder="powtorz haslo" name="new-pass2"><br>
            <label>Terms</label><input type="checkbox" name="terms">
            <button type="submit">Zarejestruj</button>
        </form>
    </div>
    <div><a href="index.php">Mam już konto</a></div>
<?php
    require_once "../scripts/connect.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($_POST as $value){
            if (empty($value)){
                $_SESSION["error"] = "Wypełnij wszystkie pola!";
                echo "Wypelnij wyszystkie pola";
                exit();
            }
        }
        $error = 0;
        if (!isset($_POST["terms"])){
            $_SESSION["error"] = "Zaznacz regulamin!";
            $error = 1;
        }
        if ($_POST["new-pass"] != $_POST["new-pass2"]){
            $_SESSION["error"] = "Hasła są różne!";
            $error = 1;
        }
        if ($_POST["email"] != $_POST["email2"]){
            $_SESSION["error"] = "Adresy email są różne!";
            $error = 1;
        }
        if(strlen($_POST["new-pass"])<8){
            $_SESSION["error"] = "Haslo jest za krotkie";
            $error = 1 ;
        }
        if ($error != 0){
            echo $_SESSION["error"];
            exit();
        }
        $email = $_POST["email"];
        $sql = "SELECT * from user_table WHERE `user_table`.`email`= ?";
        $exe = $conn->execute_query($sql,[$email]);
        $user = $exe->fetch_assoc();
        if (!empty($user)) {
            $_SESSION["error"]="Juz istnieje taki user";
            exit();
        }
        else{
            $sql1 = "INSERT INTO `user_table` (`email`,`password`) values (?,?)";
            $pass = password_hash($_POST["new-pass"],PASSWORD_DEFAULT);
            $exe1 = $conn->execute_query($sql1,[$email,$pass]);
            if($conn->affected_rows>0){
                $_SESSION["SUCCESS"]  =  "Stworzono usera $email";
                exit();

            }
            else {
                $_SESSION["error"] = "nie git";
                exit();

            }
        }
    }
?>


</body>
</html>