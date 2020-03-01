jQuery(function($){
	/*
	 * Select/Upload image(single) event
	 */
	$('body').on('click', '.seo-tags-upload-img-button', function(e){
		e.preventDefault();
 
    		var button = $( this ),
    		    custom_uploader = wp.media({
					title: seo_tags_image_input.title,
					library : {
						type : 'image'
					},
					button: {
						text: seo_tags_image_input.btn_text 
					},
					multiple: false 
				}).on( 'select', function() { 
					var attachment = custom_uploader.state().get( 'selection' ).first().toJSON();
					var container = $( button ).parent();
					
					container.find( "input[type=hidden]" ).val( attachment.id );
					container.find( "img" ).attr( "src", attachment.url );
					container.find( "img" ).css( "display", "block" );
				})
				.open();
	});
	$('body').on('click', '.seo-tags-delete-img-button', function(e){
		$( this ).parent().find( "input[type=hidden]" ).val( "" );

		$( this ).parent().find( "img" ).attr( "src", "" ).css( "display", "none" );
	});
 
});