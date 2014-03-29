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
add_action( 'wp_enqueue_scripts', 'ync_student_feedback_scripts' );
add_action( 'wp_enqueue_scripts', 'student_feedback_styles' );
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
if ( is_user_logged_in() ) {
	if ( empty($user_id) ) {
		$data = get_student_courses($user_login); // 'A0109187'
	} else {
		$data = get_student_courses($user_id);
	}
}

// echo '<pre>' . current_page_url() . "</pre>\n";
// echo '<pre>print_r($data) : ' . print_r($data, true) . "</pre>\n";
// echo '<pre>empty($data) : ' . ( (empty($data)) ? 'true' : 'false' ) . "</pre>\n";
?>
<div class="wrapper overview student-feedback">
			<!-- Start the Loop. -->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1 class="entry-title">January - May, 2014:  Student Feedback on Learning Experience</h1>
			<?php if ( is_user_logged_in() && !empty($data) ): ?>
				<?php //get_template_part( 'student-feedback-form' ); ?>
				<?php include(locate_template('student-feedback-form.php')); ?>
			<?php else: ?>
				<p>Unable to retrieve student : <?php echo $user_login; ?></p>
				<p>Try <a href="<?php echo(current_page_url() . "?user_id=A0109187"); ?>"><?php echo(current_page_url() . "?user_id=A0109187"); ?></a></p>
			<?php endif ?>
			
			<!-- <div id="form1"></div> -->
			<!-- Stop The Loop. -->
			<?php endwhile; endif; ?>
<!--
<pre>
$user_login : <?php echo $user_login."\n"; ?>
get_current_user_id() : <?php echo get_current_user_id()."\n"; ?>
get_the_ID() : <?php echo get_the_ID()."\n"; ?>
get_post_meta( get_the_ID() ): <?php print_r(get_post_meta( get_the_ID() )); ?>
</pre>
-->
</div><!-- wrapper overview student-feedback -->

<script type="text/javascript">
(function($) {
  $("#form1").alpaca({
    "schema": {
      "title":"Student Course Selection",
      "description":"Please select your courses for Semester 3",
      "type":"object",
      "properties": {
        "MST": {
			"type":"boolean",
			"title":"All students must enroll in Modern Social Thought (MST) for 5 modular credits",
			"readonly": true,
			"required": true
        }
      }
    },
	"options": {
		"fields": {
			"MST": {
				"click": function(e){
					console.log(this);
				},
				"rightLabel": "Modern Social Thought (MST)"
			}
		}
	},
	"data": {
		"MST": true
	}
  });
})(jQuery);
</script>
<?php get_footer(); ?>