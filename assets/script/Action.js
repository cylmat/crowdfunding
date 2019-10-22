'use strict'

/* global Draw */

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
        if(1 == this.responseText) {
            document.getElementById('dialog-button').style.display = 'none'
            document.getElementById('form_don').style.display = 'none'
            document.getElementById('thanks_don').style.display = 'block'
        }
    })
} 

Action.prototype.loadStats = function()
{
    var action = new Action
    var url = '/?stat&getjson&ajax=1'

    action.ajaxGetRequest(url, function(){
        var json_response = this.responseText
    })

    var canvas_fonds = document.getElementById("canvas_fonds");
    
    var stats = {
        "01": 10,
        "02": 14,
        "03": 2,
        "04": 12,
        "05": 5,
        "06": 45,
        "07": 15,
        "08": 35,
        "09": 53,
        "10": 15,
        "11": 19
    };

    var draw = new Draw({
        width: 600,
        height: 200,
        canvas: canvas_fonds,
        colors: ["red", "green", "grey"]
    })

    /*var draw = new Draw({
        canvas:canvas_fonds,
        padding:10,
        gridColor:"#eeeeee",
        data:stats,
        colors:["#a55ca5","#67b6c7", "#bccd7a","#eb9743"]
    });*/

    draw.drawBarChart(stats);
}

Action.prototype.ajaxGetRequest = function(url, callback)
{
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onload = callback;
    xhr.send();
}
