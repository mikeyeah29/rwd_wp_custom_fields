<div class="gttsd_box_textarea">
	<label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
	<textarea id="<?php echo $field['name']; ?>" 
		   name="<?php echo $field['name']; ?>"  
		   placeholder="..."><?php echo get_post_meta( get_the_ID(), $field['name'], true ); ?></textarea>
</div>