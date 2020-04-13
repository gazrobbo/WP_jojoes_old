<?php
/**
 * The template for displaying all single posts
 * It does not include a sidebar
 *
 * This is the template that displays all posts by default.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ignition
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">


        <?php include( locate_template( 'template-parts/jojoe-template-parts/hero.php' ) ); ?>
        <?php include( locate_template( 'template-parts/jojoe-template-parts/services.php' ) ); ?>
        <?php include( locate_template( 'template-parts/jojoe-template-parts/about.php' ) ); ?>
        <?php include( locate_template( 'template-parts/jojoe-template-parts/reviews.php' ) ); ?>
        <?php include( locate_template( 'template-parts/jojoe-template-parts/why-visit.php' ) ); ?>
        <?php include( locate_template( 'template-parts/jojoe-template-parts/contact.php' ) ); ?>



        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer();
