<?php
class BookList {
    public static function showList($search = "") {
        $sql = "SELECT kniha.id, kniha.nazev, kniha.autor, kniha.isbn, kniha.anotace, kniha.obal, druh.nazev AS druh, kategorie.nazev AS kategorie, 
        kniha.mnozstvi, kniha.aktualni_mnozstvi, (CASE WHEN kniha.dostupnost = 1 AND kniha.mnozstvi > 0 THEN 'Dostupné' ELSE 'Nedostupné' END) AS dostupnost 
        FROM kniha
        JOIN druh ON kniha.id_druh = druh.id
        JOIN kategorie ON kniha.id_kategorie = kategorie.id ";
        $where = array();
        if (isset($_GET['search'])) {
            $search = $_GET['search'];
            $where[] = "(kniha.nazev LIKE '%$search%' OR kniha.autor LIKE '%$search%' OR kniha.isbn LIKE '%$search%' OR kniha.anotace LIKE '%$search%' OR dostupnost LIKE '%$search%' OR druh.nazev LIKE '%$search%' OR kategorie.nazev LIKE '%$search%')";
        }
        if (isset($_GET['kategorie'])) {
            $kategorie = $_GET['kategorie'];
            $where[] = "kategorie.nazev = '$kategorie'";
        }
        if (isset($_GET['druh'])) {
            $druh = $_GET['druh'];
            $where[] = "druh.nazev = '$druh'";
        }
        if (isset($_GET['autor'])) {
            $autor = $_GET['autor'];
            $where[] = "autor = '$autor'";
        }
        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY dostupnost ASC, kniha.autor ASC, kniha.nazev ASC";
        return $sql;
    }
    public static function update(){
      $update = "UPDATE kniha SET dostupnost = 1 WHERE aktualni_mnozstvi > 0";
      header("location: books.php");
    }
   
}
