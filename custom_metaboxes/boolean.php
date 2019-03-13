<?php

	$bool_val = get_post_meta( get_the_ID(), $field['name'], true );

?>

<div class="gttsd_box_boolean">
	<label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
	<input type="radio" name="<?php echo $field['name']; ?>" value="1" <?php if($bool_val == 1){ echo 'checked'; } ?>>Yes
	<input type="radio" name="<?php echo $field['name']; ?>" value="0" <?php if($bool_val == 0){ echo 'checked'; } ?>>No
</div>
