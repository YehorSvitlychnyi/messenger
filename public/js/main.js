const newChat = document.querySelector('.new-chat');
const chatCatalog = document.querySelector('.chat-catalog');
const chatName = document.querySelector('.chat-name');
const chatMessages = document.querySelector('.chat-messages');
const chatNewMessage = document.querySelector('.chat-new-message');
const chatUser = document.querySelector('.chat-user');
window.user = null;
setInterval(function () {
    let select = document.querySelector('.new-chat select');
    chatSelect(select.value);
    getAllChats();
    if(sessionStorage.getItem('chatName') !== null) {
        let text;
        if(document.querySelector('.chat-new-message form textarea')) {
            text = document.querySelector('.chat-new-message form textarea').value;
            getMessages(sessionStorage.getItem('chatId'),sessionStorage.getItem('chatName'), text);
        }
    }
}, 10000)
init();
function init(){
    getUser();
    setTimeout(function(){
        chatSelect();
        getAllChats();
        logout();
    },200);
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
                    let name = this.innerText;
                    getMessages(this.id , name);
                });
            }
        }
    }
    xhr.open('GET', '/Api/getChats');
    xhr.send();
}

function getMessages(id, name, message=''){
    let xhr = new XMLHttpRequest();
    let data = new FormData;
    data.append('id', id)
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4){
            let chatData = JSON.parse(xhr.response);
            sessionStorage.setItem('chatName', name);
            sessionStorage.setItem('chatId', id);
            showChat(chatData, name);
            newMessage(id, message);
        }
    }
    xhr.open('POST', '/Api/getMessages');
    xhr.send(data);
}
function showChat(chatData, name){
    let body = `<p>${name}</p>`;
    chatName.innerHTML = body;
    body = '';
    for(let message of chatData){
        if(message.login === user.login){
            body += `<div class="message right"><p>${message.name}</p><p>${message.message}</p><p>${message.created_at}</p></div>`;
        } else {
            body += `<div class="message left"><p>${message.name}</p><p>${message.message}</p><p>${message.created_at}</p></div>`;
        }
    }
    chatMessages.innerHTML = body;
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
function chatSelect(value){
    let xhr = new  XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if (xhr.readyState === 4){
            let usersList = JSON.parse(xhr.response);
            let body = `<form><select name="select"><option hidden>new chat</option>`;
            for(let user of usersList){
                body += `<option value="${user.id}">${user.login} - ${user.name}</option>`
            }
            body += `</select><input type="submit" value="add" class="add-chat-button"/></form>`;
            newChat.innerHTML = body;
            let select = document.querySelector('.new-chat select');
            select.value = value;
            let form = document.querySelector('.new-chat form');
            form.addEventListener('submit' ,function(e){
                e.preventDefault();
                if (this.elements.select.selectedIndex !== 0){
                    addChat(this.elements.select.value);
                    form.reset();
                }
            });
        }
    }
    xhr.open('GET', '/Api/getUsers');
    xhr.send();
}
function addChat(userIdSecond){
    let xhr = new  XMLHttpRequest();
    let data = new FormData;
    data.append('userIdSecond', userIdSecond);
    data.append('userIdFirst', user.id);
    xhr.onreadystatechange = function (){
        if (xhr.readyState === 4){
            init();
        }
    }
    xhr.open('POST', '/Api/addChat');
    xhr.send(data);
}
function getUser(){
    let xhr = new  XMLHttpRequest();
    xhr.onreadystatechange = function (){
        if (xhr.readyState === 4){
            window.user = JSON.parse(xhr.response);
        }
    };
    xhr.open('GET', '/Api/getUser');
    xhr.send();
}
function newMessage(chatId, message=''){
    let body = `<form><textarea cols="40" rows="2" style="min-height: 40px;max-height: 40px"></textarea><input type="submit" value="send"></form>`;
    chatNewMessage.innerHTML = body;
    let input = document.querySelector('.chat-new-message textarea');
    input.focus();
    input.value = message;
    input.scrollTop = input.scrollHeight;
    let form = document.querySelector('.chat-new-message form');
    form.addEventListener('submit' ,function(e){
        let me = this;
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        let data = new FormData;
        data.append('message', this.elements[0].value);
        data.append('chatId', chatId);
        xhr.onreadystatechange = function (){
            if (xhr.readyState === 4){
                let body = chatMessages.innerHTML;
                let response = JSON.parse(xhr.response);
                body += `<div class="message right"><p>${window.user.name}</p><p>${me.elements[0].value}</p><p>${response.data}</p></div>`;
                chatMessages.innerHTML = body;
                chatMessages.scrollTop = chatMessages.scrollHeight;
                me.reset();
                me[0].value = '';
            }
        }
        let value = this.elements[0].value.trim();
        if(value !== ''){
            xhr.open('POST', '/Api/addMessage');
            xhr.send(data);
        }
    });
}
function logout(){
    let body = `<div class="user-logout"><p>${window.user.name}</p></div><form><input type="submit" value="log Out"></form>`;
    chatUser.innerHTML = body;
    let logout = document.querySelector('.chat-user form');
    logout.addEventListener('submit' ,function(e){
        e.preventDefault();
        window.user = null;
        sessionStorage.clear();
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '/Api/logout');
        xhr.send();
        setTimeout(function(){
            window.location.replace("/Auth/signin");
        }, 20);

    });
}














// function action(){
//     alert('ok');
// }
// let myRequest = (func, method, url, data)=>{
//     func();
// }
// myRequest(action);