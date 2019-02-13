/*
#1. home page light box js

*/
$(document).ready(function(){     
   // main slider 
$('.recent-event-slider').slick({
  dots: false,
  infinite: true,
  speed: 500,
  fade: true,  
  autoplay: false,   
  cssEase: 'linear',
  responsive: [
    {
      breakpoint: 1100,
      settings: {        		        
        dots: true		
      }
    }
	]
});

var li = $('.recent-event-slider li').length;
if (li <= 1) {
		$('li').parents('ul.recent-event-slider').addClass('countLi');
	} 
	else {
		$('li').parents('ul.recent-event-slider').removeClass('countLi');
}

// testimonial slider
$('.carousel-inner-testimonials').slick({
  dots: true,
  infinite: true,
  speed: 800,
  arrows: false,
  fade: false,  
  autoplay: true
});
/*
$(".carousel-inner-testimonials").owlCarousel({ 
	navigation : false, 
    slideSpeed : 300,
    autoPlay : true,
	paginationSpeed : 400,
	singleItem:true,
	animateOut: 'fadeOut', 
    touchDrag: true,    
    mouseDrag: false	
});*/

// welcome slider
$('.welcom-hmslide').slick({
  dots: true,
  arrows: false,
  infinite: true,
  cssEase: 'linear',
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [
      {
          breakpoint: 1344,
          settings: {
              dots: false,
              arrows:false,
              slidesToShow: 3,
              slidesToScroll: 1
          }
      },
      {
          breakpoint: 800,
          settings: {
              dots: true,
              arrows:false,
              slidesToShow: 2,
              slidesToScroll: 1
          }
      },
      {
          breakpoint: 480,
          settings: {
              dots: true,
              arrows:false,
              slidesToShow: 1,
              slidesToScroll: 1
          }
      }
  ]
});
// product details accordian

var $accHead, accBodySel, $accBody, plusMinSel, $plusMin;
	$accHead = $(".accordion_head");
	accBodySel = ".accordion_body";
	$accBody = $(accBodySel);
	plusMinSel = ".plusminus";
	$plusMin = $(plusMinSel);

$accHead.click(function () {
        if ($accBody.is(':visible')) {
            $accBody.slideUp(300);           
            $plusMin.addClass("plus");
            $plusMin.removeClass("minus");
            $accHead.removeClass("accordion_active").parent().removeClass('mrless');
        }
        if ($(this).next(accBodySel).is(':visible')) {
            $(this).next(accBodySel).slideUp(300);
            $(this).children(plusMinSel).addClass("plus");
			 $(this).children(plusMinSel).removeClass("minus");
        } else {
            $(this).next(accBodySel).slideDown(300);
            $(this).children(plusMinSel).addClass("minus");
            $(this).children(plusMinSel).removeClass("plus");
            $(this).addClass("accordion_active").parent().addClass('mrless');
        }
});
 


}); // document end


