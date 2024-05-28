<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title( '-', true, 'right' ); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="Nathalie MOTA, site de photographie pour vos évènements">
        <?php wp_head(); ?>
    </head>
    
<body <?php body_class(); ?>>
    <header>
        <a class="logo" href="<?php echo home_url( '/' ); ?>">
            <img class="logo__img" width="215" height="14"  src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.webp" alt="Logo">
        </a>        
      
        <input class="menu__btn" type="checkbox" id="menu-btn" />

        <label class="menu-icon" for="menu-btn">
          <span class="navicon"></span>
        </label>        
        <nav class="navbar" role="navigation" aria-label="Menu principal">
            <?php 
                wp_nav_menu(
                    array(
                        'theme_location' => 'main',
                        'container' => 'ul',
                        'menu_class' => 'navbar__menu',
                        'menu_id' => 'primary-menu',
                    )
                );
            ?>
        </nav>
    </header>
