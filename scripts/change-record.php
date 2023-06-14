<?php
session_start();
require_once "./connect.php";
$sql = "SELECT * from staff where id=?";
$ean = $_POST["EAN"];
$name = $_POST["name"];
$ware = $_POST["warehouse"];
$qua = $_POST["qua"];
$zap = "";
$exe = $conn->execute_query($sql,[$ean]);
//$conn->query($sea);
if($conn->affected_rows > 0){
    $result = $exe->fetch_assoc();
    if(!isset($ean)){
        $_SESSION["FAILURE"] = "EAN nie moze byc pusty";
//        header("location:../pages/views/main.php");
        exit();
    }
    $sql1 = "UPDATE staff set name = ?, warehouse = ?, quantity = ? WHERE id = ?";
    $isok = TRUE;
    if(empty($name) && empty($ware) && empty($qua)){
        $isok = FALSE;
    }
    else{
        if(empty($name)){
            $name = $result["name"];
        }
        if(empty($ware)){
            $ware = $result["warehouse"];
        }
        if(empty($qua)){
            $qua = $result["quantity"];
        }
        else if($qua<0) $isok=false;
        $zap = $sql1;

    }
    if($isok) {
        $exe1 = $conn->execute_query($zap,[$name,$ware,$qua,$ean]);
        if($conn->affected_rows>0) {
            $_SESSION["SUCCESS"] = "Zmieniono rekord";
            header("location: ../pages/views/main.php");
        }
        else $_SESSION["FAILURE"] = "Nie zmieniono rekordu";
        header("location: ../pages/views/main.php");
    }
    else {
        $_SESSION["FAILURE"] = "Nie zmieniono rekordu, coś poszło nie tak";
        header("location: ../pages/views/main.php");
    }

//"UPDATE staff set name = $name, quantity = $qua where id = $id"
}
$conn->close();
exit();