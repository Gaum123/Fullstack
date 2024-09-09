<?php
$user = 'root';
$password = 'L4n9jA9a0001';
$database = 'fullstack!';
$port = null;
$mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);


$query = $mysqli->query("SELECT * FROM bungalow");
while ($row = $query->fetch_assoc()) {
    $naam = $row['naam'];
    $prijs = $row['prijs'];
    $type_id = $row['type_id'];
    $voorzieningIds = json_decode($row['voorziening_id']);

    $insert = $mysqli->prepare("SELECT type FROM type WHERE id = ?");
    $insert->bind_param("i", $type_id);
    $insert->execute();
    $insert->bind_result($type);
    $insert->fetch();
    $insert->close();

    $voorzieningNames = [];
    foreach ($voorzieningIds as $id) {
        $insert = $mysqli->prepare("SELECT voorziening FROM voorziening WHERE id = ?");
        $insert->bind_param("i", $id);
        $insert->execute();
        $insert->bind_result($voorzieningName);
        while ($insert->fetch()) {
            $voorzieningNames[] = $voorzieningName;
        }
        $insert->close();
    }

    $voorzieningen = implode(", ", $voorzieningNames);
    if (isset($_SESSION['user_id'])) {
        echo "<p>Bungalow: $naam, Prijs: €$prijs,- Type: $type, Voorzieningen: $voorzieningen</p><br>";
    }

}
if (isset($_SESSION['user_id'])) {
    echo "
        <form method='GET' action='admin.php'>
        <button>Admin</button>
        </form>";
}

$mysqli->close();