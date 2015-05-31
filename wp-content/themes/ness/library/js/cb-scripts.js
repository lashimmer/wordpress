var cbWindow = jQuery(window),
	cbWindowHeight = cbWindow.height(),
	cbWindowWidth = cbWindow.width(),
	cbBody = jQuery('body'),
	cbVerticalNavDown = jQuery('.cb-vertical-down'),
	cbSidebarOpen = jQuery('#cb-sidebar-open'),
	cbSidebarClose = jQuery('#cb-sidebar-close'),
	cbOuterContainer = jQuery('#cb-outer-container'),
	cbReadProgress= jQuery('#cb-read-progress'),
	cbNextPrevPosts = jQuery('#cb-next-previous-posts'),
	cbPostFeaturedImage = jQuery('#cb-featured-image'),
	cbHTMLBody = jQuery('html, body'),
	cbToTop = jQuery('#cb-to-top'),
	cbContent = jQuery('#cb-content'),
	cbMain = jQuery('#main'),
	cbProgressBar = jQuery('#cb-progress-bar'),
	cbProgressBarPercent = jQuery('#cb-read-progress-percent'),
	cbPostEntryContent = cbMain.find('.entry-content'),
	cbImagesAlignNone = cbPostEntryContent.find('.alignnone'),
	cbHPBigSlider = jQuery('#cb-hp-slider'),
	cbRecentSlider = jQuery('#cb-recent-slider'),
	cbCaptions = cbPostEntryContent.find('.wp-caption-text'),
	cbGalleryPost = jQuery('.cb-gallery-post'),
	cbPlayButton = jQuery('#cb-play-button'),
	cbPauseButton = jQuery('#cb-close-button'),
	cbMediaEmbedURL = jQuery('#cb-media-embed-url'),
	cbMediaEmbedURLAudio = cbMediaEmbedURL.find('audio'),
	cbPlayButtonVideoID = jQuery('#cbplayer').text(),
	cbSearchPlacholder = jQuery('.cb-search-placeholder'),
	cbNavigationHeight = jQuery('#cb-navigation').height(),
	cbGoingUp = false,
	cbMobileTablet = !!( (navigator.userAgent.match(/IEMobile/i) === true ) || ( navigator.userAgent.match(/Android/i) === true ) || ( navigator.userAgent.match(/BlackBerry/i) === true ) || ( navigator.userAgent.match(/iPhone|iPad|iPod/i) ) || ( navigator.userAgent.match(/Motorola|DROIDX/i) ) || ( navigator.userAgent.match(/Linux/i) ) ),
	cbYTPlayer,
	cbProgressScroll,
	YT,
	cbAdminBar = false,
    cbCheckerI = false,
    cbFlag = false,
    cbWindowScrollTop,
    cbWindowScrollTopCache = 0,
    cbBodyRTL = false;   

    if ( cbBody.hasClass('rtl') ) { cbBodyRTL = true; }
    if ( cbBody.hasClass('admin-bar') ) { cbAdminBar = true; }

	cbGalleryPost.find('img').add(cbPostFeaturedImage).add(cbHPBigSlider).add(cbGalleryPost).css( 'height', cbWindowHeight + 1 );

	if ( cbBody.hasClass('error404') ) {
		cbMain.css( 'height', cbWindowHeight + 1 - cbNavigationHeight );
	}

	if ( cbBody.hasClass('single-format-video') ) {

		var tag = document.createElement('script');
		tag.src = "//www.youtube.com/iframe_api";
		var firstScriptTag = document.getElementsByTagName('script')[0];
		firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	}

	function onYouTubeIframeAPIReady() {
		"use strict";

	    cbYTPlayer = new YT.Player('cbplayer', {
	        height: '390',
	        width: '640',
	        videoId: cbPlayButtonVideoID
	    });
	}

(function($) {

	"use strict";

	cbWindow.on('backstretch.after', function () {
		cbPostFeaturedImage.removeClass('cb-background-preload').find('.cb-meta-data').addClass('cb-ani-fade-in-1-5s');
	});

	cbSearchPlacholder.click( function() {
		var cbThis = $(this),
			cbThisInput = $(this).next();

		cbThisInput.fadeIn('200').focus();
		cbThisInput.focusout(function() { 
			cbThisInput.hide();
			cbThisInput.prev().fadeIn('200');
		});
		cbThis.hide();
	});

	var cbParallaxImg = $('#cb-par-wrap').find('.cb-image');

    function cbOnScroll() {

         if ( cbAdminBar === true ) {
            if ( cbWindowWidth > 781 ) {
                cbWindowScrollTop = cbWindow.scrollTop() + 32;
            } else {
                cbWindowScrollTop = cbWindow.scrollTop() + 46;
            }
        } else {
            cbWindowScrollTop = cbWindow.scrollTop();
        }

        cbChecker();

    }

    function cbChecker() {
        
        if ( ! cbCheckerI ) {
            requestAnimationFrame(cbScrolls);
            cbCheckerI = true;
        }
    }

    function cbScrolls() {

        if ( ( cbParallaxImg.length !== 0 ) && ( cbMobileTablet === false ) ) {

            if ( cbWindowScrollTop <  cbWindowHeight ) {
                cbBody.removeClass('cb-par-hidden');
                if ( cbAdminBar === true) {
                    cbWindowScrollTop = cbWindowScrollTop - 32;
                }

                var cbyPos = -( ( cbWindowScrollTop / 2    ) ),
                    cbCoords = cbyPos + 'px';

                    $('#cb-par-wrap').css({ '-webkit-transform': 'translate3d(0, ' + cbCoords + ', 0)', 'transform': 'translate3d(0, ' + cbCoords + ', 0)' });
            } else {
                cbBody.addClass('cb-par-hidden');
            }

        }

        cbCheckerI = false;
    }

    window.addEventListener( 'scroll', cbOnScroll, false );

    $('#cb-main-nav-container').find('.menu-item').hover(function() {

        $(this).find('.sub-menu').stop().css( 'opacity', 0 ).slideDown('fast').animate( { opacity: 1 }, { duration: 'slow', queue: false } );

    }, function() {

       $(this).find('.sub-menu').stop().slideUp('fast');

    });
	
	cbSidebarOpen.click( function(e) {

		e.preventDefault();
		cbReadProgress.add(cbNextPrevPosts).hide();
		cbBody.addClass('cb-modal-open');
		cbOuterContainer.append('<span id="cb-sidebar-open-overlay"></span>');

	});

	cbSidebarClose.click( function(e) {

		e.preventDefault();
		cbSidebarOpen.add(cbReadProgress).fadeIn();
		cbBody.removeClass('cb-modal-open');
		$('#cb-sidebar-open-overlay').remove();

	});

	cbImagesAlignNone.each( function() {

		if ( ! cbBody.hasClass( 'cb-sb' ) ) {
			var cbThis = $(this);

			if ( cbThis.hasClass('wp-caption') ) {

				cbThis.css( { 'margin-left': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none' });
				cbThis.add(cbThis.find('img')).css( 'width', cbWindowWidth);

			} else {

				cbThis.css( { 'margin-left': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none', 'width': cbWindowWidth });

			}
		}

	});

	cbWindow.resize(function() {
		cbImagesAlignNone.each( function() {
			if ( ! cbBody.hasClass( 'cb-sb' ) ) {

				var cbThis = $(this);
				cbWindowWidth = cbWindow.width();

				if ( cbThis.hasClass('wp-caption') ) {

					cbThis.css( { 'margin-left': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none' });
					cbThis.add(cbThis.find('img')).css( 'width', cbWindowWidth);

				} else {

					cbThis.css( { 'margin-left': ( ( cbPostEntryContent.width() / 2 ) - ( cbWindowWidth / 2 ) ), 'max-width': 'none', 'width': cbWindowWidth });

				}
			}

		});
	});
	cbCaptions.each( function() {

		var cbThis = $(this),
			cbThisText = cbThis.text();

			cbThis.prev().attr( 'title', cbThisText );
	});

	var cbReady = true,
		cbInfiniteScroll = $('#cb-blog-infinite-scroll');

    if ( cbInfiniteScroll.length ) {

        cbWindow.scroll(function() {

            if ( cbReady === true ) {

                var cbLastChild = $('#main').children().last(),
                    cbLastChildID = cbLastChild.attr('id'),
                    cbLastArticle = cbLastChild.prev();

                if ( ( cbLastChildID === 'cb-blog-infinite-scroll' ) && ( cbLastArticle.visible( true ) ) ) {

                    cbReady = false;

                    var cbCurrentPagination = $('#cb-blog-infinite-scroll').find('a').attr('href');
                    cbMain.addClass('cb-loading');

                    $.get( cbCurrentPagination, function( data ) {

                        var cbExistingPosts, cbExistingPostsRaw;

                        cbExistingPostsRaw = $(data).filter('#cb-outer-container').find('#main');
                        $(cbExistingPostsRaw).find('.cb-category-top').remove();
                        cbExistingPosts = cbExistingPostsRaw.html();


                        $('#main').children().last().remove();
                        $('#main').append(cbExistingPosts);
                        cbMain.removeClass('cb-loading');

                    });

                }

            }

        });
    }

    $( document ).ajaxStop(function() {
    	cbReady = true;
    });

	cbContent.on('click', '#cb-blog-infinite-load a', function( event ){

        event.preventDefault();
        var cbCurrentPagination = $(this).attr( 'href' ),
        	cbCurrentParent = $(this).parent();

        cbMain.addClass( 'cb-loading' );
        $(this).replaceWith('<i class="fa fa-refresh fa-spin"></i>');

        $.get( cbCurrentPagination, function( data ) {

            var cbExistingPosts, cbExistingPostsRaw;

            cbExistingPostsRaw = $(data).filter('#cb-outer-container').find('#main');

            $(cbExistingPostsRaw).find('.cb-category-top').remove();

            $(cbExistingPostsRaw).children().addClass( 'cb-slide-visible' );
            cbExistingPosts = cbExistingPostsRaw.html();

            $('#main').append(cbExistingPosts);
            cbMain.removeClass('cb-loading');
            cbCurrentParent.addClass( 'cb-hidden' );

        });

    });

	cbToTop.click( function( event ) {

		event.preventDefault();

		cbHTMLBody.animate( {scrollTop: 0 }, 1500 );

	});

	cbVerticalNavDown.click( function( event ) {

		event.preventDefault();
		cbGoingUp = true;
		cbHTMLBody.animate({
	        scrollTop: cbMain.offset().top
	    }, 1500);
	    
	});

	cbHTMLBody.on( 'mousewheel DOMMouseScroll', function() {

		cbHTMLBody.stop();

	});

	cbWindow.load(function() {

		var cbMainOffset = cbMain.offset().top,
			cbWindowScrollTop = cbWindow.scrollTop();

		if ( cbPostEntryContent.length > 0 ) {
			var cbTopPostContent = ( cbPostEntryContent.offset().top ) / 1.2,
				cbBottomPostContent = cbPostEntryContent.outerHeight(),
				cbBottomPostContentAndTop = cbTopPostContent * 2 + cbBottomPostContent;
		}

		if ( ! cbBody.hasClass( 'stickyoff' ) ) {

			if ( cbWindowScrollTop > cbWindowHeight ) {

				cbBody.addClass('cb-stuck');

			} else {
				cbBody.removeClass('cb-stuck');
			}
		}

		function cbNavBarAni(){

			cbWindowScrollTop = cbWindow.scrollTop();
			cbProgressScroll = ( cbWindowScrollTop - ( cbTopPostContent  ) ) / ( cbBottomPostContentAndTop - ( cbTopPostContent * 2 ) ) * 100;

			if ( ( cbProgressScroll < 101 ) && ( cbProgressScroll > 0 ) ) {

				cbProgressBar.attr( 'value', cbProgressScroll );
				cbProgressBarPercent.html( Math.floor( cbProgressScroll ) + '%' );
				cbNextPrevPosts.hide();
				cbReadProgress.show();

			} else if ( cbProgressScroll > 101 ) {

				cbNextPrevPosts.show();
				cbReadProgress.hide();

			} else {
				if ( ! cbBody.hasClass( 'stickyoff' ) ) {
					cbReadProgress.hide();
				}
				cbNextPrevPosts.hide();
				
				cbProgressBar.attr( 'value', '0' );
				cbProgressBarPercent.html( '0%' );

			}

			if ( ! cbBody.hasClass( 'stickyoff' ) ) {

				if ( cbWindowScrollTop > cbMainOffset ) {

					cbBody.addClass('cb-stuck');

				} else {
					cbBody.removeClass('cb-stuck');
				}
			}
		}

		cbNavBarAni();

		cbWindow.scroll( function() {

			cbNavBarAni();

		});

		cbSidebarClose.click( function() {

			cbNavBarAni();

		});

		$(document).on( 'click tap touch', '#cb-sidebar-open-overlay', function(e){

			e.preventDefault();
			cbNavBarAni();
			cbBody.removeClass('cb-modal-open');
			$(this).remove();

		});

		 cbRecentSlider.flexslider({
			maxItems: 1,
			minItems: 1,
			controlNav: false,
			nextText: '<i class="fa fa-angle-right"></i>',
	    	prevText: '<i class="fa fa-angle-left"></i>',
	    	start: function(slider) {
	        	var cbSliderHeight = slider.outerHeight(true);
	        	slider.css('height', cbSliderHeight);

	        },
	    });

		cbGalleryPost.flexslider({
		    nextText: '<i id="cb-gallery-next" class="fa fa-angle-right"></i>',
		    prevText: '<i id="cb-gallery-prev" class="fa fa-angle-left"></i>',
		    animation: "slide",
	        controlNav: false,
		    itemMargin: 5,
	        slideshow: false,
	        variableImageWidth: true,
	        start: function() {
				cbPostFeaturedImage.removeClass('cb-background-preload').find('.cb-meta-data').addClass('cb-ani-fade-in-1-5s');
	        },
	        
		});

		var cbGalleryPostArrows = cbGalleryPost.find('#cb-gallery-next, #cb-gallery-prev').parent();

		cbGalleryPostArrows.hover( function() {

			cbGalleryPost.toggleClass('cb-arrows-hover');

		});

		if ( cbMobileTablet === true ) {

			cbGalleryPostArrows.on('tap', function(){
				
				cbGalleryPost.addClass('cb-arrows-hover');

			});
			var cbGalleryImgs = cbGalleryPost.find('.cb-link-overlay');
			cbGalleryImgs.on('tap', function(){
				
				cbGalleryPost.removeClass('cb-arrows-hover');

			});

			cbGalleryImgs.on('swipe', function(){
				
				cbGalleryPost.addClass('cb-arrows-hover');

			});

		}

	});

	cbMain.find('iframe[src^="//www.yo"]').wrap('<div class="cb-video-frame"></div>');
    cbMain.find('iframe[src^="http://www.yo"]').wrap('<div class="cb-video-frame"></div>');
    cbMain.find('iframe[src^="https://www.yo"]').wrap('<div class="cb-video-frame"></div>');
    cbMain.find('iframe[src^="//player.vimeo"]').wrap('<div class="cb-video-frame"></div>');
    cbMain.find('iframe[src^="http://www.dailymotion"]').wrap('<div class="cb-video-frame"></div>');

})(jQuery);

jQuery(document).ready(function($) {

	"use strict";
	$('.cb-video-frame').fitVids();
	$('img[data-retina-src]').retinaDisplay();

	function cbPlayYTVideo() {
	    cbYTPlayer.playVideo();
	}

	function cbPauseYTVideo() {
	    cbYTPlayer.pauseVideo();
	}

	if ( cbMediaEmbedURL.length > 0 ) {

		cbPlayButton.on( 'click', function() {

			cbPostFeaturedImage.addClass('cb-media-playing');
			cbMediaEmbedURL.fadeIn(750);

			if ( cbPlayButtonVideoID.length > 0 ) {
				if ( ( cbMobileTablet === false ) ) {
			        cbPlayYTVideo();
			    }

	    	} else if ( cbMediaEmbedURLAudio.length > 0 ) {

	    		cbMediaEmbedURLAudio[0].play();

	    	}

		});

		cbPauseButton.on( 'click', function() {

			cbPostFeaturedImage.removeClass('cb-media-playing');
			cbMediaEmbedURL.fadeOut(500);

			if ( cbPlayButtonVideoID.length > 0 ) {
				if ( ( cbMobileTablet === false ) ) {
			        cbPauseYTVideo();
			    }
	    	} else if ( cbMediaEmbedURLAudio.length > 0 ) {

	    		cbMediaEmbedURLAudio[0].pause();

	    	}

		});

    }

	cbHPBigSlider.flexslider({
		maxItems: 1,
		minItems: 1,
		nextText: '<i class="fa fa-angle-right"></i>',
    	prevText: '<i class="fa fa-angle-left"></i>',
    });
	

	cbPostEntryContent.find('a').has('img').each(function () {


        var cbImgTitle = $('img', this).attr( 'title' ),
            cbAttr = $(this).attr('href'),
            cbWooLightbox = $(this).attr('rel');

        if (typeof cbImgTitle !== 'undefined') {
            $(this).attr('title', cbImgTitle);
        }

        if ( ( typeof cbAttr !== 'undefined' )  && ( cbWooLightbox !== 'prettyPhoto[product-gallery]' ) ) {
            var cbHref = cbAttr.split('.');
            var cbHrefExt = $(cbHref)[$(cbHref).length - 1];

            if ((cbHrefExt === 'jpg') || (cbHrefExt === 'jpeg') || (cbHrefExt === 'png') || (cbHrefExt === 'gif') || (cbHrefExt === 'tif')) {
                $(this).addClass('cb-lightbox');
            }
        }

    });

    $('.tiled-gallery, .gallery').find('a').attr('rel', 'tiledGallery');

    // Fire up LightBox
    if ( !!$.prototype.boxer ) {
        $(".cb-lightbox").boxer({
                duration: 400,
                fixed: true,
        });
    }

}); /* end of as page load scripts */


/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT License.
*/
(function(w){
	"use strict";
	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && navigator.userAgent.indexOf( "AppleWebKit" ) > -1 ) ){ return; }
	var doc = w.document;
	if( !doc.querySelector ){ return; }
	var meta = doc.querySelector( "meta[name=viewport]" ),
		initialContent = meta && meta.getAttribute( "content" ),
		disabledZoom = initialContent + ",maximum-scale=1",
		enabledZoom = initialContent + ",maximum-scale=10",
		enabled = true,
		x, y, z, aig;
	if( !meta ){ return; }
	function restoreZoom(){
		meta.setAttribute( "content", enabledZoom );
		enabled = true; }
	function disableZoom(){
		meta.setAttribute( "content", disabledZoom );
		enabled = false; }
	function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );
		// If portrait orientation and in one of the danger zones
		if( !w.orientation && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){ disableZoom(); } }
		else if( !enabled ){ restoreZoom(); } }
	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );
})( this );