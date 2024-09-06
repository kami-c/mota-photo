<?php
/**
 * The template for displaying all single posts photo
 */

get_header(); ?>

<main>
    <?php 
    if( have_posts() ) :
      while( have_posts() ) :
        the_post();

        get_template_part( 'templates-parts/content-single' );
      
      endwhile; 
    endif; ?>
  </main>
<?php get_footer(); ?>


