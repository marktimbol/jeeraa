<?php
	/**********************************************************************
	***********************************************************************
	PROPERSHOP COMMENTS
	**********************************************************************/
	
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ( 'Please do not load this page directly. Thanks!' );
	if ( post_password_required() ) {
		return;
	}
?>
<?php if ( comments_open() ) :?>


    <!-- row -->
    <div class="comments">
    	<?php if( have_comments() ): ?>	    
	    	<div class="white-block">
	    		<div class="white-block-title">
	    			<h4><?php esc_html_e( 'Comments', 'classifieds' ) ?></h4>
	    		</div>

		        <div class="white-block-content">
					
						
						<?php 
						wp_list_comments( array(
							'type' => 'comment',
							'callback' => 'classifieds_comments',
							'end-callback' => 'classifieds_end_comments',
							'style' => 'div'
						)); 
						?>

		                <!-- pagination -->
						<?php
							$comment_links = paginate_comments_links( 
								array(
									'echo' => false,
									'type' => 'array',
									'prev_text' => '<i class="fa fa-arrow-left"></i>',
									'next_text' => '<i class="fa fa-arrow-right"></i>'
								) 
							);
							if( !empty( $comment_links ) ):
						?>					
			                <div class="custom-pagination">
			                    <ul class="pagination">
									<?php echo  classifieds_format_pagination( $comment_links ); ?>
								</ul>
							</div>
						<?php endif; ?>
		                <!-- .pagination -->

		        </div>    		
	    	</div>
    	<?php endif; ?>
    
    	<div class="white-block">
    		<div class="white-block-title">
    			<h4><?php esc_html_e( 'Leave Comment', 'classifieds' ) ?></h4>
    		</div>

    		<div class="white-block-content">
				<?php
					$comments_args = array(
						'label_submit'	=>	esc_html__( 'SEND COMMENT', 'classifieds' ),
						'title_reply'	=>	'',
						'fields'		=>	apply_filters( 'comment_form_default_fields', array(
												'author' => '<div class="input-group">
																<label for="author">'.esc_attr__( 'Name', 'classifieds' ).'</label>
                          										<input type="text" class="form-control" name="author" id="author">
                        									</div>',
												'email'	 => '<div class="input-group">
																<label for="email">'.esc_attr__( 'Email', 'classifieds' ).'</label>
                          										<input type="text" class="form-control" name="email" id="email">
                        									</div>'
											)),
						'comment_field'	=>	'<div class="input-group">
												<label for="comment">'.esc_attr__( 'Message', 'classifieds' ).'</label>
												<textarea class="form-control" id="comment" name="comment"></textarea>
        									</div>',
						'cancel_reply_link' => esc_html__( 'or cancel reply', 'classifieds' ),
						'comment_notes_after' => '',
						'comment_notes_before' => ''
					);
					comment_form( $comments_args );	
				?>    			
    		</div>
    	</div>

    </div>
    <!-- .row -->

<?php endif; ?>