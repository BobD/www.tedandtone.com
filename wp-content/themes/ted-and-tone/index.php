<?php
/**
 * This is the index template of the Ted and Tone website theme.
 * This template is the ultimate fallback in the Wordpress template hierarchy and will rarely be used in this theme.  
 * If you're looking for the template used as the home page, check out front-page.php
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::get_context();
$context['posts'] = Timber::get_posts();
$templates = array( 'home.twig' );
if ( is_home() ) {
	array_unshift( $templates, 'blog.twig' );
}
Timber::render( $templates, $context );