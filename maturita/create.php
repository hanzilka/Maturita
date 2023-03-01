<?php
// config
require_once "config.php";
require_once(SESSION_PHP);
if(!isset($_SESSION['role']) || $_SESSION['role'] != "administrator") {
    // pokud user není admin, pošli ho na login
    header("Location: index.php");
    exit;
}
// Definování proměnných a přiřazení prázdných hodnot
$nazev = $autor = $isbn = $anotace = $druh = $kategorie = $obal = $mnozstvi = $aktualni_mnozstvi = $dostupnost = ""; //9
$nazev_error = $autor_error  = $isbn_error  = $anotace_error  = $druh_error  = $kategorie_error  = $obal_error  = $mnozstvi_error = $aktualni_mnozstvi_error = $dostupnost_error  = "";
 
// Spracovávání dat po odeslání formuláře
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Ověření jména a další dat...
    $input_nazev = trim($_POST["nazev"]);
    if(empty($input_nazev)){
        $nazev_error = "Zadejte název knihy";     
    } else{
        $nazev = $input_nazev;
    }

    $input_autor = trim($_POST["autor"]);
    if(empty($input_autor)){
        $autor_error = "Zadejte jméno autora";     
    } else{
        $autor = $input_autor;
    }

    $input_isbn = trim($_POST["isbn"]);
    if(empty($input_isbn)){
        $isbn_error = "Zadejte ISBN či obdobné označení knihy";     
    } else{
        $isbn = $input_isbn;
    }

    $input_anotace = trim($_POST["anotace"]);
    if(empty($input_anotace)){
        $anotace_error = "Zadejte anotaci knihy";     
    } else{
        $anotace = $input_anotace;
    }

    $input_druh = trim($_POST["druh"]);
    if(empty($input_druh)){
        $druh_error = "Zadejte anotaci knihy";     
    } else{
        $druh = $input_druh;
    }

    $input_kategorie = trim($_POST["kategorie"]);
    if(empty($input_kategorie)){
        $kategorie_error = "Vyberte kategorii knihy";     
    } else{
        $kategorie = $input_kategorie;
    }

    $input_obal = trim($_POST["obal"]);
    if(empty($input_obal)){
        $obal_error = "Vyberte obal knihy";     
    } else{
        $obal = $input_obal;
    }

    $input_mnozstvi = trim($_POST["mnozstvi"]);
    if(empty($input_mnozstvi)){
        $mnozstvi_error = "Vyberte mnozstvi knihy";     
    } else{
        $mnozstvi = $input_mnozstvi;
    }

    $input_aktualni_mnozstvi = trim($_POST["aktualni_mnozstvi"]);
    if(empty($input_aktualni_mnozstvi)){
        $aktualni_mnozstvi_error = "Vyberte aktualni mnozstvi knihy";     
    } else{
        $aktualni_mnozstvi = $input_aktualni_mnozstvi;
    }

    $input_dostupnost = trim($_POST["dostupnost"]);
    if(!($input_dostupnost == '1' || $input_dostupnost == '0')){
        $dostupnost_error = "Vyberte dostupnost knihy";     
    } else{
        $dostupnost = $input_dostupnost;
    }
    
    // kontrola chyb
    if(empty($nazev_error) && empty($autor_error) && empty($isbn_error) && empty($anotace_error) && empty($druh_error) && empty($kategorie_error) && empty($obal_error) && empty($mnozstvi_error) && empty($aktualni_mnozstvi_error) && empty($dostupnost_error)){
        // sql insert
        $sql = "INSERT INTO `kniha` (nazev, autor, isbn, anotace, id_druh, id_kategorie, obal, mnozstvi, aktualni_mnozstvi, dostupnost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
 
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssiisiii", $param_nazev, $param_autor, $param_isbn, $param_anotace, $param_druh, $param_kategorie, $param_obal, $param_mnozstvi, $param_aktualni_mnozstvi, $param_dostupnost);
            
            // Set parameters
            $param_nazev = $nazev;
            $param_autor = $autor;
            $param_isbn = $isbn;
            $param_anotace = $anotace;
            $param_druh = $druh;
            $param_kategorie = $kategorie;
            $param_obal = $obal;
            $param_mnozstvi = $mnozstvi;
            $param_aktualni_mnozstvi = $aktualni_mnozstvi;
            $param_dostupnost = $dostupnost;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Něco se pokazilo. Obnovte stránku a zkuste to znova.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $connection->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
    <title>Nová kniha</title>
</head>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
<body>
    <div class="wrap">
        <div class="contain bg">
            <h2>Přidat knihu</h2>
            <p>Vyplntě prosím všechna možná pole pro přidání</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Název knihy</label>
                    <input type="text" name="nazev" class="form-input <?php echo (!empty($nazev_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $nazev; ?>">
                    <span class="invalid-feedback"><?php echo $nazev_error;?></span>
                </div>
                <div class="form-group">
                    <label>Autor</label>
                    <input type="text" name="autor" class="form-input <?php echo (!empty($autor_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $autor; ?>">
                    <span class="invalid-feedback"><?php echo $autor_error;?></span>
                </div>
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" class="form-input <?php echo (!empty($isbn_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $isbn; ?>">
                    <span class="invalid-feedback"><?php echo $isbn_error;?></span>
                </div>
                <div class="form-group">
                    <label>Anotace</label>
                    <textarea type="text" name="anotace" class="form-input <?php echo (!empty($anotace_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $anotace; ?>"></textarea>
                    <span class="invalid-feedback"><?php echo $anotace_error;?></span>
                </div>
                <div class="form-group">
                <label for="kategorie" class="form-label">Žánr knihy</label>
                <select name="druh" class="form-input">
                    <option value='1' <?php echo ($druh == '1') ? 'selected' : ''; ?>>poezie</option>
                    <option value='2' <?php echo ($druh == '2') ? 'selected' : ''; ?>>drama</option>
                    <option value='3' <?php echo ($druh == '3') ? 'selected' : ''; ?>>próza</option>
                </select>
                </div>
                <div class="form-group">
                <label for="kategorie" class="form-label">Kategorie knihy</label>
                <select name="kategorie" class="form-input">
                    <option value='1' <?php echo ($kategorie == '1') ? 'selected' : ''; ?>>Světová literatura do konce 18. století</option>
                    <option value='2' <?php echo ($kategorie == '2') ? 'selected' : ''; ?>>Česká literatura do konce 18. století</option>
                    <option value='3' <?php echo ($kategorie == '3') ? 'selected' : ''; ?>>Světová literatura do konce 19. století</option>
                    <option value='4' <?php echo ($kategorie == '4') ? 'selected' : ''; ?>>Česká literatura do konce 19. století</option>
                    <option value='5' <?php echo ($kategorie == '5') ? 'selected' : ''; ?>>Světová literatura 20. a 21. století</option>
                    <option value='6' <?php echo ($kategorie == '6') ? 'selected' : ''; ?>>Česká literatura 20. a 21. století</option>
                </select>
                </div>
                <div class="form-group">
                    <label for="obal">Obal</label>
                    <input type="file" name="obal" class="form-input <?php echo (!empty($obal_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $obal; ?>" onchange="this.nextElementSibling.innerHTML = this.files[0].name">
                    <span class="invalid-feedback"><?php echo $obal_error;?></span>
                    <span class="file-name"></span>
                </div>
                <div class="form-group">
                    <label>Množství</label>
                    <input type="number" name="mnozstvi" min="1" max="10" class="form-input <?php echo (!empty($mnozstvi_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $mnozstvi; ?>">
                    <span class="invalid-feedback"><?php echo $mnozstvi_error;?></span>
                </div>
                <div class="form-group">
                    <label>Aktuální množství</label>
                    <input type="number" name="aktualni_mnozstvi" class="form-input <?php echo (!empty($aktualni_mnozstvi_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $aktualni_mnozstvi; ?>">
                    <span class="invalid-feedback"><?php echo $aktualni_mnozstvi_error;?></span>
                </div>
                <div class="form-group">
                <label for="dostupnost" class="form-label">Dostupnost</label>
                <select name="dostupnost" class="form-input">
                    <option value='1' <?php echo ($dostupnost == '1') ? 'selected' : ''; ?>>Dostupné</option>
                    <option value='0' <?php echo ($dostupnost == '0') ? 'selected' : ''; ?>>Nedostupné</option>
                </select>
                </div>
                <div class="form-group button-group">
                    <input type="submit" class="form-button" value="Přidat">
                </div>
            </form>
        </div>
    </div>
<script>
document.getElementById("file").onchange = function() {
document.getElementById("file-label").innerHTML = this.files[0].name;
};
</script>
</body>
</html>