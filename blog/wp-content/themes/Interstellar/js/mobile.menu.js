jQuery(document).ready(function() {

// Responsive Menu
$menu = jQuery('ul.nav');
$mobile_menu_button = jQuery('#mobile_nav');

$menu.clone().attr('id','mobile_menu').removeClass().appendTo( $mobile_menu_button );
$cloned_nav = $mobile_menu_button.find('> ul');

$mobile_menu_button.click( function(){
	
	if ( jQuery(this).hasClass('closed') ){
		jQuery(this).removeClass( 'closed' ).addClass( 'opened' );
		$cloned_nav.slideDown( 100 );
	} else {
		jQuery(this).removeClass( 'opened' ).addClass( 'closed' );
		$cloned_nav.slideUp( 100 );
	}
	return false;
} );

$mobile_menu_button.find('a').click( function(event){
	event.stopPropagation();
} );

});