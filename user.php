<?php
require_once "config.php";
require_once(SESSION_PHP);

$user = $_SESSION['user'];

$sql = "SELECT users.user, users.password, users.email, role.role AS pravomoce FROM users JOIN role ON users.id_role = role.id WHERE user = ?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row) {
    $user = $row['user'];
    $password = $row['password'];
    $email = $row['email'];
    $id_role = $row['pravomoce'];
  }

$vypujcka = "SELECT vypujcka.id, users.user as uzivatel, kniha.nazev as nazev, kniha.autor as autor, vypujceno FROM vypujcka
JOIN users ON vypujcka.id_uzivatel = users.id
JOIN kniha ON vypujcka.id_kniha = kniha.id
WHERE users.id = '" . $_SESSION['user_id'] . "'";


?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/profile-style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/phosphor-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="assets/js/index.js"></script>
    <?php
    echo "<title>" . $row['user'] . "</title>"
    ?>
</head>
<body>
<header>
<nav class="navbar">
<?php include 'assets/php/navbar.php'; ?>
</nav>
</header>
<main>
<div class="container">
  <div class="profile-information">
    <table style="padding: 0; margin: 0;">
    <tr>
      <td>Uživatelské jméno</td>
      <td><?php echo $user; ?></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><?php echo $email; ?></td>
    </tr>
    <tr>
      <td>Role</td>
      <td><?php echo $id_role; ?></td>
    </tr>
    </table>
  </div>
  <div class="profile-borrowings">
  <?php
  if($result = $connection->query($vypujcka)){
    if($result->num_rows > 0){
        echo '<table>';
            echo "<thead>";
                echo "<tr>";
                    echo "<th title='Název knihy' data-toggle='tooltip'>Kniha</th>";
                    echo "<th title='Autor' data-toggle='tooltip'>Autor</th>";
                    echo "<th title='Vypůjčeno v den a čas' data-toggle='tooltip'>Čas výpůjčky</th>";
                    echo "<th title='Vratka' data-toggle='tooltip'>Čas vrácení</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($row = $result->fetch_array()){
                echo "<tr>";
                    echo "<td>";
                    echo "{$row['nazev']}";
                    echo "</td>";
                    echo "<td>";
                    echo "{$row['autor']}";
                    echo "</td>";
                    echo "<td>";
                    $date = date("d.m.Y H:i", strtotime($row['vypujceno']));
                    echo $date;
                    echo "</td>";
                    $borrowed_time = $row['vypujceno'];
                    $returnal_day = date("d.m.Y H:i", strtotime($borrowed_time . " + 30 days"));
                    echo "<td>" . $returnal_day . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";                            
        echo "</table>";
        
        $result->free();
    }
  } else{
    echo "Něco se pokazilo! Zkuste to za chvíli!";
  }
  ?>
  </div>
</div>
</main>
</body>
</html>