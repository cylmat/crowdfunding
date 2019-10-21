/* variables */


/* functions */


/* main program */
//$(function(){
document.addEventListener('DOMContentLoaded', function() {
    /* met en place les barres de progression */
    var modules = document.querySelector('.module')
    $(".module").each(function(index){
        var percent = $(this).attr('data-percent')
        $(this).children().first().css('background', 'linear-gradient(to right, green '+percent+'%, white '+percent+'%, white 100%)')
    })

})


/*
  no jquery




 */