const newChat = document.querySelector('.new-chat');
const chatCatalog = document.querySelector('.chat-catalog');
const chatName = document.getElementsByClassName('chat-name');
const chatMessages = document.getElementsByClassName('chat-messages');
const chatNewMessage = document.getElementsByClassName('chat-new-message');
const chatUser = document.getElementsByClassName('chat-user');
init();
function init(){
    chatSelect();
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
                if (this.elements.select.value !== 'new chat'){
                    addChat(this.elements.select.value);
                }
            });
        }
    }
    xhr.open('GET', '/Api/getUsers');
    xhr.send();
}
function addChat(userId){
    let xhr = new  XMLHttpRequest();
    xhr.onreadystatechange = function (){

    }
    xhr.open('GET', '/Api/addChat');
    xhr.send();
}

function action(){
    alert('ok');
}
let myRequest = (func)=>{
    func();
}
myRequest(action);