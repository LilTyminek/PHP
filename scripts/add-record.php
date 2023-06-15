<?php
session_start();
require_once "./connect.php";
//do pliku z formularzem
$ean = $_POST["EAN"];
if(strlen($ean)!=8){
    $_SESSION["FAILURE"] = "EAN jest złej długości";
    header("location:../pages/views/main.php");
    exit();
}
$sea = "SELECT id,quantity from staff where id=?";
$result = $conn->execute_query($sea,[$ean]);
$user = $result->fetch_assoc();
$id = $_POST["EAN"];
$name = $_POST["name"];
$ware = $_POST["warehouse"];
$qua = $_POST["qua"];
if($conn->affected_rows > 0){
    if($user["quantity"]==0){
        if(!isset($id)){
            $_SESSION["FAILURE"] = "EAN nie moze byc pusty";
            header("location:../pages/views/main.php");
            exit();
        }
        $isok = TRUE;
        if(empty($name) || empty($ware) || empty($qua)){
            $isok = FALSE;
        }
        if($isok) {
            $sql = "UPDATE staff set name = ?, warehouse = ?, quantity = ? where id=?";
            $exe = $conn->execute_query($sql,[$name,$ware,$qua,$id]);
            if($conn->affected_rows>0) {
                $_SESSION["SUCCESS"] = "Zmieniono rekord";
                header("location:../pages/views/main.php");
            }
            else $_SESSION["FAILURE"] = "Nie zmieniono rekordu";
            header("location:../pages/views/main.php");
        }
        else {
            $_SESSION["FAILURE"] = "Nie uzupelniono wszystkiego w tabeli";
            header("location:../pages/views/main.php");
        }
    }
    else{
        $_SESSION["FAILURE"] = "Istnieje taki EAN";
        header("location:../pages/views/main.php");
        exit();
    }

}
else{
    $isok = TRUE;
    if(empty($name) || empty($ware) || empty($qua)){
        $isok = FALSE;
    }
    if($isok) {
        $sql="INSERT INTO staff values (?,?,?,?)";
        $conn->execute_query($sql,[$id,$name,$ware,$qua]);
        if($conn->affected_rows > 0){
            $_SESSION["SUCCESS"] = "udało się dodać rekord";
        }
        else $_SESSION["FAILURE"] = "Nie udało się dodać rekordu";
        header("location:../pages/views/main.php");
    }
    else {
        $_SESSION["FAILURE"] = "Nie uzupelniono wszystkiego w tabeli";
        header("location:../pages/views/main.php");
    }
    $conn->close();
    exit();
}