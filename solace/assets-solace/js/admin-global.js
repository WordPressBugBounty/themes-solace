( function( $ ) {
	// Notice close.
	$( document ).on( 'click', '.notice-solace .notice-dismiss', function() {
		// Hide notice.
		$( '.notice-solace' ).slideUp( 300 );

		$.ajax( {
			url: adminLocalize.ajaxUrl,
			type: 'POST',
			data: {
				action: 'solace_action_dismiss_notice',
				mynonce: adminLocalize.ajaxNonce,
			},
			success( response ) {
				console.log( 'Ajax success:', response );
			},
			error( error ) {
				console.error( 'Ajax error:', error );
			},
		} );
	} );

	// Activating.
	$( document ).on( 'click', '.notice-solace .notice-actions', function() {
		// Event button activating.
		$( '.notice-solace .notice-actions button.starter-templates' ).css( 'display', 'none' );
		$( '.notice-solace .notice-actions button.activating' ).css( 'display', 'flex' );

		$.ajax( {
			url: adminLocalize.ajaxUrl,
			type: 'POST',
			data: {
				action: 'solace_action_activating',
				mynonce: adminLocalize.ajaxNonce,
			},
			success( response ) {
				console.log( 'Ajax success:', response );
				// Event button activating.
				$( '.notice-solace .notice-actions button.starter-templates' ).css( 'display', 'flex' );
				$( '.notice-solace .notice-actions button.activating' ).css( 'display', 'none' );
				window.location = adminLocalize.adminUrl + 'admin.php?page=solace';
			},
			error( error ) {
				console.error( 'Ajax error:', error );
			},
		} );
	} );
}( jQuery ) );
