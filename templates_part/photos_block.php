<section class="photo-bloc">
    <?php

        $args = array( // ARGUMENTS TO RECOVERY OF PHOTOS
            'post_type'             => 'photos',
            'posts_per_page'        => 8,
            'orderby'               => 'DESC',
        );

        $id_query = new WP_Query( $args ); // EXCECUTION OF WP_QUERY

        if( $id_query->have_posts() ) : // CONDITION : If there are posts to display  
            while( $id_query->have_posts() ) : // LOOP : While there are posts at each iteration
                $id_query->the_post(); // APPLY WP_QUERY TO THE POSTS

                // CONTENT DISPLAY MANAGEMENT
                $content = get_the_content(); // Content retrieval
                $content = apply_filters('the_content', $content); // Apply filters
                $content = str_replace(array('<p>', '</p>'), '', $content); // Remove the auto tag <p></p>

                $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); // URL of the image attached to the current post

                if ( $image_url ) : // CONDITION : If there are $image_url
                // DISPLAY ?>
                    <a class="photo-bloc__img" href="<?php echo esc_url( get_permalink() ); // URL of the current post ?>">
                        <img src="<?php echo esc_url( $image_url[0] ); ?>" alt="<?php the_title_attribute(); ?>" class="photo-bloc__img">
                    </a>
                <?php
                endif;

            endwhile;
            
        // RESET OF THE MAIN QUERY
        wp_reset_postdata();
        else :
            echo 'Aucun post trouvé';
        endif;
    ?>
</section>