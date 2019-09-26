var $j = jQuery.noConflict();

$j( document ).on( 'ready', function() {
	"use strict";
	// Carousel
	oceanwpInitModal();
} );

/* ==============================================
MODAL
============================================== */
function oceanwpInitModal() {
	"use strict"

	$j( '.omw-open-modal, .omw-open-modal a, .omw-open-modal a.elementor-button, li.sidr-class-omw-open-modal > a' ).on( 'click', function( e ) {
		e.preventDefault();

		var $target = $j( this ).attr( 'href' );

		if ( ! $j( $target ).length ) {

			return;

		} else {

			var $body = $j( $target ).attr( 'id' );

			// Add modal ID in body class for the overlay background
			$j( 'body' ).addClass( $body );

			// Display overlay
			$j( '.omw-modal-overlay' ).fadeIn( 300 );

			// Display modal
			$j( $target ).fadeIn( 300 );

			// Close modal
			$j( '.omw-modal-overlay, .omw-close-modal' ).on( 'click', function( e ) {
				e.preventDefault();

				oceanwpCloseModal( $target );

			} );

		}

		$j( window ).on( 'keyup', function( e ) {

			// Close modal on esc key
			if ( e.keyCode == 27 ) {
				oceanwpCloseModal( $target );
			}

		} );

	} );

	// Close when clicking modal link in mobile menu
	if ( typeof oceanwpLocalize.sidrSource !== 'undefined' ) {

		$j( 'li.sidr-class-omw-open-modal > a' ).on( 'click', function( e ) {
			e.preventDefault();
			$j.sidr( 'close', 'sidr' );
			initModal();
		} );

	}

	// Custom scrollbar
	if ( ! navigator.userAgent.match( /(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/ ) ) {
		$j( '.omw-modal' ).niceScroll( {
			autohidemode		: false,
			cursorborder		: 0,
			cursorborderradius	: 0,
			cursorcolor			: 'transparent',
			cursorwidth			: 0,
			horizrailenabled	: false,
			mousescrollstep		: 40,
			scrollspeed			: 60,
			zindex				: 100005,
		} );
	}

	// Close modal
	function oceanwpCloseModal( $target ) {

		var $body = $j( $target ).attr( 'id' );

		// Remove body class
		setTimeout( function() {
			$j( 'body' ).removeClass( $body );
        }, 300);

		// Hide overlay
		$j( '.omw-modal-overlay' ).fadeOut( 300 );

		$j( $target ).fadeOut( 300 );

		// Stop video
		var $iframes = $j( $target ).find( 'iframe' );
		if ( $iframes ) {
			$iframes.each( function( index, iframe ) {
				$j( iframe ).attr( 'src', $j( iframe ).attr( 'src' ) );
			} );
		}

	}

}