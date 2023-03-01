<?php
class Crud{
    private $connection;
    //
    private string $nazev;
    private string $autor;
    private string $isbn;
    private string $anotace;
    private int $druh;
    private int $kategorie;
    private string $obal;
    private int $mnozstvi;
    private int $aktualni_mnozstvi;
    private int $dostupnost;
    //
    private string $input_nazev;
    private string $input_autor;
    private string $input_isbn;
    private string $input_anotace;
    private int $input_druh;
    private int $input_kategorie;
    private string $input_obal;
    private int $input_mnozstvi;
    private int $input_aktualni_mnozstvi;
    private int $input_dostupnost;
    //
    private string $nazev_error;
    private string $autor_error;
    private string $isbn_error;
    private string $anotace_error;
    private int $druh_error;
    private int $kategorie_error;
    private string $obal_error;
    private int $mnozstvi_error;
    private int $aktualni_mnozstvi_error;
    private int $dostupnost_error;
    //
   

    public static function Create(){
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
                $aktualni_mnozstvi_error = "Vyberte mnozstvi knihy";     
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
            if(empty($nazev_error) && empty($autor_error) && empty($isbn_error) && empty($anotace_error) && empty($druh_error) && empty($kategorie_error) && empty($obal_error) && empty($mnozstvi_error) && empty($dostupnost_error)){
                // sql insert
                $sql = "INSERT INTO `kniha` (nazev, autor, isbn, anotace, id_druh, id_kategorie, obal, mnozstvi, dostupnost) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
                if($stmt = $connection->prepare($sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("ssssiisii", $param_nazev, $param_autor, $param_isbn, $param_anotace, $param_druh, $param_kategorie, $param_obal, $param_mnozstvi, $param_dostupnost);
                    
                    // Set parameters
                    $param_nazev = $nazev;
                    $param_autor = $autor;
                    $param_isbn = $isbn;
                    $param_anotace = $anotace;
                    $param_druh = $druh;
                    $param_kategorie = $kategorie;
                    $param_obal = $obal;
                    $param_mnozstvi = $mnozstvi;
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
    }
    
}
       