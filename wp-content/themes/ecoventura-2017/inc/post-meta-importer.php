<?php
/**
 * Import post meta into post from JSON
 *
 * Export format wp post meta list 9151 --fields=meta_key,meta_value --format=json
 */


add_action( 'add_meta_boxes', 'eco_add_post_meta_import_box' );
function eco_add_post_meta_import_box() {
	add_meta_box( 'post-meta-importer', 'Post meta import', 'eco_post_meta_import_render', 'post' );
	add_meta_box( 'post-meta-importer', 'Post meta import', 'eco_post_meta_import_render', 'page' );
}

function eco_post_meta_import_render( $post ) {
	?>
	Import here:<br>
	<textarea id="eco-post-meta-import-data" name="post_meta_import" class="widefat" rows="20"></textarea>
	<button id="eco-post-meta-import-submit">Import</button>
	<script>
		( function( $ ) {
			$( '#eco-post-meta-import-submit' ).on( 'click', function(e) {
				e.preventDefault();
				$.ajax( {
					url: ajaxurl,
					method: 'post',
					data: {
						action: 'eco_import_post_meta',
						post_id: $('#post_ID').val(),
						payload: $('#eco-post-meta-import-data').val(),
					}
				} ).done(function(res) {
					console.log(res);
				} );
			} );
		} )( jQuery );
	</script>
	<?php
}

add_action( 'wp_ajax_eco_import_post_meta', 'eco_import_post_meta_process' );
function eco_import_post_meta_process() {
	$post_id = absint( wp_unslash( $_POST['post_id'] ) );
	$data = json_decode( wp_unslash( $_POST['payload'] ) );

	foreach ($data as $key => $meta) {
		update_post_meta( $post_id, $meta->meta_key, $meta->meta_value );
	}
	wp_send_json_success( $data );
}
