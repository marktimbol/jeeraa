jQuery(document).ready(function($){
	var LAST_FIELD = $('.cf_add_field_block').length - 1;
	$('.cf_add_new_field').click(function(){
		LAST_FIELD++;
		var $new_field = $('.cf_add_field_block.hidden').clone();
		$new_field.removeClass('hidden');
		$new_field.html( $new_field.html().replace(/\[x\]/g, '['+( LAST_FIELD )+']' ) );
		$(this).before( $new_field );
	});

	$(document).on('change', 'select[id^="cf_type"]', function(){
		var $parent = $(this).parent().parent().parent();
		$parent.find('div[class^="cf_is_"]').addClass('hidden');
		$parent.find('.cf_is_'+$(this).val()).removeClass('hidden');
	});

	$(document)	.on('click', '.remove-field', function(){
		var r = confirm('Are you sure you want to do this?');
		if ( r == true ) {		
			$(this).parents('.cf_add_field_block').remove();
		}
	});

	$(document).on('click', '.create_subgroups, .update_subgroups', function(){
		var $this = $(this);
		var $parent = $this.parent();
		var values = $parent.find('.select_values').val();
		if( values ){
			values = values.split("\n");
			$parent.find('.has_subgroup').val('1');
			$parent.find('.cf_select_subgroup.hidden').removeClass('hidden');
			$parent.find('.subgroups_field:not(.hidden)').addClass('to_check');
			for( var i=0; i<values.length; i++ ){
				var value_args = values[i].split('|');
				if( $parent.find('.subgroups_field.'+value_args[0]).length == 0 ){
					var $new_subgroup = $parent.find('.subgroups_field.hidden').clone();
					$new_subgroup.removeClass('hidden').addClass(value_args[0]);
					$new_subgroup.html( $new_subgroup.html().replace( /\[valuex\]/g, '['+values[i]+']' ) );
					$new_subgroup.html( $new_subgroup.html().replace( /\[labelx\]/g, value_args[1] ) );
					$parent.find('.subgroups_holder').append( $new_subgroup );
				}
				else{
					$parent.find('.subgroups_field.'+value_args[0]).removeClass('to_check');
				}
			}
			$parent.find('.subgroups_field.to_check').remove();
			$parent.find('.update_subgroups').removeClass('hidden');
			$parent.find('.create_subgroups').addClass('hidden');
		}
	});

	$(document).on('click', '.remove_subgroups', function(){
		var r = confirm('Are you sure you want to do this?');
		if ( r == true ) {
			var $parent = $(this).parent();
			$parent.find('.subgroups_holder').html('');
			$parent.find('.update_subgroups').addClass('hidden');
			$parent.find('.cf_select_subgroup').addClass('hidden');
			$parent.find('.create_subgroups').removeClass('hidden');		
			$parent.find('.has_subgroup').val('0');
		}
	});	

	$(document).on( 'click', '.remove_subgroup', function(){
		var r = confirm('Are you sure you want to do this?');
		if ( r == true ) {
			$(this).parent().remove();
		}
	});
});