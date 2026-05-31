<?php
$id_page_accueil = get_option('page_on_front');
$couleur_1 = get_theme_mod( 'main_color');
$couleur_2 = get_theme_mod( 'secondary_color');
$custom_logo_id = get_theme_mod( 'custom_logo' );
$big_url = '';
if ( $custom_logo_id ) {
    $image_logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
    $big_url = $image_logo[0];
}
$bat = ''; 
$tel_asso = ''; 
$email = '';
$adresse_label = '';
$adresse_url = '';
$coord_query = new WP_Query('post_type=coordonnees&posts_per_page=1');
if ( $coord_query->have_posts() ) {
    $coord_query->the_post();
    $id_fiche = get_the_ID();
    $bat = carbon_get_post_meta($id_fiche, 'bat');
    $tel_asso = carbon_get_post_meta($id_fiche, 'tel');
    $email = carbon_get_post_meta($id_fiche, 'email');
    $adresse_label = carbon_get_post_meta($id_fiche, 'adresse_label');
    $adresse_url   = carbon_get_post_meta($id_fiche, 'adresse_url');
    wp_reset_postdata();
}
?>

<style>
    .site-footer {
        background-color: <?php echo esc_attr($couleur_1); ?>;
        border-top: 5px solid <?php echo esc_attr($couleur_2); ?>;}
    .footer-block h3 {
        color: <?php echo esc_attr($couleur_2); ?>;
        border-bottom: 2px solid <?php echo esc_attr($couleur_2); ?>;}
    .footer-block a:hover {
        color: <?php echo esc_attr($couleur_2); ?>;
        filter: brightness(1.4);}
    .footer-copyright {
        border-top: 5px solid <?php echo esc_attr($couleur_2);?>;}
</style>

<footer class="site-footer">
    <div class="footer-container">
        
        <div class="footer-main-col left-col">
            
            <div class="footer-block">
                <h3>Nous situer</h3>
                <ul class="footer-links-list address-info">
                    
                    <?php if($bat): ?>
                        <li>
                            <span class="asso-name"><?php echo esc_html($bat); ?></span>
                        </li>
                    <?php endif; ?>
                    
                    <?php if($adresse_url): ?>
                        <li>
                            <a href="<?php echo esc_url($adresse_url); ?>" target="_blank" class="address-link">
                                <?php echo esc_html( $adresse_label ? $adresse_label : 'Voir sur le plan' ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if($tel_asso): ?>
                        <li>
                            <a href="tel:<?php echo str_replace(' ', '', $tel_asso); ?>" class="phone-link">
                                <?php echo esc_html($tel_asso); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if($email): ?>
                        <li>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="email-link">
                                <?php echo esc_html($email); ?>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

            <div class="footer-block">
                <h3>Liens utiles</h3>
                <div class="footer-links-list simple-list">
                    <?php 
                    wp_nav_menu( array(
                        'theme_location' => 'footer-link',
                        'container'      => false,
                        'fallback_cb'    => false
                    ) ); 
                    ?>
                </div>
            </div>
            
        </div>

        <div class="footer-main-col right-col">
            
            <div class="footer-block">
                <h3>Plan du site</h3>
                <div class="footer-links-list double-column-list">
                    <?php 
                    wp_nav_menu( array(
                        'theme_location' => 'footer-plan',
                        'container'      => false,
                        'fallback_cb'    => false
                    ) ); 
                    ?>
                </div>
            </div>

            <div class="footer-logo-container">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php if ( $big_url ) : ?>
                        <img src="<?php echo esc_url( $big_url ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                    <?php else : ?>
                        <h1><?php bloginfo( 'name' ); ?></h1>
                    <?php endif; ?>
                </a>
            </div>

        </div>

    </div>

    <div class="footer-copyright">
        <p><?php echo date('Y'); ?> - <?php bloginfo( 'name' ); ?> - Tous droits réservés</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>