<?php 

require_once 'backend/dataConfig.php';
require_once 'backend/helper.php';

if(isset($_SESSION['token'])){
    if(get_user(isset($_SESSION['email']) ? $_SESSION['email'] : null, isset($_SESSION['token']) ? $_SESSION['token'] : null)) {
        header('location: index.php');
    }
}



if(isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $token =  generateToken(60);

    if($password == $password2) {
        $password = md5($password);
        $sql = "INSERT INTO users (nom, prenom, email, password, token) VALUES ('$nom', '$prenom', '$email', '$password', '$token')";
       if(mysqli_query($mysqli, $sql)) {
        session_start();
        $_SESSION['token'] = $token;
    
        $_SESSION['email'] = $email;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($mysqli, $sql);
        $user = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $user['id'];
        header('location: index.php');
         } else {
              $message = "Erreur lors de l'inscription";
         }
    } else {
        $message_pwd = "Les mots de passe ne correspondent pas";
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
        <form  method="post" action="register.php">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" id="login-btn" class="toggle-btn">Se connecter</button>
                <button type="button" id="register-btn" class="toggle-btn active">S'inscrire</button>
            </div>
            
                <?php if(isset($message)) 
                    echo "<div class='alert-box'> <div class='alert alert-danger' role='alert'>
                    <strong>Erreur!</strong> $message
                </div>
                </div>";
                
                ?>
            <div class="register" id="register" >
                <input type="text" class="input-field" placeholder="Nom" name="nom">
                <input type="text" class="input-field" placeholder="Prénom" name="prenom">
                <input type="email" class="input-field" placeholder="Email" name="email">
                <input type="password" class="input-field" placeholder="Mot de passe" name="password">
                <input type="password" class="input-field" placeholder="Confirmer mot de passe" name="password2">
            </div>
            <button type="submit" name="submit" id="submit-btn" class="submit-btn">
                S'inscrire
            </button>
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