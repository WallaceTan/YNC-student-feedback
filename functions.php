<?php
/**
 * Twenty Eleven Child theme functions and definitions
 *
 */
/* Fire our meta box setup function on the post editor screen. */
//add_action( 'load-post.php', 'smashing_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'smashing_post_meta_boxes_setup' );

/* Meta box setup function. */
function smashing_post_meta_boxes_setup() {
	/* Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'smashing_add_post_meta_boxes' );
}

// http://wordpress.org/support/topic/current-page-url-1
function current_page_url() {
	$pageURL = 'http';
	if( isset($_SERVER["HTTPS"]) ) {
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function ync_student_feedback_scripts() {
    // Register the script like this for a theme:
    wp_register_script( 'student-feedback-script', get_site_url() . '/wp-includes/js/alpaca/alpaca-full.js', array( 'jquery' ), '1.1.2' );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'student-feedback-script' );
}

function student_feedback_styles() {
	// Register the style like this for a plugin:
	//wp_register_style( 'student-feedback-style', plugins_url( '/css/student-feedback-style.css', __FILE__ ), array(), '20140324', 'all' );
	// or
	// Register the style like this for a theme:
	//wp_register_style( 'student-feedback-style', get_template_directory_uri() . '/css/student-feedback-style.css', array(), '20140324', 'all' );
	wp_register_style( 'student-feedback-style', get_site_url() . '/wp-includes/css/alpaca/alpaca.css', array(), '20140324', 'all' );

	// For either a plugin or a theme, you can then enqueue the style:
	wp_enqueue_style( 'student-feedback-style' );
}

function get_student_courses($user_login, $completed = 0) {
	global $wpdb;
	$table = $wpdb->prefix . 'teaching_evaluation';
	$students = $wpdb->get_results( "SELECT * FROM `$table` WHERE `student_id` LIKE '{$user_login}_' AND completed = '{$completed}';" );
	$data = array();
	foreach ($students as $student) {
		$row['id'] = $student->id;
		$row['course'] = $student->course;
		$row['instructors'] = explode('|', $student->instructors);
		$data[] = $row;
	}
	return $data;
}
