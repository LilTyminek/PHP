<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body >
    <div class="login-container">
        <form method="post" >
            <input type="text" placeholder="email" name="email"><br>
            <input type="password" placeholder="password" name="password"><br>
            <a href="register.php">Zarejestruj sie</a><br>
            <button type="submit" class="login-button">Zaloguj</button>
        </form>
    </div>
<?php
    require_once "../scripts/connect.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        foreach ($_POST as $value){
            if (empty($value)){
                $_SESSION["error"] = "Wypełnij wszystkie pola!";
                echo "Wypelnij wyszystkie pola";
                exit();
            }
        }
        $sql = "SELECT * from user_table u WHERE `u`.`email`= ?";
        $exe = $conn->execute_query($sql,[$_POST["email"]]);
        $user = $exe->fetch_assoc();
        if($conn->affected_rows>0){
            $pass = $_POST["password"];
            if(password_verify($pass,$user["password"])){
                $role_id = $user["role_id"];
                echo "jest";
                session_start();
                $_SESSION["username"]=$_POST["email"];
                $_SESSION["role_id"]=$role_id;
                header("location: ./views/main.php");
                exit();
            }
            else{
                echo "Błędne haslo";
            }
        }
        else echo "Błędne dane logowania";
    }

?>
</body>
</html>