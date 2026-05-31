<?php 
$id_page_accueil = get_option('page_on_front');
$couleur_1 = get_theme_mod( 'main_color'); 
$couleur_2 = get_theme_mod( 'secondary_color');
?>

<style>
    .sub-menu-links {background-color: <?php echo esc_attr($couleur_1) . '80'; ?> !important;}
    .sub-menu-links a {color: <?php echo esc_attr($couleur_2); ?> !important;}
    .sub-menu-links a:hover {
        transform: scale(1.01);
        color: <?php echo esc_attr($couleur_2); ?> !important;
        filter: brightness(2.2);}
    .sub-menu-links a.active {
        transform: scale(1.1);
         color: <?php echo esc_attr($couleur_2); ?> !important;
        filter: brightness(2.2);
        border-bottom-color: <?php echo esc_attr($couleur_2); ?> !important;}
</style>