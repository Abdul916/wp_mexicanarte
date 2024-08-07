/* global kirkiBranding */
jQuery( document ).ready( function() {

	'use strict';

	if ( '' !== kirkiBranding.description ) {
		jQuery( 'div#customize-info > .customize-panel-description' ).replaceWith( '<div class="customize-panel-description">' + kirkiBranding.description + '</div>' );
	}

});
