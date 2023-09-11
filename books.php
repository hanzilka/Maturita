<?php
require_once "config.php";
require_once(SESSION_PHP);
if(!isset($_SESSION['role']) || $_SESSION['role'] != "administrator") {
    // pokud user není admin, pošli ho na login
    header("Location: index.php");
    exit;
}
require_once "Class/BookList.php";
if(isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = BookList::showList($search);
} else {
    $sql = BookList::showList();
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
    <link rel="stylesheet" href="assets/css/books-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="assets/js/index.js"></script>
    <title>Seznam knih</title>
</head>
<body>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
<main>
<div class="grid-container">
<div class="grid-row">
    <div class="infobox">
        <div class="decorative-box">
            <div class="searchbox">
                <form method="get">
                    <button type="submit" name="result" class="search-button"><i class="ph-magnifying-glass" aria-hidden="true"></i></button>
                    <input type="text" class="search-input" name="search" placeholder="Co hledáte? Např. Báječná léta pod psa">
                </form>
            </div>
        </div>
    </div>
<div class="category-box">
<ul class="category-list">
    <a href="books.php"><li class="list-item"><i class="ph-book-open"></i>Vše</li></a>
    <a href="books.php"><li class="list-item"><i class="ph-books"></i>K maturitě</li></a>
</ul>
</div>

<div class="book-row">
<?php
if($result = $connection->query($sql)){
    if($result->num_rows > 0){
            while($row = $result->fetch_array()){
                    echo "<div class='book'>";
                            echo '<div class="book-cover">';
                                echo '<a href="read.php?id='. $row['id'] .'"title="Ukázat knihu" data-toggle="tooltip">';
                                echo "<img src='pics/". $row["obal"] . "' class='book-img-cover' style='user-select: none; width: 100%;' draggable='false'>";
                            echo "</div>";
                            echo "<p class='book-title'>" . $row["nazev"] . "</p>";
                            echo "<p class='book-text'>" . $row["autor"] . "</p>";
                            echo "<p class='book-text'>" . $row["kategorie"] . "</p>";
                                echo "</a>";
                                if($row["dostupnost"] === "Dostupné"){
                                    echo '<form action="borrow.php" method="post" class="reserve-form">';
                                    echo "<input type='hidden' name='id_kniha' value='" . $row['id'] . "'>";
                                    echo '<button class="button-reserve">Vypůjčit</button>';
                                    echo '</form>';
                                }
                                if($row["dostupnost"] === "Nedostupné"){
                                    echo '<button class="button-reserve unavailable">Hlídat dostupnost</button>';
                                }
                    echo "</div>";
            }
            
        
        $result->free();
    } else{
        echo '<div>Tohle zde bohužel asi není.</div>';
        }
        } else{
        echo "Něco se pokazilo! Zkuste to za chvíli!";
        }
        $connection->close();


?>
</div>
</div>
</div>
</main>
</body>
</html>