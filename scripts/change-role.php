<?php
session_start();
require_once ("./connect.php");
$sql = "SELECT * from user_table where email = ?";
if(isset($_POST["email"]) && isset($_POST["role"])){
    $email = $_POST["email"];
    $role_id = $_POST["role"];
    $isok = true;
    $exe = $conn->execute_query($sql,[$email]);
    $user = $exe->fetch_assoc();
    $id = $user["id"];
    echo $email." ". $role_id;
    if($conn->affected_rows<1){
        $isok = false;
    }
    if(empty($email)){
        $isok = false;
    }
    if(empty($role_id)){
        $isok = false;
    }
    if($isok){
        echo "yes";
        $sql = "UPDATE user_table set role_id = ? where id = ?";
        $exe = $conn->execute_query($sql,[$role_id,$id]);
        echo $id." ".$role_id;
        if($conn->affected_rows>0){
            $_SESSION["SUCCESS"]= "jest git";
            header("location: ../pages/views/admin/users.php");
        }
        else {
            $_SESSION["error"] = "nie git";
            header("location: ../pages/views/admin/users.php");
        }
    }
    else{
        echo "dupa";
    }
//    $conn->close();
}
else {
    $_SESSION["error"] = "nie uzupelniono";
}