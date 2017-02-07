<?php
if( !$is_edit ){
    ?>
    <div class="next-prev-tab text-right">
        <a href="javascript:;" class="btn prev-tab disabled">
            <?php _e( 'PREVIOUS', 'classifieds' ) ?>
        </a>
        <a href="javascript:;" class="btn next-tab">
            <?php _e( 'NEXT', 'classifieds' ) ?>
        </a>
        <p class="next-prev-error hidden">
        	<?php esc_html_e( 'You have to populate all required fields. Required fields are marked with *', 'classifieds' ); ?>
        </p>
    </div>
    <?php
}
?>