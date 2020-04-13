<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ignition
 * @since 1.0
 * @version 1.0
 */

?>

<?php if ( is_single() ) : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="entry-content container-content">
			<?php


			ign_the_content();


			//not sure gutenberg eve has this anymore
			wp_link_pages( array(
				'before'      => '<div class="page-links">' . __( 'Pages:', 'ignition' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );

			?>

		</div><!-- .entry-content -->
	</article><!-- #post-## -->

	<section class="after-article container-content">
		<?php
		the_post_navigation( array(
			'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'ignition' ) . '</span><div class="nav-title"><span class="nav-title-icon-wrapper">' . ign_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span> <span>%title</span></div>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'ignition' ) . '</span><div class="nav-title"><span>%title</span> <span class="nav-title-icon-wrapper">' . ign_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></div>',
		) );

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>
	</section>


<?php endif; ?>



<?php ////////////////////////////////////////////// below is used if this is NOT a single post, but an archive or the blog ?>


<?php if ( ! is_single() ): ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
		<div class="header-image cover-image">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'post-thumbnail' );
			}
			?>
		</div>

		<header class="card-header">
			<div class="header-content">
				<?php echo ign_get_term_links(); ?>
				<?php the_title( '<h2 class="card-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</div>
		</header>

		<div class="card-content">
			<?php
			the_excerpt();
			?>
		</div><!-- .card-content -->

		<div class="card-meta">
			<?php echo ign_posted_on(); ?>
			<?php echo ign_comment_link(); ?>
		</div>
	</article><!-- #post-## -->
<?php endif; //end if not single ?>





