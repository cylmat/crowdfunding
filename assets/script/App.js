'use strict'

/* global Action */

var App = function() {}

App.prototype.displayProgressBar = function()
{
    var modules = document.querySelectorAll('.module')
    modules.forEach(function(element) {
        var percent = element.getAttribute('data-percent')
        element.style.background = 'linear-gradient(to right, green '+percent+'%, white '+percent+'%, white 100%)'
    })
}

App.prototype.initActions = function()
{
    var action = new Action
    
    if(document.getElementById('contribute')) {
        document.getElementById('contribute').onclick = action.contributeClick
        document.getElementById('dialog-button').onclick = action.donButtonClick
    }

    //for stats page
    if(document.getElementById('stats_fonds')) {
        action.loadStats()
    }
}