        <footer class="footer">
        	<?php // MENU FOOTER
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'container' => 'ul',
                        'menu_class' => 'footer__menu'
                    )
                ); 
            ?>

        </footer>

    	<?php 
        echo get_template_part( 'templates-parts/contact' );
        wp_footer(); 
        ?>
    </body>
</html>