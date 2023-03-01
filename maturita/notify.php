<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include "assets/php/connection.php";
$query = "SELECT * FROM kniha WHERE dostupnost = '0'";
$result = $connection->query($query);
while ($row = $result->fetch_assoc()) {
    $query = "SELECT * FROM kniha WHERE id = '".$row['id']."'";
    $result2 = $connection->query($query);
    $row2 = $result2->fetch_assoc();
    if($row2['dostupnost'] == "1"){
        $to = "hachikolp@gmail.com";
        $subject = "Dostupnost knihy se změnila";
        $message = "Vážený/á ".$row2['autor'].",\n\nDostupnost knihy '".$row2['nazev']."' se změnila na Dostupné.\n\nS pozdravem,\nKnihovna SPŠO";
        $headers = "From: michja@ms.spsostrov.cz" . "\r\n";
        mail($to,$subject,$message,$headers);
        
    }
}

?>