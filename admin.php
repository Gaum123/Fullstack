<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fullstack</title>
    <style>
        body {
            font-family: Arial;
        }
        input {
            height: 20px;
        }
        select{
            height: 20px;
            width: 177px
        }
    </style>
</head>
<body>
<form method="GET" action="logout.php">
    <button type="submit">Log uit</button>
</form>
<p>Voer type in</p>
<form method="post" action="submit.php">
    <input type="text" name="type" placeholder="Type" required><br><br>
    <button type="submit">Submit</button>
</form>

<p>Voer voorziening in</p>
<form method="post" action="submit.php">
    <input type="text" name="voorziening" placeholder="Voorziening" required><br><br>
    <button type="submit">Submit</button>
</form>

<p>Voer Bungalow in</p>
<form method="post" action="submit.php">
    <select name="typeb">
        <option>Type</option>
        <?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
        $user = 'root';
        $password = 'L4n9jA9a0001';
        $database = 'fullstack!';
        $port = NULL;
        $mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);
        $query = $mysqli->query("SELECT * FROM type");

        foreach($query as $row){
            echo '<option>'.$row['type'];
        }
        ?>
    </select><br><br>
    <input type="text" name="naam" placeholder="naam" required><br><br>
    <input type="text" name="prijs" placeholder="prijs" required><br><br>
        <?php
        $user = 'root';
        $password = 'L4n9jA9a0001';
        $database = 'fullstack!';
        $port = NULL;
        $mysqli = new mysqli('127.0.0.1', $user, $password, $database, $port);
        $query = $mysqli->query("SELECT * FROM voorziening");

        foreach($query as $row){

            echo '<input name="voorzieningb[]" type="checkbox" value="'.$row['voorziening'].'">'.$row['voorziening'].'<br>';
        }
        ?>
    <button type="submit">Submit</button>
</form>
<br><br>
</body>
</html>