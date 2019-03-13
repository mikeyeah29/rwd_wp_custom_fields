<div class="gttsd_box_wysiwyg">
	<label for="<?php echo $field['name']; ?>" class="block"><?php echo $field['label']; ?></label>
	<?php 

		$settings = array( 'media_buttons' => false,'quicktags' => false );
		$content = get_post_meta( get_the_ID(), $field['name'], true );                     
		$editor_id = $field['name'];
		wp_editor( $content, $editor_id, $settings );

	?>
</div>