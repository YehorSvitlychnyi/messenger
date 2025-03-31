const newChat = document.querySelector('.new-chat');
const chatCatalog = document.querySelector('.chat-catalog');
const chatName = document.querySelector('.chat-name');
const chatMessages = document.querySelector('.chat-messages');
const chatNewMessage = document.querySelector('.chat-new-message');
const chatUser = document.querySelector('.chat-user');
window.user = null;
init();
function init(){
    getUser();
    setTimeout(function(){
        chatSelect();
        getAllChats();
    },10);
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

function getMessages(id, name){
    let xhr = new XMLHttpRequest();
    let data = new FormData;
    data.append('id', id)
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4){
            let chatData = JSON.parse(xhr.response);
            showChat(chatData, name);
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
        console.log(message);
        console.log(user);
        if(message.login === user.login){
            body += `<div class="message right"><p>${message.name}</p><p>${message.message}</p><p>${message.created_at}</p></div>`;
        } else {
            body += `<div class="message left"><p>${message.name}</p><p>${message.message}</p><p>${message.created_at}</p></div>`;
        }
    }
    chatMessages.innerHTML = body;
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
function chatSelect(){
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
            let form = document.querySelector('.new-chat form');
            form.addEventListener('submit' ,function(e){
                e.preventDefault();
                if (this.elements.select.selectedIndex !== 0){
                    addChat(this.elements.select.value);
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
    }
    xhr.open('GET', '/Api/getUser');
    xhr.send();
}














// function action(){
//     alert('ok');
// }
// let myRequest = (func, method, url, data)=>{
//     func();
// }
// myRequest(action);