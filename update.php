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
$nazev = $autor = $isbn = $anotace = $druh = $kategorie = $mnozstvi = $aktualni_mnozstvi = $dostupnost = ""; //9
$nazev_error = $autor_error  = $isbn_error  = $anotace_error  = $druh_error  = $kategorie_error  = $mnozstvi_error = $aktualni_mnozstvi_error = $dostupnost_error  = "";

 
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && $_POST["id"]){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
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

 

    $input_mnozstvi = trim($_POST["mnozstvi"]);
    if(empty($input_mnozstvi)){
        $mnozstvi_error = "Vyberte mnozstvi knihy";     
    } else{
        $mnozstvi = $input_mnozstvi;
    }

    $input_aktualni_mnozstvi = trim($_POST["aktualni_mnozstvi"]);
    if(empty($input_aktualni_mnozstvi)){
        $aktualni_mnozstvi_error = "Vyberte mnozstvi knihy";     
    } else{
        $aktualni_mnozstvi = $input_aktualni_mnozstvi;
    }

    $input_dostupnost = trim($_POST["dostupnost"]);
    if(empty($input_dostupnost)){
        $dostupnost_error = "Vyberte dostupnost knihy";     
    } else{
        $dostupnost = $input_dostupnost;
    }  
    // Check input errors before inserting in database
    if(empty($nazev_error) && empty($autor_error) && empty($isbn_error) && empty($anotace_error) && empty($druh_error) && empty($kategorie_error) && empty($mnozstvi_error) && empty($dostupnost_error)){
  
        $sql = "UPDATE `kniha` SET nazev=?, autor=?, isbn=?, anotace=?, id_druh=?, id_kategorie=?, mnozstvi=?, aktualni_mnozstvi=?, dostupnost=? WHERE id=?";
 
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssssiiiiii", $param_nazev, $param_autor, $param_isbn, $param_anotace, $param_druh, $param_kategorie, $param_mnozstvi, $param_aktualni_mnozstvi, $param_dostupnost, $param_id);
            
            // Set parameters
            $param_nazev = $nazev;
            $param_autor = $autor;
            $param_isbn = $isbn;
            $param_anotace = $anotace;
            $param_druh = $druh;
            $param_kategorie = $kategorie;
            /* $param_obal = $obal; */
            $param_mnozstvi = $mnozstvi;
            $param_aktualni_mnozstvi = $aktualni_mnozstvi;
            $param_dostupnost = $dostupnost;
            $param_id = $id;

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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM `kniha` WHERE id = ?";
        if($stmt = $connection->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $nazev = $row['nazev'];
                    $autor = $row['autor'];
                    $isbn = $row['isbn'];
                    $anotace = $row['anotace'];
                    $druh = $row['id_druh'];
                    $kategorie = $row['id_kategorie'];
                    /* $obal = $row['obal']; */
                    $mnozstvi = $row['mnozstvi'];
                    $aktualni_mnozstvi = $row['aktualni_mnozstvi'];
                    $dostupnost = $row['dostupnost'];
                    //
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: books.php");
                    exit();
                }
                
            } else{
                echo "Něco se pokazilo! Zkuste to prosím znovu!";
            }
        }
        
        // Close statement
        $stmt->close();
        
        // Close connection
        $connection->close();
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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
     <?php
    echo "<title>Upravit</title>"
    ?>
</head>
<body>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
<div class="wrap">
        <div class="contain">
        
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                    <textarea type="text" name="anotace" class="form-input <?php echo (!empty($anotace_error)) ? 'is-invalid' : ''; ?>"><?php echo $anotace; ?></textarea>
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
                <div class="form-group" style="display: none;">
                    <input type="checkbox" id="edit_cover" name="edit_cover">
                    <label for="edit_cover">Nahrát nový obal knihy?</label>
                    <input type="file" id="obal" name="obal" accept="image/jpg" style="display: none;" class="form-input <?php echo (!empty($obal_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $row; ?>" onchange="this.nextElementSibling.innerHTML = this.files[0].name" disabled/>
                    <span class="invalid-feedback"><?php echo $obal_error;?></span>
                    <span class="file-name"></span>
                </div>
                <div class="form-group">
                    <label>Množství</label>
                    <input type="number" name="mnozstvi" class="form-input <?php echo (!empty($mnozstvi_error)) ? 'is-invalid' : ''; ?>" value="<?php echo $mnozstvi; ?>">
                    <span class="invalid-feedback"><?php echo $mnozstvi_error;?></span>
                </div>
                <div class="form-group">
                    <label>Aktuální nožství</label>
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
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="form-button" value="Přidat">
                </div>
            </form>       
        </div>
    </div>
<script src="assets/js/index.js"></script>
<script src="assets/js/crud.js"></script>
</body>
</html>