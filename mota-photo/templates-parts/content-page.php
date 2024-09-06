<?php
/**
 * Template part for displaying page content in page.php
 *
 */
?>
<main>
	<div class="page-content">
		<section class="post">
			<?php
			the_content();
	
			wp_link_pages(
				array(
					'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'mota-photo' ) . '">',
					'after'    => '</nav>',
					/* translators: %: Page number. */
					'pagelink' => esc_html__( 'Page %', 'mota-photo' ),
				)
			);
			?>
		</section>
	</div>
</main>