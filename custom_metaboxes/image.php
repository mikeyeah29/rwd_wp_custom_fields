
<div class="gttsd_box_image">
	<label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>

	<?php if(get_post_meta( get_the_ID(), $field['name'], true ) != ''){ ?>
		<p class="rwd_select_image rwd_btn" style="display: none;">Select Image</p>
		<div class="rwd_remove_image rwd_btn">Remove Image</div>
		<img src="<?php echo get_post_meta( get_the_ID(), $field['name'], true ); ?>" />
	<?php }else{ ?>
		<p class="rwd_select_image rwd_btn">Select Image</p>
		<div class="rwd_remove_image rwd_btn" style="display: none;">Remove Image</div>
	<?php } ?>

	<input type="hidden" 
		   id="<?php echo $field['name']; ?>" 
		   name="<?php echo $field['name']; ?>" 
		   value="<?php echo get_post_meta( get_the_ID(), $field['name'], true ); ?>" />
</div>
