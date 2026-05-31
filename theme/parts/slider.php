<?php
$id_page_accueil = get_option('page_on_front');
$couleur_1 = get_theme_mod( 'main_color'); 
$couleur_2 = get_theme_mod( 'secondary_color');
$default_img = get_template_directory_uri() . '/images/default.jpg'; 
?>
<style>
    .custom-slider {border: 10px solid <?php echo esc_attr($couleur_2); ?>; }
    .slide-content {border-left: 5px solid <?php echo esc_attr($couleur_1); ?>;}
    .slide-title {color: <?php echo esc_attr($couleur_2); ?>;}
    .slide-link {color: <?php echo esc_attr($couleur_1); ?>;}
    .slider-arrow {background-color: <?php echo esc_attr($couleur_1); ?>;}
    .slider-arrow:hover {
        background-color: <?php echo esc_attr($couleur_2); ?> !important;
        transform: translateY(-50%) scale(1.1);
        border-color: <?php echo esc_attr($couleur_1); ?> !important;}
    .indicator-dash.active {
        background-color: <?php echo esc_attr($couleur_1); ?> !important;
        width: 80px;}
    .indicator-dash:hover {background-color: <?php echo esc_attr($couleur_2); ?> !important;}

    /* ======================================== MOBILE ======================================== */
    @media screen and (max-width: 768px) {
        .custom-slider {
            height: 200px;
            border: 5px solid <?php echo esc_attr($couleur_2); ?>;
        }
    }
</style>