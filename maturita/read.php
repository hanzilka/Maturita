<?php
require_once "config.php";
require_once(SESSION_PHP);
if(!isset($_SESSION['role']) || $_SESSION['role'] != "administrator") {
    // pokud user není admin, pošli ho na login
    header("Location: index.php");
    exit;
}
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    
    $sql = "SELECT kniha.id, kniha.nazev, kniha.autor, kniha.isbn, kniha.anotace, kniha.obal, druh.nazev AS druh, kategorie.nazev AS kategorie, 
    kniha.mnozstvi, kniha.aktualni_mnozstvi, (CASE WHEN kniha.dostupnost = 1 AND kniha.mnozstvi > 0 THEN 'Dostupné' ELSE 'Nedostupné' END) as dostupnost 
    FROM kniha
    JOIN druh ON kniha.id_druh = druh.id
    JOIN kategorie ON kniha.id_kategorie = kategorie.id 
    WHERE kniha.id = ?";
    
    if($stmt = $connection->prepare($sql)){
        $stmt->bind_param("i", $param_id);
        
        $param_id = trim($_GET["id"]);
        
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
            
            
            //
            $nazev = $row['nazev'];
            $autor = $row['autor'];
            $isbn = $row['isbn'];
            $anotace = $row['anotace'];
            $druh = $row['druh'];
            $kategorie = $row['kategorie'];
            $obal = $row['obal'];
            $mnozstvi = $row['mnozstvi'];
            $aktualni_mnozstvi = $row['aktualni_mnozstvi'];
            $dostupnost = $row['dostupnost'];
            $dalsi = $row['id'] + 1;


            } else{
                header("location: books.php");
                exit();
            }
            
        } 
    }
    $stmt->close();
    $connection->close();
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/read-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="assets/js/index.js"></script>
    <?php
    echo "<title>" . $row['nazev'] . ' - ' . $row['autor'] ."</title>"
    ?>
</head>
<body>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
<div class="read-wrap">
    <div class="main-container">
        <div class="infobox">
            <div class="infobox-informations-1"> </div>
            <div class="infobox-informations-2">
                <div class="infobox-informations-3">
                    <span class='value' style=' margin-left: 0 !important;'>
                        <a href='books.php' style='color: white;'><p style='color: white;'>Všechny knihy</p></a>
                    </span>
                </div>
            <?php 
               echo "<span class='value' style=' text-decoration: none; font-weight: 500;'>" . "<a href='index.php' style='color: white;'>"  . "<img src='pics/home.png' style='width: 24px; display: flex; align-items: center;'>" . "<p style='color: white;'></p>" . "</a></span>";
                echo "<span class='value' style='text-decoration: none; user-select: none; color: white;'>" . '>' . "</span>";
                echo "<span class='value'>" . "<form>";
                echo "<input type='hidden' name='kategorie' class='' value='" . $row['kategorie'] . "'>";
                echo "<input type='submit' class='read-input' value='" . $row['kategorie'] . "' formaction='books.php'></form></span>";
            ?>
            </div>
        </div>
        <?php
            echo '<div class="container-detail">';
                echo '<div class="bookImg">';
                    echo "<img src='pics/{$row["obal"]}' style='user-select: none' draggable='false' class='cover'>";    
                echo "</div>";
            echo "</div>";
            echo '<div class="container-detail">';
                echo '<div class="form-group">';
                    echo "<p class='read-book-name' style='text-transform: uppercase'>" . $row['nazev'] . "</p>";
                echo "</div>";
                echo '<div class="form-group">';
                    echo "<span class='name'>Autor:</span>";
                        echo "<span class='value'>" . "<form>";
                        echo "<input type='hidden' name='autor' class='' value='" . $row['autor'] . "'>";
                        echo "<input type='submit' class='read-input-detail' value='" . $row['autor'] . "' formaction='books.php'></form></span>";
                        echo "<span class='value'>" . "<form>";
                        echo "<input type='hidden' name='kategorie' class='' value='" . $row['kategorie'] . "'>";
                        echo "<input type='submit' class='read-input-detail' value='" . $row['kategorie'] . "' formaction='books.php'></form></span>";
                        echo "<span class='value' style='text-decoration: none; user-select: none;'>" . '>' . "</span>";
                        echo "<span class='value'>" . "<form>";
                        echo "<input type='hidden' name='druh' class='' value='" . $row['druh'] . "'>";
                        echo "<input type='submit' class='read-input-detail' value='" . $row['druh'] . "' formaction='books.php'></form></span>";
                echo "</div>";
                echo '<div class="form-group">';
                    echo "<p>" . $row['anotace'] . "</p>";
                echo "</div>";
                
                echo "<div class='button-group'>";
                    if($row["dostupnost"] === "Dostupné"){
                        echo '<form action="borrow.php" method="post" class="form-row">';
                        echo "<input type='hidden' name='id_kniha' value='" . $row['id'] . "'>";
                        echo '<button class="read-button">Vypůjčit</button>';
                        echo '</form>';
                    }
                    if($row["dostupnost"] === "Nedostupné"){
                        echo '<button class="read-button">Hlídat dostupnost</button>';
                    }
                echo "</div>";
            echo '</div>';
            echo '<div class="container-below">';
                    echo "<p>" . $row['dostupnost'] . "</p>";
                    echo "<p title='Počet přítomných kusů v knihovně' data-toggle='tooltip'>Dostupné: " . $row['aktualni_mnozstvi'] . "</p>";
                    echo "<p title='Celkový počet kusů v knihovně' data-toggle='tooltip'>Celkový počet: " . $row['mnozstvi'] . "</p>";
                    echo "<p>ISBN: " . $row['isbn'] . "</p>";
            echo '</div>';
           
        ?>  
    </div>
</div>
<script> 
window.addEventListener("resize", function() {
  var w = window.innerWidth;
  var h = window.innerHeight;
  console.log("Window size: " + w + " x " + h);
});
</script>
</body>
</html>