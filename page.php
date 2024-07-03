<?php
/**
 * The template for displaying all page
 * 
 * @package WordPress
 * 
 */

get_header();

while ( have_posts() ) :
	the_post();

 	get_template_part( 'templates-parts/content-page' );
	
endwhile; 

get_footer(); ?>
