        <footer class="footer">
        	<?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'container' => 'ul',
                        'menu_class' => 'footer__menu'
                    )
                );
            ?> 
            
            <p>Tous droits réservés</p>
        </footer>
    
    	<?php wp_footer(); ?>
    </body>
</html>