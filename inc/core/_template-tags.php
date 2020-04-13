<?php
/**
 * Custom template tags for ignition
 * Most expect you to be in the loop
 * ign_get_terms  and ign_get_term_links does not need to be in loop
 *
 * @package Ignition
 * @since   1.0
 */


/*
 * Prints the author image inside a link and  name inside another link.
*/
if ( ! function_exists( 'ign_posted_by' ) ) {
	function ign_posted_by() {
		$author_id          = get_the_author_meta( 'ID' );
		$author_link        = esc_url( get_author_posts_url( $author_id ) );
		$author_image       = '<a href="' . $author_link . '" class="author-avatar">' . get_avatar( $author_id, 50 ) . '</a>';
		$author_name        = sprintf( __( '%s by %s', 'ignition' ), '<a href="' . $author_link . '" class="author-name"><span class="byline">', '</span>' . get_the_author() . '</a>' );
		$author_description = '<div class="author-description">' . get_the_author_meta( 'description' ) . '</div>';

		echo '<div class="posted-by">' . $author_image . '<div class="author-info">' . $author_name . $author_description . '</div></div>';

	}
}


/**
 * Post the time
 */

/**
 * Prints HTML with meta information for the current post-date/time.
 */
if ( ! function_exists( 'ign_posted_on' ) ) {
	function ign_posted_on( $date_format = '' ) {
		// post published and modified dates
		echo '<div class="posted-on">' . ign_time_link( $date_format ) . '</div>';
	}
}


/**
 * Gets link with date
 */
if ( ! function_exists( 'ign_time_link' ) ) {

	function ign_time_link( $date_format ) {
		$time_string = '<time class="published" datetime="%1$s">%2$s</time>';

		//if when post was made does not equal the modified date
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="published" datetime="%1$s">%2$s</time><time class="updated screen-reader-text" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			get_the_date( DATE_W3C ),
			get_the_date( $date_format ),
			get_the_modified_date( DATE_W3C ),
			get_the_modified_date( $date_format )
		);

		// Wrap the time string in a link, and preface it with 'Posted on'.
		return sprintf(
		/* translators: %s: post date */
			__( '<span class="screen-reader-text">Posted on</span> %s', 'ganton' ),
			'<a class="entry-date" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
	}
}


/**
 * @param string $taxonomy
 * @param bool $get_all
 *
 * @return string|void
 * Get all or one term for a taxonomy for a post
 */
if ( ! function_exists( 'ign_get_term_links' ) ) {

	function ign_get_term_links( $taxonomy = 'category', $get_all = false, $id = 0 ) {

		if ( ! $id ) {
			$id = get_the_ID();
		}

		$terms = get_the_terms( $id, $taxonomy );

		if ( $terms && ! is_wp_error( $terms ) ) :
			//get first term found
			if ( ! $get_all ) {
				$term              = $terms[0];
				$term_links_output = '<a class="term-link ' . $taxonomy . '" href="' . get_term_link( $term->term_id, $taxonomy ) . '">' . $term->name . '</a>';
			} //else get all terms with a comma
			else {
				$term_links = array();
				foreach ( $terms as $term ) {
					$term_links[] = '<a class="term-link ' . $taxonomy . '" href="' . get_term_link( $term->term_id, $taxonomy ) . '">' . $term->name . '</a>';
				}
				//add comma after each one
				$term_links_output = join( '<span class="delim">' . __( ', ', 'ignition' ) . '</span>', $term_links );
			}

			return $term_links_output;
		endif;

		return '';
	}
}


/**
 * @param string $taxonomy
 *
 * @return string|void
 * Get all term objects for a post
 * fast way to grab and run a foreach loop
 */
if ( ! function_exists( 'ign_get_terms' ) ) {

	function ign_get_terms( $taxonomy = 'category', $id = 0 ) {
		if ( ! $id ) {
			$id = get_the_ID();
		}

		$terms = get_the_terms( $id, $taxonomy );

		if ( $terms && ! is_wp_error( $terms ) ) :
			return $terms;
		endif;

		return array();
	}
}


if ( ! function_exists( 'ign_comment_link' ) ) :
	/**
	 * Returns the comment link with icon for comments as well as comment or comments if wanted.
	 */
	function ign_comment_link( $comment_string = false ) {
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$num_comments = '';
				$comments     = __( 'No Comments' );
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . __( ' Comments' );
			} else {
				$comments = __( '1 Comment' );
			}

			if ( $comment_string ) {
				$write_comments = '<a class="comment-link" href="' . get_comments_link() . '"><span class="screen-reader-text">Comments</span>' . ign_get_svg( array(
						'icon' => 'comments'
					) ) . ' ' . $comments . '</a>';
			} else {
				$write_comments = '<a class="comment-link" href="' . get_comments_link() . '"><span class="screen-reader-text">Comments</span>' . ign_get_svg( array(
						'icon' => 'comments'
					) ) . ' ' . $num_comments . '</a>';
			}

			return $write_comments;
		}

		return;
	}
endif;


/**
 * ign edit link with some extras and markup
 * if using classic blocks use this inside those blocks
 *
 */
if ( ! function_exists( 'ign_edit_link' ) ) :
	function ign_edit_link( $id = null, $class = '', $text = 'Edit' ) {
		global $saving_sections;
		if ( $saving_sections ) {
			return;
		}

		if ( ! $id ) {
			global $post;
			$id = $post->ID;
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				__( '%s<span class="screen-reader-text"> "%s"</span>', 'ignition' ),
				$text, get_the_title()
			),
			'<span class="edit-link">',
			'</span>',
			$id,
			$class
		);
	}
endif;

/**
 * Checks to see if we're on a static front homepage or not as opposed to the blog frontpage.
 */
if ( ! function_exists( 'is_static_frontpage' ) ) :
	function is_static_frontpage() {
		return ( is_front_page() && ! is_home() );
	}
endif;


/**
 * Gets the proper template file to show for the WP LOOP
 * MUST BE USED INSIDE THE LOOP TO USE
 * Simply routes the page to the right folder and file
 */
function ign_loop( $show_full_page_content = false ) {

	//most probably not wanting to see a full page unless this is page.php, so instead we show the card content.
	if ( get_post_type() == 'page' && ! $show_full_page_content ) {
		include( locate_template( 'template-parts/page/card-content.php' ) );
	} else {

		if ( ! file_exists( locate_template( 'template-parts/' . get_post_type() ) ) ) {
			if ( get_post_format() && file_exists( locate_template( 'template-parts/post/content-' . get_post_format() . '.php' ) ) ) {
				include( locate_template( 'template-parts/post/content-' . get_post_format() . '.php' ) );
			} else {
				include( locate_template( 'template-parts/post/content.php' ) );
			}

		} else {
			if ( get_post_format() && file_exists( locate_template( 'template-parts/' . get_post_type() . '/content-' . get_post_format() . '.php' ) ) ) {
				include( locate_template( 'template-parts/' . get_post_type() . '/content-' . get_post_format() . '.php' ) );
			} else {
				include( locate_template( 'template-parts/' . get_post_type() . '/content.php' ) );
			}
		}
	}
}


/**
 * Returns the html image for acf image field.
 * Can default to show thumbnail
 * show image with filters properly set
 * This goes through filters of WP and returns an image with possible multiple srcsets
 *
 * @param int $post_id
 * @param string $size
 * @param string $attr
 * @param mixed $acf_image
 *
 * @return string
 */
function ign_get_image( $acf_image = '', $post_id = false, $size = 'post-thumbnail', $attr = '', $use_thumbnail_as_fallback = false ) {

	$image = '';

	//if its a string turn it into an array
	if ( is_string( $acf_image ) && function_exists( 'acf_get_loop' ) ) {
		if ( acf_get_loop() ) {
			$acf_image = get_sub_field( $acf_image, $post_id );
		} else {
			$acf_image = get_field( $acf_image, $post_id );
		}
	}

	//get image through WP
	if ( $acf_image && is_array( $acf_image ) ) {
		$image_id = $acf_image['id'];
		$image    = wp_get_attachment_image( $image_id, $size, '', $attr );
	} else {
		//fallback on thumbnail if wanted
		if ( is_single() && has_post_thumbnail() && $use_thumbnail_as_fallback ) {
			$image = get_the_post_thumbnail( $post_id, $size, $attr );
		}
	}

	return $image;
}

/**
 * Returns the image url for acf image field.
 * acf image field must be set to array
 *
 * @param int $post_id
 * @param string $size
 * @param mixed $acf_image
 *
 * @return string
 */
function ign_get_image_url( $acf_image = '', $post_id = false, $size = '', $use_thumbnail_as_fallback = false ) {

	$image = '';

	//if were passed a string we first need to get the image from the field. make sure acf is also installed
	if ( is_string( $acf_image ) && function_exists( 'acf_get_loop' ) ) {
		if ( acf_get_loop() ) {
			$acf_image = get_sub_field( $acf_image, $post_id );
		} else {
			$acf_image = get_field( $acf_image, $post_id );
		}
	}


	if ( $acf_image && is_array( $acf_image ) ) {
		$image_id = $acf_image['id'];
		$image    = wp_get_attachment_image_url( $image_id, $size, '' );
	} else {
		if ( has_post_thumbnail( $post_id ) && $use_thumbnail_as_fallback ) {
			$image = get_the_post_thumbnail_url( $post_id, $size );
		}
	}

	return $image;
}


/**
 * @param int $post_id
 * @param string $kind
 * @param string $attr
 *
 * @return string
 *
 * Returns the header image field for a post as a url, unless $return_type is set to anything else. then it returns the actual image element
 * if no image is found it will return the featured image
 * if no image is set, then nothing is returned.
 *
 */
function ign_get_header_image( $post_id = false, $return_type = 'url', $attr = '' ) {


	if ( function_exists( 'get_field' ) ) {

		if ( get_field( 'no_image', $post_id ) ) {
			return '';
		}

		$image = get_field( 'header_image', $post_id );
	} else {
		$image = '';
	}


	if ( $return_type == 'url' ) {
		return ign_get_image_url( $image, $post_id, 'header_image', true );
	} else {
		return ign_get_image( $image, $post_id, 'header_image', $attr, true );
	}
}

/**
 * @param $link_field
 * @param int $post_id
 *
 * If the link field is empty we still return an array so it is set and works
 */
function ign_get_link_field( $link_field, $post_id = false ) {


	if ( is_string( $link_field ) && function_exists( 'acf_get_loop' ) ) {
		if ( acf_get_loop() ) {
			$link_field = get_sub_field( $link_field, $post_id );
		} else {
			$link_field = get_field( $link_field, $post_id );
		}
	}

	//return array even if not link field found so no error occurs
	if ( ! $link_field ) {
		$link_field = array(
			'title'  => '',
			'url'    => 'javascript:;',
			'target' => '_self'
		);
	}

	return $link_field;

}


/**
 * @param $block
 * @param string $custom_classes
 * For use in block template, outputs the block classes
 */
function ign_block_class( $block, $custom_classes = '' ) {

	if ( $block ) {
		$classnames = isset( $block['className'] ) ? $block['className'] : '';
		$align      = isset( $block['align'] ) && $block['align'] ? 'align' . $block['align'] . ' ' : '';
		$classes    = 'acf-' . sanitize_title( strtolower( $block['title'] ) ) . ' ' . $align . $classnames;
		echo 'class="' . ( $custom_classes ? $custom_classes . ' ' . $classes : $classes ) . '"';
	}
}


/**
 * Show the content based on if its using Gutenberg or not
 *
 * @param string $default_header_location
 * relative path to location for default header
 */
function ign_the_content($default_header_location = '') {
	//shows blocks or classic acf blocks. check for a header block too
	$has_header = has_block( 'acf/header' );
	if ( $has_header || has_blocks() ) {
		//if there are blocks but not a header block, show the default header
		if ( ! $has_header ) {
			if($default_header_location){
				include( locate_template( $default_header_location ) );
			}else{
				if(file_exists(locate_template( 'template-parts/'  . get_post_type() . '/header.php' ))){
					include(locate_template( 'template-parts/'  . get_post_type() . '/header.php' ));
				}else{
					include( locate_template( 'template-parts/site-top/default-header.php' ) );
				}

			}

		}

		the_content();
	} else {
		//show classic blocks in editor
		include( locate_template( 'template-parts/classic-blocks/header_sections.php' ) );
		include( locate_template( 'template-parts/classic-blocks/sections.php' ) );
	}
}










