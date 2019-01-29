<?php

	/****
	
		Adds a new custom field (meta box) to page or post

		EXAMPLE

		$rtcw_our_history = new RwdCustomFeild(NULL, 'page', 'Our History Section', array(
		    array(
		        'label' => 'Our History Content',
		        'content_type' => 'wysiwyg'
		    ),
		    array(
		        'label' => 'History Image',
		        'content_type' => 'input'
		    )
		));

	****/

	class RwdCustomField
	{
		var $box_name;
		var $template = NULL;
		var $post_type = 'post';
		var $custom_class = NULL;
		var $fields = [];

		var $content_type;

		static function field($slug){
			return get_post_meta( get_the_ID(), $slug)[0];
		}

		function slugify($text)
		{
			// replace non letter or digits by -
			$text = preg_replace('~[^\pL\d]+~u', '-', $text);
			// transliterate
			$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
			// remove unwanted characters
			$text = preg_replace('~[^-\w]+~', '', $text);
			// trim
			$text = trim($text, '-');
			// remove duplicate -
			$text = preg_replace('~-+~', '-', $text);
			// lowercase
			$text = strtolower($text);

			if (empty($text)) {
				return 'n-a';
			}

			return $text;
		}

		function check_template(){

			if($this->template == NULL){
				return TRUE;
			}

			// template is not 0 there for only should return true if correct template

			global $post;

			$pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

			if($pageTemplate == $this->template){
				return TRUE;
			}

			return FALSE;

		}

		function metabox() {			

			if(!$this->check_template()){
				return;
			}

		    add_meta_box( 
		        $this->box_name . '_metabox',
		        __( $this->box_name, 'myplugin_textdomain' ),
		        array($this, 'box_content'),
		        $this->post_type,
		        'normal',
		        'high'
		    );
		    
		}

		function box_content($post) {

			foreach ($this->fields as $field) {

				wp_nonce_field( plugin_basename( __FILE__ ), $field['name'] . '_box_content_nonce' );

				if($this->custom_class != NULL){
					echo '<div class="gttsd gt_homeblock">';
				}else{
					echo '<div class="gttsd">';
				}
				
				switch ($field['content_type']) {
					case 'wysiwyg':
						require(__DIR__ . '../../views/custom_metaboxes/wysiwyg.php');
						break;
					case 'image':
						require(__DIR__ . '../../views/custom_metaboxes/image.php');
						break;
					default:
						require(__DIR__ . '../../views/custom_metaboxes/standard_input.php');
						break;
				}

				echo '</div>';

			}

		}

		function save( $post_id ) {

			foreach ($this->fields as $field) {

				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
					return;

				if ( !isset( $_POST[$field['name']] ) )
					return;

				if ( !wp_verify_nonce( $_POST[$field['name'] . '_box_content_nonce'], plugin_basename( __FILE__ ) ) )
					return;

				if ( 'page' == $_POST['post_type'] ) {
					if ( !current_user_can( 'edit_page', $post_id ) )
						return;
					} else {
					if ( !current_user_can( 'edit_post', $post_id ) )
						return;
				}

				$valuetosave = $_POST[$field['name']];
				update_post_meta( $post_id, $field['name'], $valuetosave );	
			
			}

		}

		function enqueue_media_uploader($hook){

		    wp_enqueue_media();

			if (  $hook == 'post-new.php' || $hook == 'post.php' ){

			    wp_enqueue_script( 'app', plugins_url() . '/devall/assets/js/app.js', array('jquery'));

		    }

		}

		function __construct($template = 0, $post_type = 'post', $box_name, $custom_class, $fields){

			for($i=0; $i<sizeof($fields); $i++) {
				$fields[$i]['name'] = $this->slugify($fields[$i]['label']);
			}

			if($custom_class != NULL){
				$this->custom_class = $custom_class;
			}

			$this->box_name = $box_name;
			$this->template = $template;
			$this->post_type = $post_type;
			$this->fields = $fields;

			add_action( 'add_meta_boxes', array( $this, 'metabox') );
			add_action( 'save_post', array( $this, 'save') );
			add_action( 'admin_enqueue_scripts', array($this, 'enqueue_media_uploader') );

		}

	}

	function rwd_field($slug){
		global $post;
		return get_post_meta($post->ID, $slug)[0];
	}

?>