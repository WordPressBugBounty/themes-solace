/**
 * Customizer font selector control.
 *
 * @package Solace\Customizer\Controlss
 */
( function($) {
	'use strict';
	wp.tiCustomizeButton = {
		init: function() {
			$( '#customize-theme-controls' ).on(
					'click', '.menu-shortcut', function(e) {
						wp.customize.section( 'menu_locations' ).focus();
						e.preventDefault();
					}
			);
			$( '#customize-theme-controls' ).on(
					'click', '.solace-control-focus', function(e) {
						wp.customize.control( $( this ).data( 'control-to-focus' ) ).focus();
						e.preventDefault();
					}
			);
		}
	};

	$( document ).ready(
			function() {
				wp.tiCustomizeButton.init();
			}
	);
} )( jQuery );
