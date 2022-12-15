<?php

require_once 'dataConfig.php';

$sender_id = $_GET['sender_id'];
$receiver_id = $_GET['receiver_id'];

$sql = "SELECT * FROM messages WHERE (sender_id = '$sender_id' AND receiver_id = '$receiver_id') OR (sender_id = '$receiver_id' AND receiver_id = '$sender_id') ORDER BY id ASC";

$result = mysqli_query($mysqli, $sql);

if ($result) {
    $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode([
        'status' => 'success',
        'messages' => $messages
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Message non envoyé'
    ]);
}