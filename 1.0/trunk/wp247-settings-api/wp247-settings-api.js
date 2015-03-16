/*
 * wp247 Settings API Javascript to handle Tab Navigation
*/
jQuery( document ).ready( function($)
{
	//Initiate Color Picker
	$( '.wp-color-picker-field' ).wpColorPicker();

	// Switches option sections
	$( '.wp247sapi_form' ).hide();
	var active_tab = '';
	if ( typeof( localStorage ) != 'undefined' )
	{
		active_tab = localStorage.getItem( 'active_tab' );
	}
	if ( active_tab != '' && $( active_tab ).length )
	{
		$( active_tab ).fadeIn( 100 );
	}
	else
	{
		$( '.wp247sapi_form:first' ).fadeIn( 100 );
	}
	$( '.wp247sapi_form .collapsed' ).each(function()
	{
		$(this).find( 'input:checked' ).parent().parent().parent().nextAll().each(
		function()
		{
			if ( $(this).hasClass( 'last' ) )
			{
				$(this).removeClass( 'hidden' );
				return false;
			}
			$( this ).filter( '.hidden' ).removeClass( 'hidden' );
		});
	});

	if ( active_tab != '' && $( active_tab + '-tab' ).length )
	{
		$( active_tab + '-tab' ).addClass( 'nav-tab-active' );
	}
	else
	{
		$( '.nav-tab-wrapper a:first' ).addClass( 'nav-tab-active' );
	}
	$( '.nav-tab-wrapper a' ).click( function( evt )
	{
		$( '.nav-tab-wrapper a' ).removeClass( 'nav-tab-active' );
		$( this ).addClass( 'nav-tab-active' ).blur();
		var active_form = $( this ).attr( 'href' );
		if ( typeof( localStorage)  != 'undefined' )
		{
			localStorage.setItem( 'active_tab', $( this ).attr( 'href' ) );
		}
		$( '.wp247sapi_form' ).hide();
		$( active_form ).fadeIn( 100 );
		evt.preventDefault();
	} );

	var file_frame = null;
	$( '.wpsa-browse' ).on( 'click', function ( event ) {
		event.preventDefault();

		var self = $( this );

		// If the media frame already exists, reopen it.
		if ( file_frame )
		{
			file_frame.open();
			return false;
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media( {
			title: self.data( 'uploader_title' ),
			button: {
				text: self.data( 'uploader_button_text' ),
			},
			multiple: false
		} );

		file_frame.on( 'select', function () {
			attachment = file_frame.state().get( 'selection' ).first().toJSON();

			self.prev( '.wpsa-url' ).val( attachment.url );
		} );

		// Finally, open the modal
		file_frame.open();
	} );
} );