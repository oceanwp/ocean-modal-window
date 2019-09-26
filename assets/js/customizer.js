/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Declare vars
	var api = wp.customize;

	api( 'omw_custom_width', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_custom_width' );
			if ( to ) {
				var style = '<style class="customizer-omw_custom_width">.omw-modal{width: ' + to + 'px;}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_custom_height', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_custom_height' );
			if ( to ) {
				var style = '<style class="customizer-omw_custom_height">.omw-modal{height: ' + to + 'px;}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_background_image', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_background_image' );
			if ( to ) {
				var style = '<style class="customizer-omw_background_image">.omw-modal{background-image: url(' + to + '); background-position: center center; background-repeat: no-repeat; background-size: cover;}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_padding' );
			if ( to ) {
				var style = '<style class="customizer-omw_padding">.omw-modal{padding: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_border_width', function( value ) {
		value.bind( function( to ) {
			$( '.omw-modal' ).css( 'border-width', to );
		} );
	} );

	api( 'omw_border_type', function( value ) {
		value.bind( function( to ) {
			$( '.omw-modal' ).css( 'border-style', to );
		} );
	} );

	api( 'omw_modal_border_color', function( value ) {
		value.bind( function( to ) {
			$( '.omw-modal' ).css( 'border-color', to );
		} );
	} );

	api( 'omw_border_radius', function( value ) {
		value.bind( function( to ) {
			$( '.omw-modal' ).css( 'border-radius', to );
		} );
	} );

	api( 'omw_overlay_bg', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_overlay_bg' );
			if ( to ) {
				var style = '<style class="customizer-omw_overlay_bg">.omw-modal-overlay{background-color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_overlay_opacity', function( value ) {
		value.bind( function( to ) {
			$( '.omw-modal-overlay' ).css( 'opacity', to );
		} );
	} );

	api( 'omw_modal_bg', function( value ) {
		value.bind( function( to ) {
			$( '.omw-modal' ).css( 'background-color', to );
		} );
	} );

	api( 'omw_modal_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.omw-modal' ).css( 'color', to );
		} );
	} );

	api( 'omw_modal_title_color', function( value ) {
		value.bind( function( to ) {
			$( '.omw-modal h2' ).css( 'color', to );
		} );
	} );

	api( 'omw_modal_close_btn_bg', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_modal_close_btn_bg' );
			if ( to ) {
				var style = '<style class="customizer-omw_modal_close_btn_bg">.omw-modal .omw-close-modal{background-color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_modal_close_btn_hover_bg', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_modal_close_btn_hover_bg' );
			if ( to ) {
				var style = '<style class="customizer-omw_modal_close_btn_hover_bg">.omw-modal .omw-close-modal:hover{background-color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_modal_close_btn_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_modal_close_btn_color' );
			if ( to ) {
				var style = '<style class="customizer-omw_modal_close_btn_color">.omw-modal .omw-close-modal:before,.omw-modal .omw-close-modal:after{background-color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_modal_close_btn_hover_color', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_modal_close_btn_hover_color' );
			if ( to ) {
				var style = '<style class="customizer-omw_modal_close_btn_hover_color">.omw-modal .omw-close-modal:hover:before,.omw-modal .omw-close-modal:hover:after{background-color: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_font_size', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_font_size' );
			if ( to ) {
				var style = '<style class="customizer-omw_font_size">.omw-modal{font-size: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_font_family', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				var idfirst = ( to.trim().toLowerCase().replace( ' ', '-' ), 'customizer-omw_font_family' );
				var fontUrl = to.replace( ' ', '%20' );
				fontUrl = fontUrl.replace( ',', '%2C' );
				fontUrl = oceanModalWindow.googleFontsUrl + '/css?family=' + to + ':300italic,400italic,600italic,700italic,800italic,400,300,600,700,800';
				if ( $( '#' + idfirst ).length ) {
					$( '#' + idfirst ).attr( 'href', fontUrl );
				} else {
					$( 'head' ).append( '<link id="' + idfirst + '" rel="stylesheet" type="text/css" href="' + fontUrl + '">' );
				}
			}
			var $child = $( '.customizer-omw_font_family' );
			if ( to ) {
				var style = '<style class="customizer-omw_font_family">.omw-modal{font-family: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_font_weight', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_font_weight' );
			if ( to ) {
				var style = '<style class="customizer-omw_font_weight">.omw-modal{font-weight: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_font_style', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_font_style' );
			if ( to ) {
				var style = '<style class="customizer-omw_font_style">.omw-modal{font-style: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_text_transform', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_text_transform' );
			if ( to ) {
				var style = '<style class="customizer-omw_text_transform">.omw-modal{text-transform: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_line_height', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_line_height' );
			if ( to ) {
				var style = '<style class="customizer-omw_line_height">.omw-modal{line-height: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_letter_spacing', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_letter_spacing' );
			if ( to ) {
				var style = '<style class="customizer-omw_letter_spacing">.omw-modal{letter-spacing: ' + to + ';}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_tablet_custom_width', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_tablet_custom_width' );
			if ( to ) {
				var style = '<style class="customizer-omw_tablet_custom_width">@media (max-width: 1023px) {.omw-modal{width: ' + to + 'px;}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_tablet_custom_height', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_tablet_custom_height' );
			if ( to ) {
				var style = '<style class="customizer-omw_tablet_custom_height">@media (max-width: 1023px) {.omw-modal{height: ' + to + 'px;}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_tablet_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_tablet_padding' );
			if ( to ) {
				var style = '<style class="customizer-omw_tablet_padding">@media (max-width: 1023px) {.omw-modal{padding: ' + to + ';}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_tablet_font_size', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_tablet_font_size' );
			if ( to ) {
				var style = '<style class="customizer-omw_tablet_font_size">@media (max-width: 1023px) {.omw-modal{font-size: ' + to + ';}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_tablet_line_height', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_tablet_line_height' );
			if ( to ) {
				var style = '<style class="customizer-omw_tablet_line_height">@media (max-width: 1023px) {.omw-modal{line-height: ' + to + ';}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_tablet_letter_spacing', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_tablet_letter_spacing' );
			if ( to ) {
				var style = '<style class="customizer-omw_tablet_letter_spacing">@media (max-width: 1023px) {.omw-modal{letter-spacing: ' + to + ';}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_mobile_custom_width', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_mobile_custom_width' );
			if ( to ) {
				var style = '<style class="customizer-omw_mobile_custom_width">@media (max-width: 767px) {.omw-modal{width: ' + to + 'px;}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_mobile_custom_height', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_mobile_custom_height' );
			if ( to ) {
				var style = '<style class="customizer-omw_mobile_custom_height">@media (max-width: 767px) {.omw-modal{height: ' + to + 'px;}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_mobile_padding', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_mobile_padding' );
			if ( to ) {
				var style = '<style class="customizer-omw_mobile_padding">@media (max-width: 767px) {.omw-modal{padding: ' + to + ';}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_mobile_font_size', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_mobile_font_size' );
			if ( to ) {
				var style = '<style class="customizer-omw_mobile_font_size">@media (max-width: 767px) {.omw-modal{font-size: ' + to + ';}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_mobile_line_height', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_mobile_line_height' );
			if ( to ) {
				var style = '<style class="customizer-omw_mobile_line_height">@media (max-width: 767px) {.omw-modal{line-height: ' + to + ';}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );

	api( 'omw_mobile_letter_spacing', function( value ) {
		value.bind( function( to ) {
			var $child = $( '.customizer-omw_mobile_letter_spacing' );
			if ( to ) {
				var style = '<style class="customizer-omw_mobile_letter_spacing">@media (max-width: 767px) {.omw-modal{letter-spacing: ' + to + ';}}</style>';
				if ( $child.length ) {
					$child.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			} else {
				$child.remove();
			}
		} );
	} );
	
} )( jQuery );
