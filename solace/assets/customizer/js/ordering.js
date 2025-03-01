/**
 * Customizer order control.
 *
 * @package Solace\Customizer\Controls
 */
( function ( $ ) {
	'use strict';
	wp.solaceOrderControl = {
		init: function () {
			this.setupSorting();
			this.handleHide();
		},
		setupSorting: function () {
			var self = this;
			$( '.ti-order-sortable' ).each( function () {
				$( this ).sortable( {
					revert: true,
					axis: 'y',
					containment: 'parent',
					update: function () {
						self.updateOrder( this );
					},
				} );
			} );
		},
		updateOrder: function ( control ) {
			var value = [];
			var items = $( control ).find( 'li.enabled' );
			$( items ).each( function () {
				value.push( $( this ).data( 'id' ) );
			} );
			value = value.filter(function( element ) {
				return element !== undefined;
			});
			$( control ).next().val( JSON.stringify( value ) );
			$( control ).next().trigger( 'change' );
		},
		handleHide: function () {
			var self = this;
			$( '.toggle-display' ).on( 'click touchstart', function () {
				$( this ).parent().toggleClass( 'enabled' );
				self.updateOrder( $( this ).closest( '.ti-order-sortable' ) );
			} );
		}
	};

	$( document ).ready(
		function () {
			wp.solaceOrderControl.init();
		}
	);
} )( jQuery );
