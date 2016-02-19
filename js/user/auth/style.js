$( document ).ready(function(){ 
  var w = 1200;
var h = 690;

var w_big = w/6 * 4;      /* 200 */   /* 400 */  /*  800  */
var h_big = h/5 * 4;     /* 138 */   /* 230*/    /* 552 */

var w_middle = w/3;      /* 200 */   /* 400 */  /*  800  */
var h_middle = h/3;     /* 138 */   /* 230*/    /* 552 */

var w_small = w/6;      /* 200 */   /* 400 */  /*  800  */
var h_small = h/5;     /* 138 */   /* 230*/    /* 552 */




$( ".bl-1" ).click(function(){

    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);

        if($(this).attr('data-item') == 1){
            var class_big = $(".asn-gallery").find(".big").attr('class');
            var x = parseInt($(this).css('top'));
            var y = parseInt($(this).css('left'));
            var w = parseInt($(this).css('width'));
            var h = parseInt($(this).css('height'));
            var arr = class_big.split(' ');
            var class_old = $(this).attr('class');
            var mas = class_old.split(' ');
            $("."+arr[0]).effect( "size", {
                to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
            }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
                $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

            $(this).animate({top: 0, left:0}, 1000);
            $(this).effect( "size", {
                to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
            }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big')} );
        }
        else{

        $(".asn-gallery").children().attr('data-item', 1);
        $(this).effect( "size", {to: { width: w_big, height: h_big }
        }, 1000 );
        $(this).removeClass('bl4').addClass('big');
        /* Блок 2 */
        $(".bl-2").animate({top: 0, left: w_big }, 1000);
        $( ".bl-2").effect( "size", { to: { width: w_small*2, height: h_small*2}
        }, 1000, function(){$( ".bl-2" ).removeClass('bl4').addClass('middle-1')} );

        /* Блок 3 */
        $(".bl-3").animate({top: h_small*2, left: w_big }, 1000);
        $( ".bl-3").effect( "size", { to: { width: w_small*2, height: h_small*2}
        }, 1000, function(){$( ".bl-3" ).removeClass('bl4').addClass('middle-1')} );

        /* Блок 4 */
        $( ".bl-4").effect( "size", { to: { width: w_small , height: h_small }, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-4").animate({top: h_small *4,  left:0}, 1000); $( ".bl-4" ).removeClass('bl4').addClass('small')} );

        /* Блок 5 */
        $( ".bl-5").effect( "size", { to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-5").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-5" ).removeClass('bl4').addClass('small')} );

        /* Блок 6 */
        $( ".bl-6").effect( "size", { to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-6").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-6" ).removeClass('bl4').addClass('small')} );

        /* Блок 7 */
        $( ".bl-7").effect( "size", { to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-7").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-7" ).removeClass('bl4').addClass('small')} );

        /* Блок 8 */
        $( ".bl-8").effect( "size", { to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-8").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-8" ).removeClass('bl4').addClass('small')} );

        /* Блок 9 */
        $( ".bl-9").effect( "size", { to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-9").animate({top: h_small*4, left:w_small*5}, 1000); $( ".bl-9" ).removeClass('bl4').addClass('small');});

        }
   
});


$( ".bl-2" ).click(function(){
    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);

    if($(this).attr('data-item') == 1){

        var class_big = $(".asn-gallery").find(".big").attr('class');
        var x = parseInt($(this).css('top'));
        var y = parseInt($(this).css('left'));
        var w = parseInt($(this).css('width'));
        var h = parseInt($(this).css('height'));
        var arr = class_big.split(' ');
        var class_old = $(this).attr('class');
        var mas = class_old.split(' ');
        $("."+arr[0]).effect( "size", {
            to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
        }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
            $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

        $(this).animate({top: 0, left:0}, 1000);
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big')} );
    }
    else{

        $(".asn-gallery").children().attr('data-item', 1);
        $(this).animate({top: 0, left:0}, 1000)
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('bl4').addClass('big')} );

        /* Блок 1 */
        $(".bl-1").animate({top: 0, left:w_small*4}, 1000);
        $( ".bl-1").effect( "size", {
            to: { width: w_small*2, height: 200 }
        }, 1000, function(){$( ".bl-1" ).removeClass('bl4').addClass('middle-1')} );

        /* Блок 3 */
        $(".bl-3").animate({top: h_small*2, left:w_small*4}, 1000);
        $( ".bl-3").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-3" ).removeClass('bl4').addClass('middle-1')} );

        /* Блок 4 */

        $( ".bl-4").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-4").animate({top: h_small*4, left:0}, 1000); $( ".bl-4" ).removeClass('bl4').addClass('small')} );

        /* Блок 5 */

        $( ".bl-5").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-5").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-5" ).removeClass('bl4').addClass('small')} );

        /* Блок 6 */

        $( ".bl-6").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-6").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-6" ).removeClass('bl4').addClass('small')} );


        /* Блок 7 */

        $( ".bl-7").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-7").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-7" ).removeClass('bl4').addClass('small')} );

        /* Блок 8 */

        $( ".bl-8").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-8").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-8" ).removeClass('bl4').addClass('small')} );

        /* Блок 9 */

        $( ".bl-9").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-9").animate({top: h_small*4, left:w_small*5}, 1000); $( ".bl-9" ).removeClass('bl4').addClass('small');});
    }
   
});



$( ".bl-3" ).click(function(){
    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);

    if($(this).attr('data-item') == 1){

        var class_big = $(".asn-gallery").find(".big").attr('class');
        var x = parseInt($(this).css('top'));
        var y = parseInt($(this).css('left'));
        var w = parseInt($(this).css('width'));
        var h = parseInt($(this).css('height'));
        var arr = class_big.split(' ');
        var class_old = $(this).attr('class');
        var mas = class_old.split(' ');
        $("."+arr[0]).effect( "size", {
            to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
        }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
            $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

        $(this).animate({top: 0, left:0}, 1000);
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big')} );
    }
    else{

        $(".asn-gallery").children().attr('data-item', 1);

        $(this).animate({top: 0, left:0}, 1000)
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('bl4').addClass('big')} );

        /* Блок 1 */
        $(".bl-1").animate({top: 0, left:w_small*4}, 1000);
        $( ".bl-1").effect( "size", {
            to: { width: w_small*2, height: 200 }
        }, 1000, function(){$( ".bl-1" ).removeClass('bl4').addClass('middle-1')} );

        /* Блок 2 */
        $(".bl-2").animate({top: h_small*2, left:w_small*4}, 1000);
        $( ".bl-2").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-2" ).removeClass('bl4').addClass('middle-1')} );

        /* Блок 4 */
        $( ".bl-4").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-4").animate({top: h_small*4, left:0}, 1000); $( ".bl-4" ).removeClass('bl4').addClass('small')} );

        /* Блок 5 */
        $( ".bl-5").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-5").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-5" ).removeClass('bl4').addClass('small')} );

        /* Блок 6 */
        $( ".bl-6").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-6").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-6" ).removeClass('bl4').addClass('small')} );

        /* Блок 7 */
        $( ".bl-7").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-7").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-7" ).removeClass('bl4').addClass('small')} );

        /* Блок 8 */
        $( ".bl-8").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-8").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-8" ).removeClass('bl4').addClass('small')} );

        /* Блок 9 */
        $( ".bl-9").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-9").animate({top: h_small*4, left:w_small*5}, 1000); $( ".bl-9" ).removeClass('bl4').addClass('small')});
    }

   

});



$( ".bl-4" ).click(function(){
    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);

    if($(this).attr('data-item') == 1){
        var class_big = $(".asn-gallery").find(".big").attr('class');
        var x = parseInt($(this).css('top'));
        var y = parseInt($(this).css('left'));
        var w = parseInt($(this).css('width'));
        var h = parseInt($(this).css('height'));
        var arr = class_big.split(' ');
        var class_old = $(this).attr('class');
        var mas = class_old.split(' ');
        $("."+arr[0]).effect( "size", {
            to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
        }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
            $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

        $(this).animate({top: 0, left:0}, 1000);
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big')} );
    }
    else{

        $(".asn-gallery").children().attr('data-item', 1);

        $(this).animate({top: 0, left:0}, 1000)
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','right'], scale: 'box'
        }, 1000 );
        $(this).removeClass('bl4').addClass('big');

        /* Блок 1 */
        $(".bl-1").animate({top: 0, left:w_small*4}, 1000);
        $( ".bl-1").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-1" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 2 */
        $(".bl-2").animate({top: h_small*2, left:w_small*4}, 1000);
        $( ".bl-2").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-2" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 3 */
        $( ".bl-3").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-3").animate({top: h_small*4, left:w_small*5}, 1000);
            $( ".bl-3" ).removeClass('bl4').removeClass('big').addClass('small')} );

        /* Блок 5 */
        $( ".bl-5").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-5").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-5" ).removeClass('bl4').addClass('small')} );

        /* Блок 6 */
        $( ".bl-6").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-6").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-6" ).removeClass('bl4').addClass('small')} );


        /* Блок 7 */
        $( ".bl-7").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-7").animate({top: h_small*4, left:0}, 1000); $( ".bl-7" ).removeClass('bl4').addClass('small')} );

        /* Блок 8 */
        $( ".bl-8").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-8").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-8" ).removeClass('bl4').addClass('small')} );

        /* Блок 9 */
        $( ".bl-9").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-9").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-9" ).removeClass('bl4').addClass('small');});
    }

});

$( ".bl-5" ).click(function(){
    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);

    if($(this).attr('data-item') == 1){
        var class_big = $(".asn-gallery").find(".big").attr('class');
        var x = parseInt($(this).css('top'));
        var y = parseInt($(this).css('left'));
        var w = parseInt($(this).css('width'));
        var h = parseInt($(this).css('height'));
        var arr = class_big.split(' ');
        var class_old = $(this).attr('class');
        var mas = class_old.split(' ');
        $("."+arr[0]).effect( "size", {
            to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
        }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
            $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

        $(this).animate({top: 0, left:0}, 1000);
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big')} );
    }
    else{

        $(".asn-gallery").children().attr('data-item', 1);
        $(this).animate({top: 0, left:0}, 1000)
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','right'], scale: 'box'
        }, 1000 );
        $(this).removeClass('bl5').addClass('big');

        /* Блок 1 */
        $(".bl-1").animate({top: 0, left:w_small*4}, 1000);
        $( ".bl-1").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-1" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 2 */
        $(".bl-2").animate({top: h_small*2, left:w_small*4}, 1000);
        $( ".bl-2").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-2" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 3 */
        $( ".bl-3").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-3").animate({top: h_small*4, left:w_small*5}, 1000);
            $( ".bl-3" ).removeClass('bl4').removeClass('big').addClass('small')} );

        /* Блок 4 */
        $( ".bl-4").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-4").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-4" ).removeClass('bl4').addClass('small')} );

        /* Блок 6 */
        $( ".bl-6").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-6").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-6" ).removeClass('bl4').addClass('small')} );

        /* Блок 7 */
        $( ".bl-7").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-7").animate({top: h_small*4, left:0}, 1000); $( ".bl-7" ).removeClass('bl4').addClass('small')} );

        /* Блок 8 */
        $( ".bl-8").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-8").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-8" ).removeClass('bl4').addClass('small')} );

        /* Блок 9 */
        $( ".bl-9").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-9").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-9" ).removeClass('bl4').addClass('small')});
    }

});

$( ".bl-6" ).click(function(){
    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);
    if($(this).attr('data-item') == 1){

        var class_big = $(".asn-gallery").find(".big").attr('class');
        var x = parseInt($(this).css('top'));
        var y = parseInt($(this).css('left'));
        var w = parseInt($(this).css('width'));
        var h = parseInt($(this).css('height'));
        var arr = class_big.split(' ');
        var class_old = $(this).attr('class');
        var mas = class_old.split(' ');
        $("."+arr[0]).effect( "size", {
            to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
        }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
            $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

        $(this).animate({top: 0, left:0}, 1000);
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big')} );
    }
    else{

        $(".asn-gallery").children().attr('data-item', 1);
        $(this).animate({top: 0, left:0}, 1000)
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','right'], scale: 'box'
        }, 1000 );
        $(this).removeClass('bl6').addClass('big');

        /* Блок 1 */
        $(".bl-1").animate({top: 0, left:w_small*4}, 1000);
        $( ".bl-1").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-1" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 2 */
        $(".bl-2").animate({top: h_small*2, left:w_small*4}, 1000);
        $( ".bl-2").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-2" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 3 */
        $( ".bl-3").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-3").animate({top: h_small*4, left:w_small*5}, 1000);
            $( ".bl-3" ).removeClass('bl4').removeClass('big').addClass('small')} );

        /* Блок 4 */
        $( ".bl-4").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-4").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-4" ).removeClass('bl4').addClass('small')} );

        /* Блок 5 */
        $( ".bl-5").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-5").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-5" ).removeClass('bl4').addClass('small')} );


        /* Блок 7 */
        $( ".bl-7").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-7").animate({top: h_small*4, left:0}, 1000); $( ".bl-7" ).removeClass('bl4').addClass('small')} );

        /* Блок 8 */
        $( ".bl-8").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-8").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-8" ).removeClass('bl4').addClass('small')} );

        /* Блок 9 */
        $( ".bl-9").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-9").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-9" ).removeClass('bl4').addClass('small');});
    }

});


$( ".bl-7" ).click(function(){
    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);
    if($(this).attr('data-item') == 1){

        var class_big = $(".asn-gallery").find(".big").attr('class');
        var x = parseInt($(this).css('top'));
        var y = parseInt($(this).css('left'));
        var w = parseInt($(this).css('width'));
        var h = parseInt($(this).css('height'));
        var arr = class_big.split(' ');
        var class_old = $(this).attr('class');
        var mas = class_old.split(' ');
        $("."+arr[0]).effect( "size", {
            to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
        }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
            $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

        $(this).animate({top: 0, left:0}, 1000);
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big');} );
    }
    else{

        $(".asn-gallery").children().attr('data-item', 1);
        $(this).animate({top: 0, left:0}, 1000)
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','right'], scale: 'box'
        }, 1000 );
        $(this).removeClass('bl6').addClass('big');

        /* Блок 1 */
        $(".bl-1").animate({top: 0, left:w_small*4}, 1000);
        $( ".bl-1").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-1" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 2 */
        $(".bl-2").animate({top: h_small*2, left:w_small*4}, 1000);
        $( ".bl-2").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-2" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 3 */
        $( ".bl-3").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-3").animate({top: h_small*4, left:w_small*5}, 1000);
            $( ".bl-3" ).removeClass('bl4').removeClass('big').addClass('small')} );

        /* Блок 4 */
        $( ".bl-4").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-4").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-4" ).removeClass('bl4').addClass('small')} );

        /* Блок 5 */
        $( ".bl-5").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-5").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-5" ).removeClass('bl4').addClass('small')} );


        /* Блок 6 */
        $( ".bl-6").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-6").animate({top: h_small*4, left:0}, 1000); $( ".bl-6" ).removeClass('bl4').addClass('small')} );

        /* Блок 8 */
        $( ".bl-8").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-8").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-8" ).removeClass('bl4').addClass('small')} );

        /* Блок 9 */
        $( ".bl-9").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-9").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-9" ).removeClass('bl4').addClass('small');});

    }

});

$( ".bl-8" ).click(function(){
    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);
    if($(this).attr('data-item') == 1){

        var class_big = $(".asn-gallery").find(".big").attr('class');
        var x = parseInt($(this).css('top'));
        var y = parseInt($(this).css('left'));
        var w = parseInt($(this).css('width'));
        var h = parseInt($(this).css('height'));
        var arr = class_big.split(' ');
        var class_old = $(this).attr('class');
        var mas = class_old.split(' ');
        $("."+arr[0]).effect( "size", {
            to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
        }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
            $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

        $(this).animate({top: 0, left:0}, 1000);
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big')} );
    }
    else{

        $(".asn-gallery").children().attr('data-item', 1);
        $(this).animate({top: 0, left:0}, 1000)
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','right'], scale: 'box'
        }, 1000 );
        $(this).removeClass('bl8').addClass('big');

        /* Блок 1 */
        $(".bl-1").animate({top: 0, left:w_small*4}, 1000);
        $( ".bl-1").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-1" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 2 */
        $(".bl-2").animate({top: h_small*2, left:w_small*4}, 1000);
        $( ".bl-2").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-2" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 3 */
        $( ".bl-3").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-3").animate({top: h_small*4, left:w_small*5}, 1000);
            $( ".bl-3" ).removeClass('bl4').removeClass('big').addClass('small')} );

        /* Блок 4 */
        $( ".bl-4").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-4").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-4" ).removeClass('bl4').addClass('small')} );

        /* Блок 5 */
        $( ".bl-5").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-5").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-5" ).removeClass('bl4').addClass('small')} );


        /* Блок 6 */
        $( ".bl-6").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-6").animate({top: h_small*4, left:0}, 1000); $( ".bl-6" ).removeClass('bl4').addClass('small')} );

        /* Блок 7 */
        $( ".bl-7").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-7").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-7" ).removeClass('bl4').addClass('small')} );

        /* Блок 9 */
        $( ".bl-9").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-9").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-9" ).removeClass('bl4').addClass('small');});
    }

 });

$( ".bl-9" ).click(function(){
    $( "#onover").css('display', 'block');
    setTimeout(function() { $( "#onover").css('display', 'none') }, 2500);
    if($(this).attr('data-item') == 1){

        var class_big = $(".asn-gallery").find(".big").attr('class');
        var x = parseInt($(this).css('top'));
        var y = parseInt($(this).css('left'));
        var w = parseInt($(this).css('width'));
        var h = parseInt($(this).css('height'));
        var arr = class_big.split(' ');
        var class_old = $(this).attr('class');
        var mas = class_old.split(' ');
        $("."+arr[0]).effect( "size", {
            to: { width: w, height: h }, origin: ['top','left'], scale: 'box'
        }, 1000, function(){$("."+arr[0]).animate({top: x, left:y}, 1000);
            $("."+arr[0]).removeClass('bl4 big').addClass(mas[1]);} );

        $(this).animate({top: 0, left:0}, 1000);
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','left'], scale: 'box'
        }, 1000, function(){ $(this).removeClass('middle-1').removeClass('small').addClass('big')} );
    }
    else{

        $(".asn-gallery").children().attr('data-item', 1);
        $(this).animate({top: 0, left:0}, 1000)
        $(this).effect( "size", {
            to: { width: w_big, height: h_big}, origin: ['top','right'], scale: 'box'
        }, 1000 );
        $(this).removeClass('bl9').addClass('big');

        /* Блок 1 */
        $(".bl-1").animate({top: 0, left:w_small*4}, 1000);
        $( ".bl-1").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-1" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 2 */
        $(".bl-2").animate({top: h_small*2, left:w_small*4}, 1000);
        $( ".bl-2").effect( "size", {
            to: { width: w_small*2, height: h_small*2 }
        }, 1000, function(){$( ".bl-2" ).removeClass('bl4').removeClass('big').addClass('middle-1')} );

        /* Блок 3 */
        $( ".bl-3").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-3").animate({top: h_small*4, left:w_small*5}, 1000);
            $( ".bl-3" ).removeClass('bl4').removeClass('big').addClass('small')} );

        /* Блок 4 */
        $( ".bl-4").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){ $(".bl-4").animate({top: h_small*4, left:w_small*2}, 1000); $( ".bl-4" ).removeClass('bl4').addClass('small')} );

        /* Блок 5 */
        $( ".bl-5").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-5").animate({top: h_small*4, left:w_small*4}, 1000);$( ".bl-5" ).removeClass('bl4').addClass('small')} );

        /* Блок 6 */
        $( ".bl-6").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-6").animate({top: h_small*4, left:0}, 1000); $( ".bl-6" ).removeClass('bl4').addClass('small')} );

        /* Блок 7 */
        $( ".bl-7").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-7").animate({top: h_small*4, left:w_small}, 1000); $( ".bl-7" ).removeClass('bl4').addClass('small')} );

        /* Блок 8 */
        $( ".bl-8").effect( "size", {
            to: { width: w_small, height: h_small}, origin: ['bottom','right'], scale: 'box'
        }, 1000, function(){$(".bl-8").animate({top: h_small*4, left:w_small*3}, 1000); $( ".bl-8" ).removeClass('bl4').addClass('small');
        });
    }
});

});


/* Прокрутка плавная по кнопакам/меткам*/
// TODO: перенесено в login.js
//jQuery(document).ready(function(){
//    jQuery('.prezent').click(function() {
//
//        jQuery.scrollTo('#sl_1', 1000);
//    });
//    jQuery('.partner').click(function() {
//
//        jQuery.scrollTo('#sl_2', 1000);
//    });
//    jQuery('.go_reg').click(function() {
//
//        jQuery.scrollTo('#sl_3', 1000);
//    });
//});