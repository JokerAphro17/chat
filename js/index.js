function activeChat(id) {
  var chats = document.getElementsByClassName("chat");
  for (var i = 0; i < chats.length; i++) {
    chats[i].classList.remove("active-chat");
  }
  document
    .querySelector('.chat[data-chat="person' + id + '"]')
    .classList.add("active-chat");
}
