(function($) {
	$(document).ready( function() {
		$( '#twttr_settings_form input' ).bind( "change click select", function() {
			if ( $( this ).attr( 'type' ) != 'submit' ) {
				$( '.updated.fade' ).css( 'display', 'none' );
				$( '#twttr_settings_notice' ).css( 'display', 'block' );
			};
		});
		$( '#twttr_settings_form select' ).bind( "change", function() {
			$( '.updated.fade' ).css( 'display', 'none' );
			$( '#twttr_settings_notice' ).css( 'display', 'block' );
		});
	});
})(jQuery);