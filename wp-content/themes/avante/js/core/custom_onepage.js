jQuery(document).ready(function(){ 
	"use strict";
	
	//Desktop menu
	jQuery('#menu-wrapper div .nav li a, .mobile-main-nav li a').on( 'click', function(event){
		var documentScroll = jQuery(document).scrollTop();
		var linkURL = jQuery(this).attr('href');
		var sectionID = jQuery(this).attr('href').substr(1);
	
		if(linkURL.slice(0,1)=='#' && sectionID != '')
		{
			event.preventDefault();
			var topBarHeight = jQuery('.top-menu-bar').height();
			
			if(sectionID=='top')
			{
				jQuery('body,html').animate({scrollTop:0},1200);
			}
			else
			{
				if(documentScroll != 0)
				{
					var scrollToPos = parseInt(jQuery('#'+sectionID).offset().top-topBarHeight);
				}
				else
				{
					var scrollToPos = parseInt(jQuery('#'+sectionID).offset().top-topBarHeight+32);
				}
			
				jQuery('body,html').animate({
				    scrollTop: scrollToPos
				}, 1200);
			}
			
			jQuery('#menu-wrapper div .nav li').removeClass('current-menu-item');
			jQuery(this).parent('li').addClass('current-menu-item');
			
			if(jQuery(window).width() < 960)
			{
				jQuery('body').removeClass('js-nav');
			}
		}
		else
		{
			return true;
		}
	});
	
	jQuery('#menu-wrapper div .nav li a').each(function () {
		var sectionElement = jQuery(this).attr('href');
		
		if(typeof sectionElement != 'undefined' && sectionElement.charAt(0) == '#')
		{
			var topBarHeight = jQuery('.top-menu-bar').height();
		
			jQuery(sectionElement).waypoint(function(direction) {
				jQuery('#menu-wrapper div .nav li a').each(function(){
					if(jQuery(this).attr('href')==sectionElement)
					{
						jQuery('#menu-wrapper div .nav li').removeClass('current-menu-item');
						jQuery(this).parent('li').addClass('current-menu-item');
					}
				})
			}, { offset: topBarHeight });
		}
	});
});