<?php
/**
 * Template part for displaying page as a card on an archive list or a search page
 * This was separated out from page.php because a lot of plugins use page.php while is_page is sometimes still false and then the plugin will wrongly show the card instead of the full page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Ignition
 * @since 1.0
 * @version 1.0
 *
 * When viewing a page as a card on an archive
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
    <div class="header-image cover-image">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'post-thumbnail', array( 'class' => 'header-image' ) );
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
    </div><!-- .entry-content -->

    <div class="card-meta">
		<?php echo ign_posted_on(); ?>
		<?php echo ign_comment_link(); ?>
    </div>
</article><!-- #post-## -->

