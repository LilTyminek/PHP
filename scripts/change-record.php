<?php
session_start();
require_once "./connect.php";
$sea = "SELECT id,name,warehouse,quantity from staff where id=\"$_POST[ean]\"";
$conn->query($sea);
if($conn->affected_rows > 0){
    $result = $conn->query($sea);
    $id = $_POST["ean"];
    $name = $_POST["name"];
    $ware = $_POST["warehouse"];
    $qua = $_POST["qua"];
    if(!isset($id)){
        $_SESSION["FAILURE"] = "EAN nie moze byc pusty";
        header("location:../main.php");
        exit();
    }
    $sql1 = "UPDATE staff set ";
    $sql2 = " ";
    $sql3 = " WHERE id = $id";
    $isok = TRUE;
    if(empty($name) && empty($ware) && empty($qua)){
        $isok = FALSE;
    }
    else{
        if(!empty($name)){
            $sql2 .= "name = \"$name\"";
        }
        if(!empty($ware)){
            if(!empty($name)) $sql2 = $sql2.", ";
            $sql2 .= "warehouse = \"$ware\"";
        }
        if(!empty($qua)){
            if($qua<0){
                $isok = FALSE;
            }
            if(!empty($ware) || !empty($name)) $sql2 .= ", ";
            $sql2 .= "quantity = $qua";

        }
        $sql = $sql1.$sql2.$sql3;
        echo $sql;
    }
    if($isok) {
        $conn->query($sql);
        if($conn->affected_rows>0) {
            $_SESSION["SUCCESS"] = "Zmieniono rekord";
            header("location: ../main.php");
        }
        else $_SESSION["FAILURE"] = "Nie zmieniono rekordu";
        header("location: ../main.php");
    }
    else {
        $_SESSION["FAILURE"] = "Nie zmieniono rekordu";
        header("location: ../main.php");
    }



//"UPDATE staff set name = $name, quantity = $qua where id = $id"

}