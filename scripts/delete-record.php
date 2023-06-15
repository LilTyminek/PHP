<?php
if(isset($_POST['checkboxvar'])){
    $checkboxvar = $_POST['checkboxvar'];
    foreach ($checkboxvar as $d){
//            echo $d
        $sql = "UPDATE staff set quantity=0 where id = ?";
        require_once "connect.php";
        $exe = $conn->execute_query($sql,[$d]);
        if($conn->affected_rows>0){
            $_SESSION["SUCCESS"] = "Zmieniono rekord";
//            header("location:../pages/views/main.php");
        }
        else{
            $_SESSION["FAILURE"] = "Nie zmieniono rekordu";
//            header("location:../pages/views/main.php");
        }
    }

}
exit();
//$conn->close();