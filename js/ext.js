$(document).ready(function () {
    $('#main').hide();
    $('#main').delay(1000).fadeIn();

    function moveDiv() {

        // $('#main').fadeTo('opacity', 0.9);
        windowWidth = $(window).width();
        windowHeight = $(window).height();

        objWidth = $('#center').width();
        objHeight = $('#center').height();

        mainHeight = windowHeight*0.95;
        mainWidth = windowWidth*0.985;
    //   alert(mainHeight)
        $('#main').height(mainHeight+'px');
        $('#main').width(mainWidth+'px');
        $('#center').css('top', (windowHeight - objHeight)/2).css('left', (windowWidth - objWidth)/2);
      
      
    }
    moveDiv();
  
    $(window).resize(function () { 
      moveDiv();
    });
  });
