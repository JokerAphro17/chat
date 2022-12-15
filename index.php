<?php
    include "backend/dataConfig.php";
    session_start();
    if(!isset($_SESSION['token'])){
        header('location: login.php');
    }
    
    $users = mysqli_query($mysqli, "SELECT * FROM users");
    
    $users = mysqli_fetch_all($users, MYSQLI_ASSOC);
    $users = array_filter($users, function($user) {
        return $user['id'] != $_SESSION['id'];
    });
    $users = array_values($users);

    $users = array_map(function($user) {
        $user['messages'] = mysqli_query(connect(), "SELECT * FROM messages WHERE (sender_id = {$user['id']} AND receiver_id = {$_SESSION['id']}) OR (sender_id = {$_SESSION['id']} AND receiver_id = {$user['id']})");
        $user['messages'] = mysqli_fetch_all($user['messages'], MYSQLI_ASSOC);
        return $user;
    }, $users);

?>    


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" href="css/styles.css" />

</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="left">
                <ul class="people">
                    <?php foreach($users as $user): ?>
                    <li class="person" 
                    onclick="activeChat(<?php echo $user['id']; ?>); 
                    getMessages();
                    "
                    data-chat="person<?php echo $user['id']; ?>">
                        <span class="name"><?php echo $user['nom'].' '.$user['prenom']; ?></span>
                      
                    </li>
                    <?php endforeach; ?>
                   
                </ul>
            </div>
            <div class="right">
                
            
                <?php foreach($users as $user): ?>
                    
                <div class="chat" data-chat="person<?php echo $user['id']; ?>">
                    <?php foreach($user['messages'] as $message): ?>
                    <div class="bubble <?php echo $message['sender_id'] == $_SESSION['id'] ? 'me' : 'you'; ?>">
                        <?php echo $message['message']; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            <div id="msg-form" action="backend/send.php" method="POST">
                <div class="write">
                    <input id="msg-input"
                    onkeyup="if(event.keyCode == 13) sendMessage()"
                        
                    placeholder="Entrer le message " type="text" />
                    <div class="write-link send"
                    onClick="sendMessage()"
                    
                    ></div>
                </div>
            </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="js/index.js"></script>
<script>
    function activeChat(id) {
        document.querySelector('.chat[data-chat="person'+id+'"]').classList.add('active-chat');
        // remove active class from other chats
        document.querySelectorAll('.chat').forEach(chat => {
            if(chat.dataset.chat != 'person'+id) {
                chat.classList.remove('active-chat');
            }
        })
        document.querySelectorAll('.person').forEach(person => {
            if(person.dataset.chat == 'person'+id) {
                person.classList.add('active');
            } else {
                person.classList.remove('active');
            }
        })

    }
    let input = document.querySelector('#msg-input');
    function sendMessage(
        receiver_id = document.querySelector('.chat.active-chat').dataset.chat.replace('person', '')
    ) {
        let formData = new FormData();
        formData.append('sender_id', <?php echo $_SESSION['id']; ?>);
        formData.append('message', input.value);
        formData.append('receiver_id', receiver_id);
        fetch("backend/send.php", {
            method: 'POST',
            body: formData
        }).then(res => res.json())
        .then(res => {
            if(res.status == 'success') {
                let chat = document.querySelector(`.chat[data-chat="person${receiver_id}"]`);
                let div = document.createElement('div');
                div.classList.add('bubble');
                div.classList.add('me');
                div.innerHTML = input.value;
                chat.appendChild(div);
                input.value = '';
            }
        })
    }

    function getMessages() {
        let receiver_id = document.querySelector('.chat.active-chat').dataset.chat.replace('person', '');
        fetch(`backend/getMessage.php?sender_id=<?php echo $_SESSION['id']; ?>&receiver_id=${receiver_id}`)
        .then(res => res.json())
        .then(res => {
            if(res.status == 'success') {
                let chat = document.querySelector(`.chat[data-chat="person${receiver_id}"]`);
                chat.innerHTML = '';
                res.messages.forEach(message => {
                    let div = document.createElement('div');
                    div.classList.add('bubble');
                    div.classList.add(message.sender_id == <?php echo $_SESSION['id']; ?> ? 'me' : 'you');
                    div.innerHTML = message.message;
                    chat.appendChild(div);
                })
            }
        })
    }

    setInterval(getMessages, 1000);

</script>