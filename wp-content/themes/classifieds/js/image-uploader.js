jQuery(document).ready(function($){

	function handle_images( frameArgs, callback ){
		var SM_Frame = wp.media( frameArgs );

		SM_Frame.on( 'select', function() {

			callback( SM_Frame.state().get('selection') );
			SM_Frame.close();
		});

		SM_Frame.open();	
	}

	$(document).on( 'click', '.featured-image', function(e) {
		e.preventDefault();

		var frameArgs = {
			multiple: false,
			title: 'Select Featured Image'
		};

		handle_images( frameArgs, function( selection ){
			model = selection.first();
			$('#ad_featured_image').val( model.id );
			var img = model.attributes.url;
			var ext = img.substring(img.lastIndexOf('.'));
			img = img.replace( ext, '-150x150'+ext );
			$('.featured-image-wrap').html( '<img src="'+img+'" class="img-responsive"/>' );
		});
	});


	/* DEAL IMAGES */
	$(document).on( 'click', '.ad-images', function(e) {
		e.preventDefault();

		$('.ad-images-wrap').sortable({
			revert: false,
		});			

		var frameArgs = {
			multiple: true,
			title: 'Select Deal Images'
		};

		handle_images( frameArgs, function( selection ){
			var images = selection.toJSON();
			if( images.length > 0 ){
				var max = images.length;
				if( classifieds_data.ads_max_images ){
					if( ( $('.ad-images-wrap input').length + images.length ) >= classifieds_data.ads_max_images ){
						max = classifieds_data.ads_max_images - $('.ad-images-wrap input').length;
					}
				}
				for( var i = 0; i < max; i++ ){
					var img = images[i].url;
					$('.ad-images-wrap').append( '<div class="ad-image-wrap"><img src="'+img+'" class="img-responsive width-150"/><a href="javascript:;" class="remove-ad-image"><i class="fa fa-close"></i></a><input type="hidden" value="'+images[i].id+'" name="ad_images[]"></div>' );
				}
			}
		});
	});	

	$(document).on('click', '.remove-ad-image', function(){
		$(this).parents('.ad-image-wrap').remove();
	});	


	/* REMOVE IMAGE */
	$(document).on('click', '.remove-image', function(){
		$(this).parent().parent().find('input').val('');
		$(this).parent().html('');
	});
	

	/* CHANGE AVATAR */
	$(document).on('click', '.set-image', function(e){
		e.preventDefault();
		var $this = $(this);

		var frameArgs = {
			multiple: false,
			title: $(this).text()
		};

		handle_images( frameArgs, function( selection ){
			model = selection.first();			
			$this.parent().find('img').remove();
			$this.parent().find('.image-wrap').html( '<img src="'+model.attributes.url+'" class="img-responsive"/><a href="javascript:;" class="button remove-image">X</a>' );
			$this.parent().find('input').val(model.id);
		});
	});

	/* handle category marker selection */

	$(document).on( 'click', '.select-marker', function(e) {
		e.preventDefault();

		var frameArgs = {
			multiple: false,
			title: 'Select Marker Image'
		};

		handle_images( frameArgs, function( selection ){
			model = selection.first();
			$('.marker-image-val').val( model.id );
			var img = model.attributes.url;
			$('.marker-holder').html( '<img src="'+img+'" class="img-responsive"/><a href="javascript:;" class="remove-marker">X</a>' );
		});
	});

	$(document).on( 'click', '.remove-marker', function(){
		$('.marker-image-val').val( '' );
		$('.marker-holder').html('');
	});


	/* ADD VIDEOS */
	$(document).on( 'click', '.ad-videos', function(){
		var can_add = true;
		if( classifieds_data.ads_max_videos && $('.ad-video-wrap input').length - 1 >= classifieds_data.ads_max_videos ){
			can_add = false;
		}
		if( can_add ){
			var clone = $('.ad-video-wrap.hidden').clone();
			clone.removeClass('hidden');
			$('.ad-media-wrap').append(clone);
		}
	});

	$(document).on( 'click', '.remove-video', function(){
		$(this).parents('.ad-video-wrap').remove();
	});
});