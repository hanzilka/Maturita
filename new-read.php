<?php
require_once "config.php";
require_once(SESSION_PHP);
if(!isset($_SESSION['role']) || $_SESSION['role'] != "administrator") {
    // pokud user není admin, pošli ho na login
    header("Location: index.php");
    exit;
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
    <link rel="stylesheet" href="assets/css/crud-style.css">
    <link rel="stylesheet" href="assets/css/read-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="assets/js/index.js"></script>
    <title>Vytvoření nového záznamu</title>
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
                echo "<input type='submit' class='read-input' value='Vytvoření nového záznamu'></form></span>";
            ?>
            </div>
        </div>
        <?php
            echo '<div class="container-detail">';
                echo '<div class="bookImg">';
                    echo "<input type='file' class='cover' value='Vyberte obal knihy'>";    
                echo "</div>";
            echo "</div>";
            echo '<div class="container-detail">';
                echo '<div class="form-group">';
                    echo "<input type='text' class='read-book-name' style='text-transform: uppercase; margin-left: 1rem; margin-right: 1rem;' value='Název knihy'>";
                echo "</div>";
                echo '<div class="form-group">';
                    echo "<span class='name'>Autor:</span>";
                        echo "<span class='value'>";
                        echo "<input type='text' class='read-input-detail' placeholder='Autor'></span>";
                        echo "<input type='text' class='read-input-detail' placeholder='Kategorie'></span>";
                        echo "<span class='value' style='text-decoration: none; user-select: none;'></span>";
                        echo "<input type='text' class='read-input-detail' placeholder='Druh'></span>";
                echo "</div>";
                echo '<div class="form-group">';
                    echo "<textarea class='read-input-detail' style='width: 90%; max-width: 90%; margin-left: 1rem; margin-right: 1rem; text-decoration: none; border: 1px solid' placeholder='Anotace knihy'></textarea>";
                echo "</div>";
                
                echo "<div class='button-group'>";
          
                echo '<button class="read-button">Přidat</button>';
           
                echo "</div>";
            echo '</div>';
            echo '<div class="container-below">';
                    echo "<input type='number' class='create-input' placeholder='Dostupné kusy'>";
                    echo "<input type='number' class='create-input' placeholder='Celkový počet kusů'>";
                    echo "<input type='number' class='create-input' placeholder='ISBN'>";
            
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