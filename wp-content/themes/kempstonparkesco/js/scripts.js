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
 })
}


$(function(){

var isMobile, isTabletMenu, isMobileMenu,
	$fullPageActive = false;

$(".fancybox").fancybox();




$('#mobile-menu').on('click',function(e){
  e.preventDefault();
  if($(this).hasClass('active')){
    $(this).removeClass('active'); 
    $('#nav ul').slideUp(200);
  } else {
     $(this).addClass('active');
    $('#nav ul').slideDown(200);
  }
});

//nav anchors

$('body').on('click','a.anchor',function(e){
  e.preventDefault();
  var $target = $(this).attr('href')
  
  var animationSpeed = 500;
        $.scrollTo( $target, animationSpeed, {
          easing: 'easeInOutExpo',
          offset: 0
        });
});

scrollToAnchor = function(){
  if(location.hash){
    var _target = location.hash,
        _animationSpeed = 500;
        $.scrollTo( _target, _animationSpeed, {
          easing: 'easeInOutExpo',
          offset: -90
        });
  }
}

$('#front-page #nav ul a').not('#nav ul li.blog a').not('#nav ul a.fancybox').on('click',function(e){
  e.preventDefault();
  var $target = $(this).attr('href'); 
  var $segments = $(this).attr('href').split('/'),
      $last = $segments.length-1,
      $anchor = $segments[$last];
  var animationSpeed = 500;
        $.scrollTo( $anchor, animationSpeed, {
          easing: 'easeInOutExpo',
          offset: -90
        });
});


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


}); 	//end on document load


$(function(){


var $totalPages=0,
    $loadedPages=0,
    $pages = [], //array to hold all page ids
    $loadedObjs = [], //array to hold all the page HTML
    $selector = '.section'; // this is the parent element of the HTML to get from page

 getPages = function($pages){
$.ajax({
    //url: $url,
    url:"?action=ajax_get_pages",
    dataType: 'json',
    timeout: 10000,
   // data: { url: url, firstLoad: $firstLoad} ,
    timeout: 1000,
    success: function(data) {
        loadPages(data);
  
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    },
    complete: function(xhr, textStatus) {
    } 
    }); 

 }



//set page data variables and load first page
loadPages = function(pages){  
    $totalPages = pages.length;
    $loadedPages = 0;
    $pages = pages;
    loadPage($pages[0]); //load the first page
}


loadPage = function($permalink){
$.ajax({
    url: $permalink,
    async: true,
    timeout: 10000,
   // data: { url: url, firstLoad: $firstLoad} ,
    timeout: 1000,
    success: function(data) {
    var $section = $(data).find($selector);
    $('#page').append($section);
    $loadedPages++;
     if($loadedPages < $totalPages){
        var $url = $pages[$loadedPages];
                loadPage($url); //load the next page
              } else {
                   renderPages()
              }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
    },
    complete: function(xhr, textStatus) {
    } 
    }); 

 }

/*
loadPage = function(url){ 
  $.get(url)
        .done(function(data){
           var $section = $(data).find($selector);
    $('#page').append($section);
    $loadedPages++;
     if($loadedPages < $totalPages){
        var $url = $pages[$loadedPages];
                loadPage($url); //load the next page
              } else {
                   renderPages()
              }
         });
    }
*/
renderPages = function(){
  $('.accordion').accordion(); 
  scrollToAnchor();
}

        });
        
        
        
//accordion



