<?php
session_start();
$user = 'root';
$wachtwoord = 'L4n9jA9a0001';
$database = 'fullstack!';
$port = NULL;
$mysqli = new mysqli('127.0.0.1', $user, $wachtwoord, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];


    $insert = $mysqli->prepare("SELECT id, wachtwoord FROM users WHERE gebruikersnaam = ?");
    $insert->bind_param("s", $gebruikersnaam);
    $insert->execute();
    $insert->bind_result($user_id, $hash);
    $insert->fetch();
    $insert->close();

    if (password_verify($wachtwoord ?? '', $hash ?? '')) {
        $_SESSION['user_id'] = $user_id;
        header("Location: index.php");
        exit();
    } else {
        echo "<p style='color: red'>Invalid gebruikersnaam or wachtwoord</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<form method="POST" action="login.php">
    <p for="gebruikersnaam">gebruikersnaam</p>
    <input type="text" id="gebruikersnaam" name="gebruikersnaam" required><br>
    <p for="wachtwoord">wachtwoord</p>
    <input type="wachtwoord" id="wachtwoord" name="wachtwoord" required><br><br>
    <button type="submit">Login</button>
</form><br>
<a href="registratie.php">Registreren</a>
</body>
</html>
