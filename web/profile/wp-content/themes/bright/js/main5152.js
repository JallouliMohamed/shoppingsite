(function($) { 
  'use strict';

  	/**
  	 * Preloader
  	 */

  	$("body").removeClass("xt-site-loading");
  	$(window).on( "load", function() {
		$(".loader").fadeOut(2000);
	});


	/**
	 * Back Top Link
	 */

	var back_to_top_offset = 200;
	var back_to_top_duration = 600;

	$(window).on( "scroll", function() {
		if ($(this).scrollTop() > back_to_top_offset) {
			$('.back-to-top').fadeIn(400);
		} else {
			$('.back-to-top').fadeOut(400);
		}
	});

	$('.back-to-top').on( "click", function() {
		event.preventDefault();
		$('html, body').animate({
			scrollTop: 0
		}, back_to_top_duration );
		return false;
	})

	/**
	 * Ajax Course Search
	 */
 
	$('.bright-course-search-field').keyup(function(event) {
	 
		$(this).attr('autocomplete','off');
		var $button = $(this).parent('.input-group').find('#bright-course-search-btn');
		$button.html('<i class="fa fa-spinner fa-spin fa-fw"></i>');
		var searchTerm = $(this).val();

		if (!searchTerm.trim()) {
            $('.bright-course-ajax-search-result-inner').fadeOut().html("");
            $button.html('<i class="fa fa-search" aria-hidden="true"></i>');
            return;
        }

		if(searchTerm){
			if(searchTerm.length > 2){
				$.ajax({
					url : bright_home_url+'/wp-admin/admin-ajax.php',
					type:"POST",
					data:{
						'action': 'bright_ajax_course_search',
						'term' : searchTerm
					},
					success:function(result){
						$('.bright-course-ajax-search-result-inner').fadeIn().html(result);
						$button.html('<i class="fa fa-search" aria-hidden="true"></i>');
					}
				});
			}
		}
	});

	/* Hide search result on body click */
	$(document).mouseup(function (e){
	    var container = $(".bright-course-ajax-search-result-inner");
	    if ( !container.is(e.target) && container.has(e.target).length === 0 ){
	        container.hide();
	    }
	});


	/**
	* Slick Nav 
	*/

	$('.bright-mobile-menu').slicknav({
		prependTo: '.bright-mobile-menu-wrapper',
		parentTag: 'span',
		allowParentLinks: true,
		duplicate: false,
		label: '',
		closedSymbol: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
		openedSymbol: '<i class="fa fa-angle-down" aria-hidden="true"></i>',
	});


	/**
	 * Remove menu title attribute on hover
	 */
	
	$(".navbar-bright a").hover(function(){
		$(this).data("title", $(this).attr("title")).removeAttr("title");
	});


	/**
	 * Course Slider
	 */
	
	$(".bright-course-slider").each(function() {
	    var t 			= $(this),
        auto 			= t.data("autoplay") ? !0 : !1,
        loop 			= t.data("loop") ? !0 : !1,
        rtl 			= t.data("direction") ? !0 : !1,
        items 			= t.data("items") ? parseInt(t.data("items")) : '',
        desktopsmall 	= t.data("desktopsmall") ? parseInt(t.data("desktopsmall")) : '',
        tablet 			= t.data("tablet") ? parseInt(t.data("tablet")) : '',
        mobile 			= t.data("mobile") ? parseInt(t.data("mobile")) : '',
        nav 			= t.data("navigation") ? !0 : !1,
        pag 			= t.data("pagination") ? !0 : !1,
        navTextLeft 	= t.data("direction") ? 'right' : 'left',
        navTextRight 	= t.data("direction") ? 'left' : 'right';
	        
	    $(this).owlCarousel({
	        autoplay: auto,
	        rtl: rtl,
	        items: items,
	        responsiveClass: true,
	        responsive:{
		    	0:{
		            items: mobile,
		        },
		        480:{
		            items: mobile,
		        },
		        768:{
		            items: tablet,
		        },
		        1170:{
		            1024: desktopsmall,
		        },
		        1200:{
		            items: items,
		        }
		    },
            nav: nav,
            navText : ['<i class="fa fa-arrow-'+navTextLeft+'" aria-hidden="true"></i>','<i class="fa fa-arrow-'+navTextRight+'" aria-hidden="true"></i>'],
            dots: pag,
            loop: loop,
            margin: 0,
	    });
	});


	/**
	 * Course instructor Slider
	 */
	
	$(".bright-instructor-content-type-slider").each(function() {
	    var t = $(this),
	        auto 			= t.data("autoplay") ? !0 : !1,
	        rtl 			= t.data("direction") ? !0 : !1,
	        items 			= t.data("items") ? parseInt(t.data("items")) : '',
	        desktopsmall 	= t.data("desktopsmall") ? parseInt(t.data("desktopsmall")) : '',
	        tablet 			= t.data("tablet") ? parseInt(t.data("tablet")) : '',
	        mobile 			= t.data("mobile") ? parseInt(t.data("mobile")) : '',
	        nav 			= t.data("navigation") ? !0 : !1,
	        pag 			= t.data("pagination") ? !0 : !1,
	        navTextLeft 	= t.data("direction") ? 'right' : 'left',
	        navTextRight 	= t.data("direction") ? 'left' : 'right';
	        
	    // console.log(pag);
	    $(this).owlCarousel({
	        autoPlay: auto,
	        rtl: rtl,
	        items: items,
	        responsiveClass: true,
	        responsive:{
		    	0:{
		            items: mobile,
		        },
		        480:{
		            items: mobile,
		        },
		        768:{
		            items: tablet,
		        },
		        1170:{
		            1024: desktopsmall,
		        },
		        1200:{
		            items: items,
		        }
		    },
            nav: nav,
            navText : ['<i class="fa fa-arrow-'+navTextLeft+'" aria-hidden="true"></i>','<i class="fa fa-arrow-'+navTextRight+'" aria-hidden="true"></i>'],
            dots: pag,
            loop: false,
            margin: 0,
	    });
	});


	/**
	 * Blog post Slider
	 */
	
	$(".bright-post-slider").each(function() {
	    var t = $(this),
	        auto 			= t.data("autoplay") ? !0 : !1,
	        rtl 			= t.data("direction") ? !0 : !1,
	        items 			= t.data("items") ? parseInt(t.data("items")) : '',
	        desktopsmall 	= t.data("desktopsmall") ? parseInt(t.data("desktopsmall")) : '',
	        tablet 			= t.data("tablet") ? parseInt(t.data("tablet")) : '',
	        mobile 			= t.data("mobile") ? parseInt(t.data("mobile")) : '',
	        nav 			= t.data("navigation") ? !0 : !1,
	        pag 			= t.data("pagination") ? !0 : !1,
	        navTextLeft 	= t.data("direction") ? 'right' : 'left',
	        navTextRight 	= t.data("direction") ? 'left' : 'right';
	        
	    // console.log(pag);
	    $(this).owlCarousel({
	        autoPlay: auto,
	        rtl: rtl,
	        items: items,
	        responsiveClass: true,
	        responsive:{
		    	0:{
		            items: mobile,
		        },
		        480:{
		            items: mobile,
		        },
		        768:{
		            items: tablet,
		        },
		        1170:{
		            1024: desktopsmall,
		        },
		        1200:{
		            items: items,
		        }
		    },
            nav: nav,
            navText : ['<i class="fa fa-arrow-'+navTextLeft+'" aria-hidden="true"></i>','<i class="fa fa-arrow-'+navTextRight+'" aria-hidden="true"></i>'],
            dots: pag,
            loop: false,
            margin: 0,
	    });
	});


	/**
	 * Testimonial Slider
	 */

 	$(".testimonials-carousel").each(function() {
    	var t 			= $(this),
        auto 			= t.data("autoplay") ? !0 : !1,
        rtl 			= t.data("direction") ? !0 : !1,
        pag 			= t.data("pagination") ? !0 : !1;
        
	    
	    $(this).owlCarousel({
			autoPlay: auto,
            dots: pag,
            loop: false,
			margin: 20,
			items: 2,
	        responsiveClass: true,
	        responsive:{
		    	0:{
		            items: 1,
		        },
		        480:{
		            items: 1,
		        },
		        768:{
		            items: 1,
		        },
		        1170:{
		            1024: 2,
		        },
		        1200:{
		            items: 2,
		        }
		    },
		});
	});


	/**
	 * Course Slider
	 */
	
	$(".bright-event-slider").each(function() {
	    var t = $(this),
	        auto 			= t.data("autoplay") ? !0 : !1,
	        rtl 			= t.data("direction") ? !0 : !1,
	        items 			= t.data("items") ? parseInt(t.data("items")) : '',
	        desktopsmall 	= t.data("desktopsmall") ? parseInt(t.data("desktopsmall")) : '',
	        tablet 			= t.data("tablet") ? parseInt(t.data("tablet")) : '',
	        mobile 			= t.data("mobile") ? parseInt(t.data("mobile")) : '',
	        nav 			= t.data("navigation") ? !0 : !1,
	        pag 			= t.data("pagination") ? !0 : !1,
	        navTextLeft 	= t.data("direction") ? 'right' : 'left',
	        navTextRight 	= t.data("direction") ? 'left' : 'right';
	        
	    $(this).owlCarousel({
	        autoPlay: auto,
	        rtl: rtl,
	        items: items,
	        responsiveClass: true,
	        responsive:{
		    	0:{
		            items: mobile,
		        },
		        480:{
		            items: mobile,
		        },
		        768:{
		            items: tablet,
		        },
		        1170:{
		            1024: desktopsmall,
		        },
		        1200:{
		            items: items,
		        }
		    },
            nav: nav,
            navText : ['<i class="fa fa-arrow-'+navTextLeft+'" aria-hidden="true"></i>','<i class="fa fa-arrow-'+navTextRight+'" aria-hidden="true"></i>'],
            dots: pag,
            loop: false,
            margin: 0,
	    });
	});


	/**
	 * LMS statistics Counter Up
	 */
	
	if ( $.isFunction($.fn.counterUp) ) {
		$('.bright-counter-number, .bright-counterup .counter, .bright-lms-statistics-item .counter').counterUp({
		    delay: 10,
		    time: 1000
		});
	}	
	
	/**
	 * Adding Classes
	 */

	$('table').addClass('table table-bordered');
	


/* Bootsrap slider carousel
   ========================================================================== */

	$(".xt-main-slider-carousel").each(function() {
		$(this).carousel();

		// $('a[data-slide="prev"]').click(function () {
		//     $(this).carousel('prev');
		// });

		// $('a[data-slide="next"]').click(function () {
		//     $(this).carousel('next');
		// });
	});

/* search toogle
   ========================================================================== */
	var openSearch = $('.open-search'),
    SearchForm = $('.full-search'),
    closeSearch = $('.close-search');

    openSearch.on('click', function(event){
        event.preventDefault();
	    if ( !SearchForm.hasClass('active') ) {
	        SearchForm.fadeIn(300, function(){
	          	SearchForm.addClass('active');
	        } );
	    }
    } );

    closeSearch.on('click', function(event){
        event.preventDefault();

      	SearchForm.fadeOut(300, function(){
        	SearchForm.removeClass('active');
        	$(this).find('input').val('');
        } );
    } );

	
/* Count Time
   ========================================================================== */
	$(".bright-countdown").each( function(){
			var t 		= $(this),
			date_count 	= t.data("count_date");

		$(this).countdown(date_count,function(event){
			var $this = $(this).html(event.strftime(''
			+'<div class="time-entry brt-days"><span>%-D</span> Days</div> '
			+'<div class="time-entry brt-hours"><span>%H</span> Hours</div> '
			+'<div class="time-entry brt-minutes"><span>%M</span> Minutes</div> '
			+'<div class="time-entry brt-seconds"><span>%S</span> Seconds</div> '));
		} );	
	});


	/**
	 * Match Height
	 */

	if ( $.isFunction($.fn.matchHeight) ) {
		$(function(){
			$('.bright-course-grid .bright-course-item').matchHeight();
			$('.bright-course-slider .bright-course-item').matchHeight();
			$('.bright-event-grid .bright-event-item').matchHeight();
			$('.bright-event-slider .bright-event-item').matchHeight();
			$('.archive .lp_course').matchHeight();
		});
	}

	/**
	 * MixitUp PortFolio
	 */

	if ( $.isFunction($.fn.mixItUp) ) {
		$(function(){
			$('.portfolio-list').mixItUp();
		});
	}

	/**
	 * magnificPopup 
	 */
	
	if ( $.isFunction($.fn.magnificPopup) ) {

		$('.portfolio-list').each(function() {
		    $(this).magnificPopup({
		        delegate: '.lightbox',
		        type: 'image',
		        gallery: {
		          enabled:true
		        },
		        mainClass: 'mfp-fade',
		    });
		});

		$('.single-album-content-area').each(function() {
		    $(this).magnificPopup({
		        delegate: 'a.lightbox',
		        type: 'image',
		        gallery: {
		          enabled:true
		        },
		        mainClass: 'mfp-fade',
		    });
		});

		$('.single-lightbox').magnificPopup({
			type: 'image',
			mainClass: 'mfp-fade',
		});


		$('.iframe-lightbox').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});

	}

	  
} )(jQuery);