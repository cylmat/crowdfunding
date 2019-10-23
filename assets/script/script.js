'use strict'

/* global App */

/* main program */
document.addEventListener('DOMContentLoaded', function() {
    /* met en place les barres de progression */
    var app = new App
    var action = new Action
    
    app.displayProgressBar()
    app.initActions()

    window.onresize = action.loadStats;
})

