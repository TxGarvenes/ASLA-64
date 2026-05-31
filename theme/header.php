<?php
$id_page_accueil = get_option('page_on_front');
$couleur_1 = get_theme_mod( 'main_color'); 
$couleur_2 = get_theme_mod( 'secondary_color');
$custom_logo_id = get_theme_mod( 'custom_logo' );
$pdf_inscription = get_theme_mod('global_fiche_inscription');
$pdf_sortie = get_theme_mod('global_auth_sortie');
$pdf_activites = get_theme_mod('global_activites');
$big_url        = '';
if ( $custom_logo_id ) {
    $image_logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
    $big_url    = $image_logo[0];
}
$small_url = get_site_icon_url( 192 );
if ( ! $small_url ) {
    $small_url = $big_url;
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FONT "ARVO" -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@700&display=swap" rel="stylesheet">
    <!-- FONT "NUNITO" -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <!-- FONT "OUTIFT" -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>

    <style>
        /* DESKTOP */
        .menu-nav {background-color: <?php echo esc_attr($couleur_1); ?>;}
        .main-nav a::after {background-color: <?php echo esc_attr($couleur_2); ?>;}
        .main-nav .current-menu-item a {
            background-color: <?php echo esc_attr($couleur_2); ?>;
            color: white !important;}
        .main-nav li:not(.current-menu-item) a:hover {color: <?php echo esc_attr($couleur_2); ?>;}
        body.page-template-actualites .main-nav li:first-child a {
            background-color: <?php echo esc_attr($couleur_2); ?>;
            color: white !important;
        }
        .docs-dropdown, .more-dropdown { 
            background-color: <?php echo esc_attr($couleur_1); ?> !important;
            box-shadow: inset 0px 4px 0px rgba(0,0,0,0.08), 0 4px 10px rgba(0,0,0,0.2) !important; 
        }
        .docs-dropdown a, .more-dropdown a {
            color: white !important;
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        }
        .docs-dropdown a:hover, .more-dropdown a:hover { 
            color: <?php echo esc_attr($couleur_2); ?> !important;
            filter: brightness(1.5);
            background-color: rgba(0,0,0,0.1) !important;
        }
        
        /* MEDIA QUERIES : MOBILE */
        @media screen and (max-width: 768px) {
            .main-nav { background-color: <?php echo esc_attr($couleur_1); ?>;}
        }
    </style>
</head>

<body <?php body_class(); ?>>

<header class="site-header">
    
    <div class="logo-header-area">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php if ( $big_url ) : ?>
                <img src="<?php echo esc_url( $big_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
            <?php else : ?>
                <h1><?php bloginfo( 'name' ); ?></h1>
            <?php endif; ?>
        </a>
    </div>

    <div class="menu-nav">
        
        <?php if ( $small_url || $big_url ) : ?>
        <div class="small-logo-container">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img class="logo-pc-scroll" src="<?php echo esc_url( $small_url ); ?>" alt="Icône">
                
                <?php if ( $big_url ) : ?>
                    <img class="logo-mobile-full" src="<?php echo esc_url( $big_url ); ?>" alt="Logo Principal">
                <?php endif; ?>
            </a>
        </div>
        <?php endif; ?>

        <button class="burger-menu" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="main-nav">
            <div class="desktop-only-menu">
                <ul class="nav-list-desktop">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'menu-principal',
                        'container'      => false,
                        'items_wrap'     => '%3$s', /* Permet de retirer le <ul> généré par WP pour tout grouper proprement */
                    ) );
                    ?>
                    
                    <?php if ( $pdf_inscription || $pdf_sortie || $pdf_activites ) : ?>
                        <li id="custom-docs">
                            <a href="#" onclick="event.preventDefault();">Documents <span class="arrow-dropdown">▼</span></a>
                            <ul class="docs-dropdown">
                                <?php if ( $pdf_activites ) : ?>
                                    <li><a href="<?php echo esc_url( $pdf_activites ); ?>" target="_blank" class="pdf-link">Planning des Activités</a></li>
                                <?php endif; ?>
                                <?php if ( $pdf_inscription ) : ?>
                                    <li><a href="<?php echo esc_url( $pdf_inscription ); ?>" target="_blank" class="pdf-link">Fiche d'inscription</a></li>
                                <?php endif; ?>
                                <?php if ( $pdf_sortie ) : ?>
                                    <li><a href="<?php echo esc_url( $pdf_sortie ); ?>" target="_blank" class="pdf-link">Autorisation de sortie</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <ul class="mobile-only-menu">
                <li class="menu-main-title">Menu</li>

                <li class="<?php echo (is_front_page()) ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a>
                </li>
                
                <li class="<?php echo (is_page('contact')) ? 'current-menu-item' : ''; ?>">
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a>
                </li>
                
                <li class="category-title">Activités ASLA</li>
                
                <?php 
                $sports_mobile = get_posts( array( 
                    'post_type'   => 'sport', 
                    'numberposts' => -1, 
                    'orderby'     => 'title', 
                    'order'       => 'ASC' 
                ) );
                
                foreach ( $sports_mobile as $sport ) : 
                    $active_class = ( is_singular('sport') && get_the_ID() == $sport->ID ) ? 'current-menu-item' : '';
                ?>
                    <li class="<?php echo $active_class; ?>">
                        <a href="<?php echo get_permalink($sport->ID); ?>"><?php echo esc_html($sport->post_title); ?></a>
                    </li>
                <?php endforeach; ?>
                
                <?php if ( $pdf_inscription || $pdf_sortie || $pdf_activites ) : ?>
                    <li class="category-title">Documents ASLA</li>
                    <?php if ( $pdf_activites ) : ?>
                        <li><a href="<?php echo esc_url( $pdf_activites ); ?>" target="_blank" class="pdf-link">Planning des Activités</a></li>
                    <?php endif; ?>
                    <?php if ( $pdf_inscription ) : ?>
                        <li><a href="<?php echo esc_url( $pdf_inscription ); ?>" target="_blank" class="pdf-link">Fiche d'inscription</a></li>
                    <?php endif; ?>
                    <?php if ( $pdf_sortie ) : ?>
                        <li><a href="<?php echo esc_url( $pdf_sortie ); ?>" target="_blank" class="pdf-link">Autorisation de sortie</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

</header>