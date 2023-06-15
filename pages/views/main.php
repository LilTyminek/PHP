<!DOCTYPE HMTL>
<?php
    session_start();
    if(empty($_SESSION["username"])){
        echo "<a href='../index.php'>blad</a>";
        exit();
    }
?>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title> elo</title>
        <link rel="stylesheet" href="../../css/style.css">
    </head>
    <body>
        <div class="container">
            <div class="menu">
                <?php
                $role_id = $_SESSION["role_id"];
                    if(isset($_SESSION["SUCCESS"])){
                        echo $_SESSION["SUCCESS"];
                        unset( $_SESSION["SUCCESS"]);
                    }
                    if(isset($_SESSION["FAILURE"])){
                        echo $_SESSION["FAILURE"];
                        unset( $_SESSION["FAILURE"]);
                    }

                ?>
                        <div class="menudiv">
                            <a href="user_info.php"><p>Informacje o użytkowniku</p></a>
                        </div>
                        <?php
                        if($role_id=='3' ){
                            echo <<<USERS
                            <div class="info"><a href="./admin/users.php">Użytkownicy</a></div></br>
USERS;

                        }
                        ?>
                        <div class="menudiv">
                            <a href="../../scripts/logout.php">Wyloguj</a>
                        </div>
                        <div class="l"> </div>
                    </div>
            <div class="search">
                <form method="post">
                    <input type="text" name="search">
                    <input type="submit">
                    <input type="submit" value="Zresetuj filtry" name="clearsearch">
                </form>
                <?php

                ?>
            </div>
            <div class="inv">
                <form method="post">
                    <table >
                        <tr>
                            <th class="checkbox"></th>
                            <th>id</th>
                            <th>nazwa</th>
                            <th>magazyn</th>
                            <th>ilosc</th>
                        </tr>
                        <?php
                        require_once "../../scripts/connect.php";
                        $sql = "SELECT `u`.`id`, `u`.`name`, `u`.`warehouse`,`u`.`quantity` FROM `staff` u WHERE ";
                        $sql2= "`u`.`quantity`>0 order by `u`.`id` ASC";

                        //searchbar

//                        if(!isset($_SESSION["searchcheck"])){
//                            $_SESSION["searchcheck"] = false;
//                            unset($_SESSION["clearsearch"]);
//                        }

                        $search_check = false;
                        $find = "";
                        if(!isset($_SESSION["search"])){
                            $_SESSION["search"] = "";
                        }
                        if(!empty($_POST["search"]) && strlen($_POST["search"])>=3){
                            $find = "%".$_POST["search"]."%";
                            $_SESSION["search"] = $find;
                            $wh = "(`u`.`id` like ? || `u`.`name` like ? || `u`.`warehouse` like ? ) && ";
                            $sql.=$wh;
                            $_SESSION["lastsql"] = $sql;
                            $_GET["page"] = 1;
//                            $_SESSION["searchcheck"] = true;
                            $search_check = true;
                        }
                        if(isset($_POST["clearsearch"])){
                            unset($_SESSION["lastsql"]);
                            unset($_SESSION["search"]);
                            $_GET["page"] = 1;
                            $_SESSION["searchcheck"] = false;
                        }
                        if(isset($_SESSION["lastsql"])){
                            $sql = $_SESSION["lastsql"];
                            $find = $_SESSION["search"];
                            $search_check = true;
                        }
                        $sql.=$sql2;
                        if($search_check){
                            $exe = $conn->execute_query($sql,[$find,$find,$find]);
                        }
                        else{
                            $exe = $conn->execute_query($sql);
                        }
                        $user = $exe->fetch_assoc();

                        //pagination
                        $total_rows = mysqli_num_rows($exe);
                        $limit = 10;
                        $total_pages = ceil ($total_rows / $limit);

                        if(!isset($_GET["page"])){
                            $page_number = 1;
                        }
                        else $page_number=$_GET["page"];
                        $initial_page = ($page_number-1) * $limit;
                        $sqllimit = " LIMIT ".$initial_page.", ".$limit;
                        $sql.=$sqllimit;
//                        if($_SESSION["searchcheck"])
                        if($search_check) {
                            $exe1 = $conn->execute_query($sql,[$find,$find,$find]);

                        }
                        else{
                            $exe1 = $conn->execute_query($sql);

                        }
                        //fetch
                        while($user = $exe1->fetch_assoc()){
                            echo <<< TABLEUSERS
                                      <tr>
                                        <td class="info checkbox"><input type="checkbox" name="checkboxvar[]" value = "$user[id]"></td>
                                        <td class="info">$user[id]</td>
                                        <td class="info">$user[name]</td>
                                        <td class="info" >$user[warehouse]</td>
                                        <td class="info">$user[quantity]</td>
                                      </tr>
TABLEUSERS;
                        }
                        echo "</table>";
//                        //do dokończenia listy
                        for($page_number = 1; $page_number<= $total_pages; $page_number++) {
//                            $_POST["page"]=$page_number;
                            echo '<a id="page'.$page_number.'" href = "main.php?page=' . $page_number . '">' . $page_number . ' </a>';
                        }
                        $_GET["page"] = $page_number;

                        if($role_id=='3' || $role_id=='2'){
                            require_once "./admin/edit-table.php";
                            header("location:./");
                        }
                        $conn->close();
                        ?>
                </form>

                    </div>

        </div>
    </body>
</html>