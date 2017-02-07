<div class="wrap">

	<h2><?php esc_html_e( 'Import / Export Custom Fields', 'classifieds' ) ?> </h2>


	<p><?php esc_html_e( 'Click button bellow to get JSON export of your created fields which you can later import back using form bellow', 'classifieds' ) ?></p>
	<?php $permalink = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
	<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'export' ), $permalink ) ) ?>" class="button"><?php esc_html_e( 'Export', 'classifieds' ) ?></a>
	<?php
	if( isset( $_GET['action'] ) && $_GET['action'] == 'export' ){
		classifieds_export_cf_values();
	}
	?>

	<br /><br />
	<hr />

	<p><?php esc_html_e( 'Paste JSON of your custom fields and click on import button', 'classifieds' ) ?></p>
	<?php classifieds_import_cf_values() ?>
	<form method="post" action="<?php echo esc_url( add_query_arg( array( 'action' => 'import' ), $permalink ) ) ?>">
		<textarea name="cf_values" class="cf-import"></textarea>
		<input type="submit" class="button" value="<?php esc_attr_e( 'Import', 'classifieds' ) ?>">
	</form>

</div>