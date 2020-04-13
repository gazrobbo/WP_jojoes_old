<?php
/**
 * The main template file
 *
 *
 * It is used to display a page when nothing more specific matches a query.
 *
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ignition Press
 * @since   1.0
 * @version 1.0
 *
 */


get_header();
?>

<?php
/*
 * With Ignition Press You can use the WP Customizer to choose a page to show its sections for an archive page
 * This way clients can control the archive page instead of needing you to make changes via archive-post_type.php.
 * If an archive page is set, then a page will be queried here instead of the archive loop being used. (you can still output the loop as one of the sections using the Gutenburg Block called cards)
 *
 * For a regular index without a page set, the loop will simply be output down below after "else:"
*/

//checking to see if a page has been set to be used with this post type archive
global $post;
$page_archive_id = ign_get_archive_page();


//if a page has been chosen in the customizer for this post type, set if there is a sidebar template on the page used, add the proper divs.
$has_sidebar = false;
if ( $page_archive_id ) {
	if ( strpos( get_page_template_slug( $page_archive_id ), 'sidebar-left' ) !== false ) {
		echo '<div class="sidebar-template header-above container-fluid">';
		echo '<div class="flex sidebar-left">';
		$has_sidebar = true;
	}
	if ( strpos( get_page_template_slug( $page_archive_id ), 'sidebar-right' ) !== false ) {
		echo '<div class="sidebar-template header-above container-fluid">';
		echo '<div class="flex sidebar-right">';
		$has_sidebar = true;
	}
}

?>



	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			//if an archive page has been set show it now
			if ( $page_archive_id ) :
				//set the post to the archive page
				$post = get_post( $page_archive_id );
				setup_postdata( $post );
				?>
				<div class="entry-content container-content">
					<?php
					ign_the_content();

					?>
				</div>
				<?php wp_reset_postdata();
				//END PAGE ARCHIVE
				?>


			<?php
			//BASIC INDEX WHEN NO PAGE USED (DEFAULT).
			else:
				?>

				<header class="page-header layout-center-content text-center">
					<div class="header-content container-fluid">
						<h1>
							<?php
							if ( is_home() ) {
								echo __( 'Blog', 'ignitionpress' );
							} else {
								echo get_the_archive_title();
							} ?>
						</h1>

					</div>
				</header>

				<div class="container">
					<section class="archive-cards card-grid">
						<?php
						//default to one section fo cards
						while ( have_posts() ) : the_post();

							ign_loop();

						endwhile; // End of the loop.
						?>
					</section><!-- .entry-content -->


					<div class="container card-pagination text-center">
						<?php
						the_posts_pagination( array(
							'prev_text'          => ign_get_svg( array( 'icon' => 'angle-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'cmlaw' ) . '</span>',
							'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'cmlaw' ) . '</span>' . ign_get_svg( array( 'icon' => 'angle-right' ) ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'cmlaw' ) . ' </span>',
						) );
						?>
					</div>


				</div>
			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->


<?php
if ( $has_sidebar ) {
	get_sidebar();
	echo '</div></div><!-- #sidebar-template -->';
}
?>


<?php
get_footer();
