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
echo "user_id : " . $user_id."\n";
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
					Thank you for completing this feedback form.
					
					<a href="<?php echo wp_logout_url(); ?>" title="Logout">Logout</a>
					<pre>
<?php
insert_teaching_evaluation();
/*
print_r($_POST);
Array
(
    [Q_A1] => Test Part A Q1
    [Q_A2] => Test Part A Q2
    [Q_A3] => Test Part A Q3
    [Q_B1] => 1
    [Q_B2] => around five hours a week
    [Q_P1_C_name] => Dr Ang Tsu Lyn, Claudine
    [Q_P1_C1] => 5
    [Q_P1_C2] => 4
    [Q_P1_C3] => 3
    [Q_P1_C4] => 2
    [Q_P1_C5] => 1
    [Q_P1_C6A] => 0
    [Q_P1_C6B] => 2
    [Q_D1] => Test Part D Q1
    [submit] => Submit
)
*/
					?></pre>
				<?php endif ?>
			<?php else: ?>
				<p>Unable to retrieve student : <?php echo $user_login; ?></p>
				<p>Try <a href="<?php echo(current_page_url() . "?user_id=A0109187"); ?>"><?php echo(current_page_url() . "?user_id=A0109187"); ?></a></p>
			<?php endif ?>
			
			<!-- <div id="form1"></div> -->
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