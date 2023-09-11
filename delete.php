<?php
require_once "config.php";
require_once(SESSION_PHP);
if(!isset($_SESSION['role']) || $_SESSION['role'] != "administrator") {
    // pokud user není admin, pošli ho na login
    header("Location: index.php");
    exit;
}
if(isset($_POST["id"]) && !empty($_POST["id"])){

    $sql = "DELETE FROM `kniha` WHERE id = ?";
    
    if($stmt = $connection->prepare($sql)){
        $stmt->bind_param("i", $param_id);
        $param_id = trim($_POST["id"]);
        if($stmt->execute()){
            header("location: books.php");
            exit();
        } else{
            echo "Něco se pokazilo. Zkuste to prosím znovu.";
        }
    }
    $stmt->close();
    $connection->close();
} else{
    if(empty(trim($_GET["id"]))){
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="assets/js/index.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
    <title>Smazat knihu</title>
</head>
<body>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
    <div class="wrap">
        <div class="contain">
            <h2>Smazat knihu</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                <p>Opravdu chcete smazat tuto knihu?</p>
                <div class="form-group button-group" id="update-buttons-group">
                    <input type="submit" value="ANO" class="form-button">
                    <a href="books.php" class="form-button" id="input-a">NE</a>
                </div>
            </form>        
        </div>
    </div>
</body>
</html>