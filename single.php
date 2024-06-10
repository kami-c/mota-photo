<?php
/**
 * The template for displaying all single posts
 */
get_header(); 
?>
  <main>
    <?php 
    if( have_posts() ) :
      while( have_posts() ) :
        the_post();
        get_template_part( 'templates_part/photo_details' );
      endwhile; 
    endif; ?>
  </main>
<?php get_footer(); ?>
