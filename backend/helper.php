<?php 
function generateToken($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function get_user($email, $token)
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "chat";
    $porthost = "3306";
$mysqli = new mysqli($host, $user, $pass,$db, $porthost);
    
    $sql = "SELECT * FROM users WHERE email = '$email' AND token='$token'";
    $result = mysqli_query($mysqli, $sql);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        return $user;
    } else {
        return false;
    }


    
}