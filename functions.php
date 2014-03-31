<?php
/**
 * Yale-NUS Microsite Child theme functions and definitions
 * 
 */
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

//add_action( 'wp_print_scripts', 'child_overwrite_scripts', 100 );
//add_action( 'wp_print_styles', 'child_overwrite_styles', 100 );

function child_overwrite_scripts() {
    wp_deregister_script( 'fancybox' );
    wp_deregister_script( 'bones-modernizr' );

    //adding scripts file in the footer
    // wp_register_script( 'accordion', get_stylesheet_directory_uri() . '/library/js/jquery-ui-accordion.min.js', array( 'jquery' ), '', true );
    // wp_register_script( 'fancybox', get_stylesheet_directory_uri() . '/library/fancybox/jquery.fancybox.js', array( 'jquery' ), '', true );
    // wp_register_script( 'bxslider', get_stylesheet_directory_uri() . '/library/js/jquery.bxslider.js', array( 'jquery' ), '', true );
    // wp_register_script( 'bones-js', get_stylesheet_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );
    // wp_register_script( 'infobox', get_stylesheet_directory_uri() . '/library/js/infobox.js', array( 'jquery' ), '', true );
    // wp_register_script( 'gmaps', get_stylesheet_directory_uri() . '/library/js/where.js', array( 'jquery' ), '', true );

    // enqueue styles and scripts
    // wp_enqueue_script( 'bones-modernizr' );
    // wp_enqueue_style( 'bones-stylesheet' );
    // wp_enqueue_style( 'bones-fancyboxstylesheet' );
    // wp_enqueue_style('bones-ie-only');
    // $wp_styles->add_data( 'bones-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet

}

function child_overwrite_styles() {
    wp_deregister_style( 'bones-stylesheet' );
    wp_deregister_style( 'bones-fancyboxstylesheet' );
}

function ync_student_feedback_scripts() {
// wp_register_script( 'myscript', get_template_directory_uri() . '/scripts/myscript.js' );
// echo(get_template_directory() : " . get_template_directory() );
// echo(get_template_directory_uri() : " . get_template_directory_uri() );
// echo(get_stylesheet_directory()() : " . get_stylesheet_directory() );

    // Register the script like this for a theme:
    wp_register_script( 'student-feedback-script', get_site_url() . '/wp-includes/js/alpaca/alpaca-full.js', array( 'jquery' ), '1.1.2' );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'student-feedback-script' );
}

function ync_student_feedback_styles() {
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
