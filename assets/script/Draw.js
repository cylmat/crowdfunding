'use strict'

var Draw = function(opt)
{
    if(opt)
        this.setOptions(opt)
}

Draw.prototype.setOptions = function(options) 
{
    if(options.canvas) {
        this.canvas = options.canvas;
        this.ctx = this.canvas.getContext("2d");
    }
    
    if(options.width && options.height) {
        this.width = options.width;
        this.height = options.height;
    }

    this.canvas.width = this.width;
    this.canvas.height = this.height;

    this.ctx.width = this.width;
    this.ctx.height = this.height;

    if(options.colors) 
        this.colors = options.colors;
    
}



/*
 * Bar chart
 */
Draw.prototype.drawBarChart = function(datas)
{
    var nbr_bars = Object.keys(datas).length
    var max_val = Math.max(...Object.values(datas))
    var bar_width = (this.ctx.width-20) / nbr_bars

    var coord_x = 20
    var count = 0

    var text_height = 10
    var sorted = Object.keys(datas).sort((a,b) => {return a.value - b.value})

    //boucle sur les donnees
    for(var i in sorted) {
        var index = sorted[i]

        //barre
        var bar_height = Math.round(this.ctx.height * datas[index] / max_val) - text_height
        bar_height = bar_height < 0 ? 1 : bar_height

        var coord_y = this.ctx.height - bar_height - text_height
        this.bar(coord_x, coord_y, bar_width, bar_height, this.colors[count%this.colors.length]);
        
        //increment
        coord_x += bar_width
        count++
    }
}

Draw.prototype.drawRoundChart = function(datas)
{
    var nbr_bars = Object.keys(datas).length
    var max_val = Math.max(...Object.values(datas))
    var bar_width = (this.ctx.width-10) / nbr_bars

    var coord_x = 20
    var diametre = 10
    var count = 0

    var text_height = 10
    var sorted = Object.keys(datas).sort((a,b) => {return a.value - b.value})

    //boucle sur les donnees
    for(var i in sorted) {
        var index = sorted[i]

        //circle
        var bar_height = Math.round(this.ctx.height * datas[index] / max_val) - text_height - (2*diametre)
        bar_height = bar_height < 0 ? 1 : bar_height

        var coord_y = this.ctx.height - bar_height - text_height - diametre
        this.circle(coord_x, coord_y, diametre, this.colors[count%this.colors.length]);

        //increment
        coord_x += bar_width
        count++
    }
}

Draw.prototype.drawLegend = function(datas)
{
    var nbr_bars = Object.keys(datas).length
    var max_val = Math.max(...Object.values(datas))
    var bar_width = this.ctx.width / nbr_bars

    var coord_x = 10
    var text_height = 10
    var sorted = Object.keys(datas).sort((a,b) => {return a.value - b.value})

    //boucle sur les donnees
    for(var i in sorted) {
        var index = sorted[i]

        //texte
        var text_coord_y = this.ctx.height
        this.text(index, coord_x, text_coord_y)

        //increment
        coord_x += bar_width
    }
}

Draw.prototype.drawAxis = function(datas, end_text)
{
    var nbr_bars = Object.keys(datas).length
    var max_val = Math.max(...Object.values(datas))
    var bar_width = this.ctx.width / nbr_bars

    var ref = Math.round(max_val/10)

    var coord_x = 0
    var text_height = 10
    
    //de 0 à max
    for(var index=0; index<max_val-ref; index+=ref) {
        var bar_height = Math.round(this.ctx.height * index / max_val) - text_height
        var coord_y = this.ctx.height - bar_height - text_height

        if(0 != index)
            this.text(index, coord_x, coord_y)        
    }

    bar_height = Math.round(this.ctx.height * index / max_val) - text_height
    coord_y = this.ctx.height - bar_height - text_height
    this.text(end_text, coord_x, coord_y)
}

Draw.prototype.drawPart = function(datas)
{
    var cours = datas.cours //fonds
    var rea = datas.rea // dons
    var div = parseInt(datas.div) // rapports fonds/dons

    var split = 2*(rea/div)+1.5

    var rayon = 100
    this.circle(this.width/2, this.height/2, rayon, 'darkorange',  1.5*Math.PI, split*Math.PI, 15)
    this.circle(this.width/2, this.height/2, rayon, 'mediumseagreen', split*Math.PI, 1.5*Math.PI, 15)
    this.circle(this.width/2, this.height/2, rayon-20, 'white')

    this.text(rea+' dons', (this.width/2)-5, (this.height/3)+7)
    this.bar((this.width/2)+50, this.height/3, 10, 10, 'darkorange')

    this.text(div+'€ moyens', (this.width/2)-30, (this.height/1.5)+7)
    this.bar((this.width/2)-50, this.height/1.5, 10, 10, 'mediumseagreen')
}







Draw.prototype.text = function(text, startX, startY, color='black', size='8px')
{
    this.ctx.save();
    this.ctx.fillStyle = color;
    this.ctx.font = size+'serif';
    this.ctx.fillText(text, startX, startY);
    this.ctx.restore();
}

Draw.prototype.line = function(startX, startY, endX, endY, color)
{
    this.ctx.save();
    this.ctx.strokeStyle = color;
    this.ctx.beginPath();
    this.ctx.moveTo(startX, startY);
    this.ctx.lineTo(endX, endY);
    this.ctx.stroke();
    this.ctx.restore();
}

Draw.prototype.bar = function(upperLeftCornerX, upperLeftCornerY, width, height, color)
{
    this.ctx.save();
  /*context.strokeStyle="blue";   
  context.lineWidth="2";   
  context.rect(10,10,200,100);
  context.stroke();*/
  
    this.ctx.fillStyle=color;
    this.ctx.fillRect(upperLeftCornerX, upperLeftCornerY, width, height);
    this.ctx.restore();
}

Draw.prototype.circle = function(centerX, centerY, rayon, color, angleDepart=0, angleFin=(2 * Math.PI), lineWidth=1)
{
    //void ctx.arc(x, y, rayon, angleDépart, angleFin, sensAntiHoraire);
    this.ctx.save();
    this.ctx.fillStyle=color;
    this.ctx.lineWidth=lineWidth;
    this.ctx.strokeStyle='white';  
    this.ctx.beginPath(); 
    this.ctx.lineTo(centerX, centerY);
    this.ctx.arc(centerX, centerY, rayon, angleDepart, angleFin);
    this.ctx.lineTo(centerX, centerY);
    this.ctx.stroke();
    this.ctx.fill();
    this.ctx.restore();
}
