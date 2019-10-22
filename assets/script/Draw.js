'use strict'

var Draw = function(opt)
{
    this.setOptions(opt)
}

Draw.prototype.setOptions = function(options) 
{
    this.options = options;
    this.canvas = options.canvas;
    this.canvas.width = options.width;
    this.canvas.height = options.height;

    this.ctx = this.canvas.getContext("2d");
    this.colors = options.colors;
    this.ctx.width = options.width;
    this.ctx.height = options.height;
}



/*
 * Bar chart
 */
Draw.prototype.drawBarChart = function(datas)
{
    var nbr_bars = Object.keys(datas).length
    var max_val = Math.max(...Object.values(datas))
    var bar_width = this.ctx.width / nbr_bars

    var coord_x = 0
    var count = 0

    var text_height = 10
    var sorted = Object.keys(datas).sort()

    //boucle sur les donnees
    for(var i in sorted) {
        var index = sorted[i]

        //barre
        var bar_height = Math.round(this.ctx.height * datas[index] / max_val) - text_height
        var coord_y = this.ctx.height - bar_height - text_height
        this.bar(coord_x, coord_y, bar_width, bar_height, this.colors[count%this.colors.length]);
        
        //texte
        var text_coord_y = this.ctx.height
        this.text(index, coord_x, text_coord_y, 'black')

        //increment
        coord_x += bar_width
        count++
    }
}




Draw.prototype.text = function(text, startX, startY, color, size='8px')
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

Draw.prototype.circle = function(centerX, centerY, diametre, color)
{
    this.ctx.save();
    this.ctx.restore();
}
