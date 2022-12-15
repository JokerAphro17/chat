<?php

require_once "backend/dataConfig.php";
require_once 'backend/helper.php';

session_start();





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = md5($_POST['password']);
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($mysqli, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        session_start();
        $_SESSION['token'] = $user['token'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        header('location: index.php');
    } else {
        $message = "Email ou mot de passe incorrect";
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title></title>
</head>

<body>
    <div class="form-box">

        <form  method="post" action="login.php">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" id="login-btn" class="toggle-btn active">Se connecter</button>
                <button type="button" id="register-btn" class="toggle-btn">S'inscrire</button>
            </div>
          <?php if(isset($message)) 
                    echo "<div class='alert-box'> <div class='alert alert-danger' role='alert'>
                    <strong>Erreur!</strong> $message
                </div></div>"; ?>

            <div class="login" id="login">
                <input type="email" class="input-field" placeholder="Email" name="email" required>
                <input type="password"name="password" class="input-field" placeholder="Mot de passe" required>
            </div>
           

            <button type="submit" name="submit" id="submit-btn" class="submit-btn">Connexion</button>
        </form>

    </div>
    
</body>
<script>
     const loginBtn = document.getElementById("login-btn");
    const registerBtn = document.getElementById("register-btn");

    loginBtn.addEventListener("click", () => {
      if(!window.location.href.includes("login.php")) {
        window.location.href = "login.php";
      }
    });

    registerBtn.addEventListener("click", () => {
      if(!window.location.href.includes("register.php")) {
        window.location.href = "register.php";
      }
    });

</script>

</html>