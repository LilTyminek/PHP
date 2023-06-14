<?php
echo<<<BUTTONS
            <div class="add-item">
                <form method="post">
                </br>
                    <input type="submit" value="Dodaj przedmiot" name="add">
                    <input type="submit" value="Zaaktualizuj" name="change">
<!--                    <input type="submit" value="Przenieś">-->
                    <input type="submit" value="Usuń zaznaczone przedmioty" name="delete">
                </form>
BUTTONS;

require_once "../../scripts/connect.php";
if(isset($_POST["add"])){
//                    zapobieganie pustym rekordom
    echo <<<ADDRECORD
                        <form method="post" action="../../scripts/add-record.php">
                        <p>Dodaj przedmiot</p>
                            <input type="text" name="EAN" placeholder="Podaj EAN" autofocus required></br>
                            <input type="text" name="name" placeholder="Podaj nazwe przedmiotu"></br>
                            <input type="text" name="warehouse" placeholder="Podaj magazyn"></br>
                            <input type="number" name="qua" placeholder="Podaj ilosc"></br>
                            <input type="submit" name="addsub">
</form>
ADDRECORD;
    echo "sdasd";
exit();
}
else if(isset($_POST["change"])){
//                    puste rekordy mozliwe tam gdzie "?"
    echo <<<CHANGERECORD
                    <form action="../../scripts/change-record.php" method="post" >
                    <p>Zaaktualizuj przedmiot</p>
                        <input placeholder="Podaj EAN" name="EAN" type="text" autofocus required></br>
                        <input placeholder="Podaj nazwe?" name="name" type="text"></br>
                        <input placeholder="Podaj magazyn?" name="warehouse" type="text"></br>
                        <input type="number" name="qua" placeholder="Podaj ilosc"></br>
                        <input type="submit" name="changesub">
</form>
CHANGERECORD;

}
else if(isset($_POST["delete"])){
    require_once ("../../scripts/delete-record.php");
}
$conn->close();
echo<<<ENDBUTTONS
</div>
ENDBUTTONS;
exit();