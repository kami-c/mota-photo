<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <?php wp_head(); ?>
    </head>
    
<body>
    <header>
        <nav class="navbar">
            <a href="<?php echo home_url( '/' ); ?>">
                <img class="navbar__logo" src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.webp" alt="Logo">
            </a>

            <?php 
                wp_nav_menu(
                    array(
                        'theme_location' => 'main',
                        'container' => 'ul',
                        'menu_class' => 'navbar__menu',
                    ) 
                );
            ?>
        </nav>
    </header>
