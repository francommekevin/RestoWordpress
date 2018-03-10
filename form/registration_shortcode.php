<?php
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
	
}
?>