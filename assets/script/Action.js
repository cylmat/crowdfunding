'use strict'

/* global Draw */

var Action = function() {}

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
    var url = '/?stat&getallstatsjson&ajax=1'

    action.ajaxGetRequest(url, function(){
        var json_response = JSON.parse(this.responseText)

        if(null == json_response) return;

        if(!document.getElementById("canvas_fonds")) return;

        var fonds = {}
        var dons = {}

        var fonds_total = 0;
        var dons_total = 0;

        //set stats from response
        json_response.forEach(function(item) {
            fonds[item.month_don] = item.somme
            dons[item.month_don] = item.count_total

            fonds_total += parseInt(item.somme)
            dons_total += parseInt(item.count_total)
        })
        var div = fonds_total / dons_total;

        var width_size = 600

        /*
         * Fonds
         */
        var draw = new Draw({
            width: width_size,
            height: 200,
            canvas: document.getElementById("canvas_fonds"),
            colors: ["darkorange", "mediumseagreen", "chocolate"]
        })
        draw.drawBarChart(fonds);
        draw.drawLegend(fonds);
        draw.drawAxis(fonds, 'euros récoltés');

        //set to image
        var dataURL = draw.canvas.toDataURL();
        document.getElementById('canvas_fonds_img').src = dataURL;

        /*
         * Dons
         */
        draw.setOptions({
            canvas: document.getElementById("canvas_dons")
        })
        draw.drawRoundChart(dons);
        draw.drawLegend(dons);
        draw.drawAxis(dons, 'dons effectués');

        //set to image
        var dataURL = draw.canvas.toDataURL();
        document.getElementById('canvas_dons_img').src = dataURL;

        /*
         * Projets realisés
         */
        draw.setOptions({
            canvas: document.getElementById("canvas_rea")
        })
        draw.drawPart({'cours':fonds_total, 'rea':dons_total, 'div': div})

        //set to image
        var dataURL = draw.canvas.toDataURL();
        document.getElementById('canvas_rea_img').src = dataURL;
    })
}

Action.prototype.ajaxGetRequest = function(url, callback)
{
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onload = callback;
    xhr.send();
}
