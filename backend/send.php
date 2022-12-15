<?php

require_once 'dataConfig.php';

$message = $_POST['message'];
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];

$sql = "INSERT INTO messages (message, sender_id, receiver_id) VALUES ('$message', '$sender_id', '$receiver_id')";
$result = mysqli_query($mysqli, $sql);

if ($result) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Message envoyé avec succès'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Message non envoyé'
    ]);
}








