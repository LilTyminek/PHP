<?php
session_start();
if(isset($_POST["name"]) && isset($_POST["role"])){
    require_once ("./connect.php");
    $name = $_POST["name"];
    $role_id = $_POST["role"];
    $isok = true;
    echo $name." ". $role_id;
    if(empty($name)){
        $isok = false;
    }
    if(empty($role_id)){
        $isok = false;
    }
    if($isok){
        $sql = "UPDATE user_table set role_id = ? where id = ?";
        $exe = $conn->execute_query($sql,[$role_id,$name]);
        if($conn->affected_rows>0){
            $_SESSION["SUCCESS"]= "jest git";
            header("location: ../pages/views/admin/users.php");
        }
        else {
            $_SESSION["error"] = "nie git";
            header("location: ../pages/views/admin/users.php");
        }
    }
    $conn->close();
}