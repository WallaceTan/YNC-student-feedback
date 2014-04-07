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

function get_student_courses($user_login) {
	global $wpdb;
	$student_courses = $wpdb->prefix . 'student_courses';
	$teaching_evaluation = $wpdb->prefix . 'teaching_evaluation';
	$sql =  "SELECT S.* FROM `$student_courses` AS S LEFT JOIN `$teaching_evaluation` AS T ON (S.id=T.student_course_id) WHERE T.student_course_id IS NULL AND S.student_id REGEXP '^{$user_login}[a-zA-Z]?$';";
	$students = $wpdb->get_results( $sql );
	$data = array();
	foreach ($students as $student) {
		$row['id'] = $student->id;
		$row['course'] = $student->course;
		$row['instructors'] = explode('|', $student->instructors);
		$data[] = $row;
	}
	return $data;
}

function insert_teaching_evaluation() {
	global $wpdb;
	$table = $wpdb->prefix . 'teaching_evaluation';
	$i = 1;

// Ugly hack: Section C or P{$i}_name is missing, if (course == YCC1132: Integrated Science)
//<input id="course" name="course" type="hidden" value="YCC1132: Integrated Science">
	if ( $_POST["course"] == "YCC1132: Integrated Science" ) {
		$count_sql = "SELECT COUNT(*) FROM `$table` WHERE student_course_id=%d AND course=%s";
		$insert_sql = "INSERT INTO `$table` (student_course_id,course,A1,A2,A3,B1,B2,D1,created) VALUES (%d,%s,%s,%s,%s,%d,%s,%s,NOW())";
		$data["student_course_id"] = $_POST["student_course_id"];
		$data["course"] = $_POST["course"];
		$data["A1"] = $_POST["A1"];
		$data["A2"] = $_POST["A2"];
		$data["A3"] = $_POST["A3"];
		$data["B1"] = ( isset($_POST["B1"]) ? $_POST["B1"] : 99 );
		$data["B2"] = $_POST["B2"];
		$data["D1"] = $_POST["D1"];

		$sql = $wpdb->prepare($count_sql, $data["student_course_id"], $data["course"]);
		$count = $wpdb->get_var( $sql );
		if ( $count == 0 ) {
			$sql = $wpdb->prepare($insert_sql, $data);
			$wpdb->query( $sql );
		}
	} else {
		$count_sql = "SELECT COUNT(*) FROM `$table` WHERE student_course_id=%d AND instructor=%s";
		$insert_sql = "INSERT INTO `$table` (student_course_id,course,instructor,A1,A2,A3,B1,B2,C1,C2,C3,C4,C5,C6A,C6B,D1,created) VALUES (%d,%s,%s,%s,%s,%s,%d,%s,%d,%d,%d,%d,%d,%d,%d,%s,NOW())";
		while ( isset($_POST["P{$i}_name"]) && !empty($_POST["P{$i}_name"]) ) {
			$data["student_course_id"] = $_POST["student_course_id"];
			$data["course"] = $_POST["course"];
			$data["instructor"] = $_POST["P{$i}_name"];
			$data["A1"] = $_POST["A1"];
			$data["A2"] = $_POST["A2"];
			$data["A3"] = $_POST["A3"];
			$data["B1"] = ( isset($_POST["B1"]) ? $_POST["B1"] : 99 );
			$data["B2"] = $_POST["B2"];
			$data["C1"] = ( isset($_POST["P{$i}_C1"]) ? $_POST["P{$i}_C1"] : 99 );
			$data["C2"] = ( isset($_POST["P{$i}_C2"]) ? $_POST["P{$i}_C2"] : 99 );
			$data["C3"] = ( isset($_POST["P{$i}_C3"]) ? $_POST["P{$i}_C3"] : 99 );
			$data["C4"] = ( isset($_POST["P{$i}_C4"]) ? $_POST["P{$i}_C4"] : 99 );
			$data["C5"] = ( isset($_POST["P{$i}_C5"]) ? $_POST["P{$i}_C5"] : 99 );
			$data["C6a"] = ( isset($_POST["P{$i}_C6a"]) ? $_POST["P{$i}_C6a"] : 99 );
			$data["C6b"] = ( isset($_POST["P{$i}_C6b"]) ? $_POST["P{$i}_C6b"] : 99 );
			$data["D1"] = $_POST["D1"];

			if ($data["C6a"] == 0) $data["C6b"] = 0;

			$sql = $wpdb->prepare($count_sql, $data["student_course_id"], $data["instructor"]);
			$count = $wpdb->get_var( $sql );
			if ( $count == 0 ) {
				$sql = $wpdb->prepare($insert_sql, $data);
				$wpdb->query( $sql );
			}
			$i++;
		}
	}
}
