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
        if(isset($_SESSION["error"])) {
            echo $_SESSION["error"];
            unset($_SESSION["error"]);
        }
        if(isset($_SESSION["SUCCESS"])) {
            echo $_SESSION["SUCCESS"];
            unset($_SESSION["SUCCESS"]);
        }
        ?>
    </div>
    <div class="menudiv"><a href="../../">Wróć</a></div>
</div>
    <div class="users">
        <table>
            <tr>
                <th>email</th>
                <th>rola</th>
                <th></th>
            </tr>
        <?php
        require_once ("../../../scripts/connect.php");
        $sql = "SELECT * FROM user_table";
        $exe = $conn->execute_query($sql);
        $rolename;
        while($user = $exe->fetch_assoc()){
            switch ($user["role_id"]){
                case (1):
                    $rolename = "quest";
                    break;
                case (2):
                    $rolename = "user";
                    break;
                case (3):
                    $rolename = "admin";
                    break;
            }
            echo<<<SHOWUSERS
<tr>
    <td class="info">$user[email]</td>
    <td class="info">$rolename</td>
</tr>
SHOWUSERS;
        }
        ?>
        </table>
        <form method="post">
            <input type="submit" value = "Zmien role" name="new-role">
        </form>
    </div>
    <div class="role-change">
        <?php
            if(isset($_POST["new-role"])){
                echo<<<CHANGE
                <form method="post">
                <input type="text" name="email" placeholder="email">
                <select name="role">
                <option value="1">Quest</option>
                <option value="2">User</option>
                <option value="3">Admin</option>
</select>
<input type="submit" name="sub-change">
</form>
CHANGE;

                if(isset($_POST["sub-change"])){
                    $email = $_POST["email"];
                    $new_role = $_POST["role"];
                    if(!empty($email) && !empty($new_role)){
                        $sql="UPDATE user_table set role_id = ? where id=?";
                        $exe = $conn->execute_query($sql,[$new_role,$email]);
                        echo "ez";
                        exit();
                        if($conn->affected_rows>0){
                            $_SESSION["SUCCESS"] = "git";
                            header("location: ../");
                            exit();
                        }
                        else{
                            $_SESSION["SUCCESS"] = "nie git";
                            header("location: ../");
                            exit();
                        }
                    }
                    else{
                        echo "uzupelnij pola";
                    }
                }
            }
        ?>
    </div>
</body>
</html>