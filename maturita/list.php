<?php
require_once "config.php";
require_once(SESSION_PHP);

require_once "Class/BookList.php";
$sql = BookList::showList();
$count = "SELECT COUNT(*) AS count FROM kniha";
if ($result = $connection->query($count)) {
    $row = $result->fetch_assoc();
    $count = $row['count'];
} else {
    $count = 0;
}
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
    <title>CRUD</title>
</head>
<body>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
<main>
<p>Počet knih v databázi: <?php echo $count; ?></p>

<div class="card-contain">
<div class="card-row">

<?php

if($result = $connection->query($sql)){
    if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                    echo "<div class='card'>";
                        echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>" . $row["nazev"] . "</h5>";
                            echo '<div class="card-cover">';
                                echo '<a href="read.php?id='. $row['id'] .'"title="Ukázat knihu" data-toggle="tooltip">';
                                echo "<img src='pics/{$row["obal"]}' class='card-image' style='user-select: none; width: 100%;' draggable='false'>";
                            echo "</div>";
                            echo "<p class='card-text'>" . $row["autor"] . "</p>";
                            echo "</a>";
                        echo "</div>";  
                        if (isset($_SESSION['logged_in']) && $_SESSION['role'] == "administrator"){
                        echo "<div class='card-button'>";
                        echo '<a href="read.php?id='. $row['id'] .'"title="Ukázat knihu" data-toggle="tooltip"><i class="ph-eye"></i></a>';
                        echo '<a href="update.php?id='. $row['id'] .'"title="Upravit knihu" data-toggle="tooltip"><i class="ph-pencil-fill"></i></span></a>';
                        echo '<a href="delete.php?id='. $row['id'] .'" title="Smazat knihu" data-toggle="tooltip"><i class="ph-trash-fill"></i></a>';
                        
                    echo "</div>";
                }
                    echo "</div>";
                    
            }
            
        
        $result->free();
    } else{
        echo '<div>V databázi se nenachází žádná data</div>';
        }
        } else{
        echo "Něco se pokazilo! Zkuste to za chvíli!";
        }
        $connection->close();


?>
</div>
</div>
</main>
</body>
</html>