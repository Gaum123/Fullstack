<?php
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
    $wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);

    $insert = $mysqli->prepare("INSERT INTO users (gebruikersnaam, wachtwoord) VALUES (?, ?)");
    $insert->bind_param("ss", $gebruikersnaam, $wachtwoord);

    if ($insert->execute()) {
        echo "<p>Gebruiker geregistreerd!</p>";
    } else {
        echo "<p>Error: " . $insert->error . "</p>";
    }

    $insert->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>
<form method="POST" action="">
    <p for="gebruikersnaam">gebruikersnaam</p>
    <input type="text" id="gebruikersnaam" name="gebruikersnaam" required><br>
    <p for="wachtwoord">wachtwoord</p>
    <input type="wachtwoord" id="wachtwoord" name="wachtwoord" required><br><br>
    <button type="submit">Registreer</button>
</form><br>
<a href="login.php">Ga naar login</a>
</body>
</html>
