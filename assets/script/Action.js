'use strict'

var Action = function() {}

function param(object) {
    var encodedString = '';
    for (var prop in object) {
        if (object.hasOwnProperty(prop)) {
            if (encodedString.length > 0) {
                encodedString += '&';
            }
            encodedString += encodeURI(prop + '=' + object[prop]);
        }
    }
    return encodedString;
}


Action.prototype.contributeClick = function()
{
    this.style.display = 'none'
    document.getElementById('dialog-message').style.display = 'block'
}

Action.prototype.donButtonClick = function()
{
    //SECURITE
    var session_id = this.getAttribute('data-sessionid')

    var value = document.getElementById('dialog-button-value').value
    var id_project = this.getAttribute('data-id')
    
    //ajax
    var action = new Action
    var url = '/?stat&create&ajax=1&don='+value+'&id_project='+id_project+'&session_id='+session_id

    action.ajaxGetRequest(url, function(){
        //console.log(this.responseText)
        if(1 == this.responseText) {
            document.getElementById('dialog-button').style.display = 'none'
            document.getElementById('form_don').style.display = 'none'
            document.getElementById('thanks_don').style.display = 'block'
        }
    })
}

Action.prototype.ajaxGetRequest = function(url, callback)
{
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onload = callback;
    xhr.send();
}
