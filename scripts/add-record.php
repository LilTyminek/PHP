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
    $user = $result->fetch_assoc();
    if($user["quantity"]==0){
        if(!isset($id)){
            $_SESSION["FAILURE"] = "EAN nie moze byc pusty";
            header("location:../pages/views/main.php");
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
                header("location:../pages/views/main.php");
            }
            else $_SESSION["FAILURE"] = "Nie zmieniono rekordu";
            header("location:../pages/views/main.php");
        }
        else {
            $_SESSION["FAILURE"] = "Nie zmieniono rekordu";
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

    $sql="INSERT INTO staff values (?,?,?,?)";
    $conn->execute_query($sql,[$ean,$name,$ware,$qua]);
    if($conn->affected_rows > 0){
        $_SESSION["SUCCESS"] = "udało się dodać rekord";
    }
    else $_SESSION["FAILURE"] = "Nie udało się dodać rekordu";
    header("location:../pages/views/main.php");
    $conn->close();
    exit();
}