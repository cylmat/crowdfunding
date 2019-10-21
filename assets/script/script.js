/* variables */


/* functions */


/* main program */
$(function(){

    /* met en place les barres de progression */
    $('.module').each(function(index){
        var percent = $(this).attr('data-percent');
        $(this).children().first().css('background', 'linear-gradient(to right, green '+percent+'%, white '+percent+'%, white 100%)'); 
    });
})