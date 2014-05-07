(function( $ ) {
	var CustomareaControl;

	CustomareaControl = wp.customize.Control.extend({
		ready: function() {
			var textarea;
			textarea = new wp.customize.Element( this.container.find( 'textarea' ), this.setting() );
			textarea.sync( this.setting );
		}
	});

	wp.customize.controlConstructor.customarea = CustomareaControl;
	
}( jQuery ));