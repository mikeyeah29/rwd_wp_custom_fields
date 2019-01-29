<div class="gttsd_box_standard">
	<label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
	<input type="text" 
		   id="<?php echo $field['name']; ?>" 
		   name="<?php echo $field['name']; ?>" 
		   value="<?php echo get_post_meta( get_the_ID(), $field['name'], true ); ?>" 
		   placeholder="..." />
</div>