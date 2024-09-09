<?php
$user = 'root';
$password = 'L4n9jA9a0001';
$database = 'fullstack!';
$port = NULL;
$mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['type']) && !empty($_POST['type'])) {
        $type = $_POST['type'];

        $insert = $mysqli->prepare("INSERT INTO type (type) VALUES (?)");
        $insert->bind_param("s", $type);

        if ($insert->execute()) {
            echo "<p>Type opgeslagen!</p>";
        } else {
            echo "<p>Error: " . $insert->error . "</p>";
        }

        $insert->close();
    }

    if (isset($_POST['voorziening']) && !empty($_POST['voorziening'])) {
        $voorziening = $_POST['voorziening'];

        $insert = $mysqli->prepare("INSERT INTO voorziening (voorziening) VALUES (?)");
        $insert->bind_param("s", $voorziening);

        if ($insert->execute()) {
            echo "<p>Voorziening opgeslagen!</p>";
        } else {
            echo "<p>Error: " . $insert->error . "</p>";
        }

        $insert->close();
    }

    if (isset($_POST['typeb']) && !empty($_POST['typeb'])) {

        if (isset($_POST['naam']) && !empty($_POST['naam'])) {
            if (isset($_POST['prijs']) && !empty($_POST['prijs'])) {
                $typeb = $_POST['typeb'];
                $naam = $_POST['naam'];
                $prijs = $_POST['prijs'];
                $voorzieningb = $_POST['voorzieningb'];


                $voorzieningIds = [];
                foreach ($voorzieningb as $voorzieningName) {
                    $insert = $mysqli->prepare("SELECT id FROM voorziening WHERE voorziening = ?");
                    $insert->bind_param("s", $voorzieningName);
                    $insert->execute();
                    $insert->bind_result($id);
                    while ($insert->fetch()) {
                        $voorzieningIds[] = $id;
                    }
                    $insert->close();
                }

                $voorzieningIdsJson = json_encode($voorzieningIds);


                $insert = $mysqli->prepare("SELECT id FROM type WHERE type = ?");
                $insert->bind_param("s", $typeb);
                $insert->execute();
                $insert->bind_result($type_id);
                $insert->fetch();
                $insert->close();


                $insert = $mysqli->prepare("INSERT INTO bungalow (type_id, naam, prijs, voorziening_id) VALUES (?, ?, ?, ?)");
                $insert->bind_param("isds", $type_id, $naam, $prijs, $voorzieningIdsJson);

                if ($insert->execute()) {
                    echo "<p>Bungalow Opgeslagen!</p>";
                } else {
                    echo "<p>Error: " . $insert->error . "</p>";
                }

                $insert->close();
            }
        }
    }
}

$mysqli->close();
