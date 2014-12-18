var isTouchDevice = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isTouchDevice.Android() || isTouchDevice.BlackBerry() || isTouchDevice.iOS() || isTouchDevice.Opera() || isTouchDevice.Windows());
    }
};

//accordion

$.fn.accordion = function(options){
  
  var defaults = {
    handles: 'dt',
    blocks: 'dd'
    };
var options = $.extend(defaults,options);
  return this.each(function(){
    var $this = $(this);
    var $handles = $(options.handles,$this);
    var $blocks = $(options.blocks,$this);
    $blocks.hide();
  $handles.eq(0).addClass('active');
  $blocks.eq(0).slideDown(200);
  $handles.on('click',function(e){
    e.preventDefault();
    if($(this).hasClass('active')){
      $(this).removeClass('active');
      $(this).next(options.blocks).slideUp(100);
    } else {
      $(this).addClass('active');
      $(this).next(options.blocks).slideDown(200);
    }
  })

//
 })

}

$(function(){

var isMobile, isTabletMenu, isMobileMenu,
	$fullPageActive = false;

$(".fancybox").fancybox();

$('.accordion').accordion(); 


$('#mobile-menu').on('click',function(e){
  e.preventDefault();
  if($(this).hasClass('active')){
    $(this).removeClass('active');
    $('#nav ul').slideUp(200);
  } else {
     $(this).addClass('active');
    $('#nav ul').slideDown(200);
  }
})

//nav anchors

$('#nav ul a').not('#nav ul a.fancybox').on('click',function(e){
  e.preventDefault();
  var $target = $(this).attr('href'); 
  var $segments = $(this).attr('href').split('/'),
      $last = $segments.length-1,
      $anchor = $segments[$last];
      console.log($anchor);
  var animationSpeed = 500;
        $.scrollTo( $anchor, animationSpeed, {
          easing: 'easeInOutExpo',
          offset: -90
        });
})


//sticky header

if(!isTouchDevice.any()){

  var stickyHeaderTop= $('#header').offset().top + $('#header').height();
var animating = false;
    $(window).scroll(function(){
    if( $(window).scrollTop() > stickyHeaderTop ) {
      $('body').addClass('fixed');
       if(!animating){
          animating=true;
            stickyHeaderTop= 0;
            $('#nav').css({
               top:'-60px'
            })
    $('#nav').animate({
                        top:'0px'
                      },400,function(){
                        //animating=false;
                      })
                    }
                 } else {
                  animating=false
                  stickyHeaderTop= $('#header').offset().top + $('#header').height();
                   $('body').removeClass('fixed');
                        
                }
       
})
}


}) 	//end on document load


