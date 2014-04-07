<?php
/**
 * Template Name: Student Feedback
 *
 * Description: A Page Template that adds a sidebar to pages.
 *
 * @package WordPress
 * @subpackage yalenus-microsite
 * @since yalenus-microsite 0.1
 */
if ( !is_user_logged_in() ) auth_redirect();
//add_action( 'wp_enqueue_scripts', 'ync_student_feedback_scripts' );
//add_action( 'wp_enqueue_scripts', 'ync_student_feedback_styles' );
get_header();
/*
function get_template_part( $slug, $name = null ) {
	do_action( "get_template_part_{$slug}", $slug, $name );

	$templates = array();
	$name = (string) $name;
	if ( '' !== $name )
		$templates[] = "{$slug}-{$name}.php";

	$templates[] = "{$slug}.php";

	locate_template($templates, true, false);
}
function comments_template( $file = '/comments.php', $separate_comments = false ) {
	global $wp_query, $withcomments, $post, $wpdb, $id, $comment, $user_login, $user_ID, $user_identity, $overridden_cpage;

	if ( !(is_single() || is_page() || $withcomments) || empty($post) )
		return;

	if ( empty($file) )
		$file = '/comments.php';

	$req = get_option('require_name_email');
*/
?>
<?php
$user_id = $_GET['user_id'];
// echo "user_id : " . $user_id."\n";
if ( is_user_logged_in() ) {
	if ( empty($user_id) ) {
		$student_courses = get_student_courses($user_login); // 'A0109187'
	} else {
		$student_courses = get_student_courses($user_id);
	}
}

// echo '<pre>' . current_page_url() . "</pre>\n";
// echo '<pre>print_r($student_courses) : ' . print_r($student_courses, true) . "</pre>\n";
// echo '<pre>empty($student_courses) : ' . ( (empty($student_courses)) ? 'true' : 'false' ) . "</pre>\n";
?>
<div class="wrapper overview student-feedback">
			<!-- Start the Loop. -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1 class="entry-title">January - May, 2014:  Student Feedback on Learning Experience</h1>
			<?php if ( is_user_logged_in() && !empty($student_courses) ): ?>
				<?php if ($_SERVER['REQUEST_METHOD'] == 'GET') : ?>
					<?php //get_template_part( 'student-feedback-form' ); ?>
					<?php include(locate_template('student-feedback-form.php')); ?>
				<?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
					<p>Thank you for completing this feedback form.</p>
					<p><a href="<?php echo wp_logout_url($_SERVER['REQUEST_URI']); ?>" title="Logout">Logout</a></p>
				<?php insert_teaching_evaluation(); ?>
				<?php endif ?>
			<?php else: ?>
				<p>All evaluations completed!</p>
			<?php endif ?>
			
			<!-- Stop The Loop. -->
			<?php endwhile; endif; ?>
<!--
<pre>
get_template_directory_uri() : <?php echo get_template_directory_uri()."\n"; ?>
$user_login : <?php echo $user_login."\n"; ?>
get_current_user_id() : <?php echo get_current_user_id()."\n"; ?>
get_the_ID() : <?php echo get_the_ID()."\n"; ?>
get_post_meta( get_the_ID() ): <?php print_r(get_post_meta( get_the_ID() )); ?>
</pre>
-->
</div><!-- wrapper overview student-feedback -->
<?php get_footer(); ?>