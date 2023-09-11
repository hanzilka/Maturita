<?php
require_once "config.php";
require_once(SESSION_PHP);
//
if (!empty($_POST['id_kniha'])) {
$bookId = (int) $_POST['id_kniha'];
$userId = (int) $_SESSION['user_id'];

// Check if the book is still available
$query = "SELECT dostupnost, aktualni_mnozstvi FROM kniha WHERE kniha.id = $bookId";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
if ($row['dostupnost'] == 0 || $row['aktualni_mnozstvi'] == 0) {
    // Book is not available
    echo 'Error. Kniha je nedostupná';
    } else {
    // Update the "kniha" table
    $query = "UPDATE kniha SET aktualni_mnozstvi = aktualni_mnozstvi - 1, dostupnost = IF(aktualni_mnozstvi = 0, 0, dostupnost) WHERE kniha.id = $bookId";
    $result = mysqli_query($connection, $query);// Insert a new row in the "vypujcka" table
    $query = "INSERT INTO vypujcka (id_uzivatel, id_kniha, vypujceno) VALUES ($userId, $bookId, NOW())";
    $result = mysqli_query($connection, $query);
    
    if ($result) {
        header("Location: index.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
}

}
else{
    header("Location: index.php");
    exit;
    
}

?>