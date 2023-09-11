<?php
require_once "config.php";
require_once(SESSION_PHP);
if(!isset($_SESSION['role']) || $_SESSION['role'] != "administrator") {
    // pokud user není admin, pošli ho na login
    header("Location: index.php");
    exit;
}
$sql = "SELECT vypujcka.id, users.user as uzivatel, kniha.nazev as nazev, vypujceno FROM vypujcka
JOIN users ON vypujcka.id_uzivatel = users.id
JOIN kniha ON vypujcka.id_kniha = kniha.id";
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="assets/js/index.js"></script>
    <title>Výpůjčky</title>
</head>
<body>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
<main>
    <table>
<?php
 if($result = $connection->query($sql)){
    if($result->num_rows > 0){
        echo '<table>';
            echo "<thead>";
                echo "<tr>";
                    echo "<th title='ID' data-toggle='tooltip'>ID</th>";
                    echo "<th title='Uživatel' data-toggle='tooltip'>Uživatel</th>";
                    echo "<th title='Název knihy' data-toggle='tooltip'>Kniha</th>";
                    echo "<th title='Vypůjčeno v den a čas' data-toggle='tooltip'>Čas výpůjčky</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($row = $result->fetch_array()){
                echo "<tr>";
                    echo "<td>";
                    echo "{$row['id']}";
                    echo "</td>";
                    echo "<td>";
                    echo "{$row['uzivatel']}";
                    echo "</td>";
                    echo "<td>";
                    echo "{$row['nazev']}";
                    echo "</td>";
                    echo "<td>";
                    $date = date("d.m.Y H:i", strtotime($row['vypujceno']));
                    echo $date;
                    echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";                            
        echo "</table>";
        
        $result->free();
    } else{
        echo '<div>V databázi se nenachází žádná data</div>';
    }
} else{
    echo "Něco se pokazilo! Zkuste to za chvíli!";
}


$connection->close();
?>
</table>
</main>
</body>
</html>