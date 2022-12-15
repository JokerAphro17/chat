<?php 

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "chat";
$porthost = "3306";

global $mysqli;
$mysqli = new mysqli($host, $user, $pass,"", $porthost);



if ($mysqli->connect_errno) {
    echo "Erreur de connexion: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


$sql = "CREATE DATABASE IF NOT EXISTS chat";

if (!$mysqli->query($sql) === TRUE) {
    echo "Erreur de cration de la db: " . $mysqli->error;
}


$mysqli->select_db($db);




$sql1 = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$sql2 = "CREATE TABLE IF NOT EXISTS messages (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255) NOT NULL,
    sender_id INT(11) UNSIGNED NOT NULL,
    receiver_id INT(11) UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
    )";

if (!$mysqli->query($sql1) === TRUE) {
    
    echo "Erreur de cration de la db: " . $mysqli->error;
}
if (!$mysqli->query($sql2) === TRUE) {

    echo "Erreur de cration de la db: " . $mysqli->error;
}

function connect()
{
    global $mysqli;
    return $mysqli;
}

?>



