const newChat = document.getElementsByClassName('new-chat');
const chatCatalog = document.querySelector('.chat-catalog');
const chatName = document.getElementsByClassName('chat-name');
const chatMessages = document.getElementsByClassName('chat-messages');
const chatNewMessage = document.getElementsByClassName('chat-new-message');
const chatUser = document.getElementsByClassName('chat-user');
init();
function init(){
    getAllChats();
}
function getAllChats(){
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if (xhr.readyState === 4){
            let chatlist = JSON.parse(xhr.response);
            let chats = '';
            for(let chat of chatlist){
                chats += `<div class="chat" id="${chat.id}">${chat.name}</div>`;
            }
            chatCatalog.innerHTML = chats;
            let allChats = document.querySelectorAll('.chat');
            for(let chat of allChats){
                chat.addEventListener('click', function(){
                    getMessages(this.id);
                });
            }
        }
    }
    xhr.open('GET', '/Api/getChats');
    xhr.send();
}

function getMessages(id){
    let xhr = new XMLHttpRequest();
    let data = new FormData;
    data.append('id', id)
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4){
            console.log(JSON.parse(xhr.response));
        }

    }
    xhr.open('POST', '/Api/getMessages');
    xhr.send(data);
}