<?php
require_once "config.php";
require_once(SESSION_PHP);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/crud.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="assets/js/index.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
    <title>Správa</title>
</head>
<body>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
<main>
<div class="container">
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-knihy-tab" data-bs-toggle="tab" data-bs-target="#nav-knihy" type="button" role="tab" aria-controls="nav-knihy" aria-selected="true">Správa knih</button>
        <button class="nav-link" id="nah-vypujcky-tab" data-bs-toggle="tab" data-bs-target="#nav-vypujcky" type="button" role="tab" aria-controls="nav-vypujcky" aria-selected="false">Správa výpůjček</button>
        <button class="nav-link" id="nav-uzivatele-tab" data-bs-toggle="tab" data-bs-target="#nav-uzivatele" type="button" role="tab" aria-controls="nav-uzivatele" aria-selected="false">Správa uživatelů</button>
        <button class="nav-link" id="nav-prispevky-tab" data-bs-toggle="tab" data-bs-target="#nav-prispevky" type="button" role="tab" aria-controls="nav-prispevky" aria-selected="false">Správa příspěvků</button>
    </div>
</nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-knihy" role="tabpanel" aria-labelledby="nav-knihy-tab">Knihy</div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-knihy-tab" data-bs-toggle="tab" data-bs-target="#nav-knihy" type="button" role="tab" aria-controls="nav-knihy" aria-selected="true">Správa knih</button>
                    <button class="nav-link" id="nah-vypujcky-tab" data-bs-toggle="tab" data-bs-target="#nav-vypujcky" type="button" role="tab" aria-controls="nav-vypujcky" aria-selected="false">Správa výpůjček</button>
                    <button class="nav-link" id="nav-uzivatele-tab" data-bs-toggle="tab" data-bs-target="#nav-uzivatele" type="button" role="tab" aria-controls="nav-uzivatele" aria-selected="false">Správa uživatelů</button>
                    <button class="nav-link" id="nav-prispevky-tab" data-bs-toggle="tab" data-bs-target="#nav-prispevky" type="button" role="tab" aria-controls="nav-prispevky" aria-selected="false">Správa příspěvků</button>
                </div>
            </nav>
        <div class="tab-pane fade" id="nav-vypujcky" role="tabpanel" aria-labelledby="nah-vypujcky-tab">Výpůjčky</div>
        <div class="tab-pane fade" id="nav-uzivatele" role="tabpanel" aria-labelledby="nav-uzivatele-tab">Uživatelé</div>
        <div class="tab-pane fade" id="nav-prispevky" role="tabpanel" aria-labelledby="nav-prispevky-tab">Příspěvky</div>
    </div>
</div>
</main>
</body>
</html>
