<?php
/*
Template Name: Page Contact
*/

get_header(); 
get_template_part( 'parts/sub-menu' );
get_template_part( 'parts/btn-top' );
$id_page_accueil = get_option('page_on_front');
$couleur_1 = get_theme_mod( 'main_color'); 
$couleur_2 = get_theme_mod( 'secondary_color');
$args = array(
    'post_type'      => 'sport',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC'
);
$sports_query = new WP_Query($args);
$bat = ''; $adresse_label = ''; $adresse_url = ''; $tel = ''; $email = '';
$coord_query = new WP_Query('post_type=coordonnees&posts_per_page=1');
if ( $coord_query->have_posts() ) {
    $coord_query->the_post();
    $id_fiche = get_the_ID();
    $bat = carbon_get_post_meta($id_fiche, 'bat');
    $tel = carbon_get_post_meta($id_fiche, 'tel');
    $email = carbon_get_post_meta($id_fiche, 'email');
    $adresse_label = carbon_get_post_meta($id_fiche, 'adresse_label');
    $adresse_url = carbon_get_post_meta($id_fiche, 'adresse_url');
    
    wp_reset_postdata();
}
?>

<style>
    .contact-info-box { border-left: 5px solid <?php echo esc_attr($couleur_2);?>; }
    .contact-info-box h3, .contact-form-box h3 {color: <?php echo esc_attr($couleur_2);?>; }
    .contact-page-container .address-link::before {
    width: 30px !important; 
    height: 30px !important;}
    .info-item .details a:hover {color: <?php echo esc_attr($couleur_1);?>;    }
    .wpcf7-form input:focus, .wpcf7-form textarea:focus {
        border-color: <?php echo esc_attr($couleur_2);?>;
        outline: none; }
    .wpcf7-submit { background-color: <?php echo esc_attr($couleur_1);?>; }
    .wpcf7-submit:hover {
        background-color: <?php echo esc_attr($couleur_2);?>;
        transform: scale(1.05); }
    .sport-row-content h3 { color: <?php echo esc_attr($couleur_2);?> }
    .sport-row-img img { border-right: 10px solid <?php echo esc_attr($couleur_2);?>; }
    .sport-row-content .phone-link {
        color: <?php echo esc_attr($couleur_2);?>;
        background-color: <?php echo esc_attr($couleur_1) . '50';?>
    }
    .btn-vers-sport {
        background-color: <?php echo esc_attr($couleur_1); ?>;
        border: 2px solid <?php echo esc_attr($couleur_1); ?>;
    }
    .btn-vers-sport:hover { color: <?php echo esc_attr($couleur_1); ?>; }
</style>

<div class="sub-menu-links">
    <a href="#contact">CONTACTEZ-NOUS ICI</a>
    <?php 
    if ( $sports_query->have_posts() ) :
        while ( $sports_query->have_posts() ) : $sports_query->the_post(); 
            ?>
            <a href="#<?php echo $post->post_name; ?>"><?php the_title(); ?></a>
        <?php 
        endwhile; 
    endif; 
    ?>
</div>

<div class="contact-page-container">
    
    <header class="category-header">
        <h2 class="h2-style">CONTACTEZ-NOUS ICI</h2>
    </header>

    <section id="contact" class="anchor-offset"></section>

    <div class="contact-layout">
        
        <div class="contact-info-box">
            <h3>Nos Coordonnées</h3>
            
            <div class="info-item">
                <span class="icon address-link"></span>
                <div class="details">
                    <strong>Adresse :</strong>
                    <?php if($bat): ?>
                        <br><?php echo esc_html($bat); ?>
                    <?php endif; ?>
                    
                    <?php if($adresse_url): ?>
                        <br>
                        <a href="<?php echo esc_url($adresse_url); ?>" target="_blank">
                            <?php echo esc_html($adresse_label ? $adresse_label : 'Voir sur le plan'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="info-item">
                <span class="icon phone-link"></span>
                <div class="details">
                    <strong>Téléphone :</strong>
                    <?php if($tel): ?>
                        <br>
                        <a href="tel:<?php echo str_replace(' ', '', $tel); ?>">
                            <?php echo esc_html($tel); ?>
                        </a>
                    <?php else: ?>
                        <br>Non renseigné
                    <?php endif; ?>
                </div>
            </div>

            <div class="info-item">
                <span class="icon email-link"></span>
                <div class="details">
                    <strong>Email :</strong>
                    <?php if($email): ?>
                        <br>
                        <a href="mailto:<?php echo esc_attr($email); ?>">
                            <?php echo esc_html($email); ?>
                        </a>
                    <?php else: ?>
                        <br>Non renseigné
                    <?php endif; ?>
                </div>
            </div>

            <div class="contact-map">
                <?php if( $adresse_url ): 
                    $recherche = urlencode( trim($bat . ' ' . $adresse_label) );
                ?>
                    <iframe 
                        src="https://maps.google.com/maps?q=<?php echo $recherche; ?>&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                <?php endif; ?>
            </div>            
        </div>

        <div class="contact-form-box">
            <h3>Envoyer un message</h3>
            <?php 
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile; 
            ?>
        </div>

    </div>

    <hr>

    <div class="sports-vertical-list">
    <?php 
    $sports_query->rewind_posts();
    if ( $sports_query->have_posts() ) :
        while ( $sports_query->have_posts() ) : $sports_query->the_post();
            $img_url = carbon_get_the_post_meta('img_sports');
            $contacts = carbon_get_the_post_meta('sport_contacts');
            ?>

            <section id="<?php echo $post->post_name; ?>" class="sport-row anchor-offset"> 
                <div class="sport-row-img">
                    <?php if($img_url): ?>
                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/img/default.jpg" alt="Image à définir">
                    <?php endif; ?>
                </div>

                <div class="sport-row-content">
                    <h3><?php the_title(); ?></h3>
                    <?php 
                    if ( ! empty( $contacts ) ) : 
                        foreach ( $contacts as $contact ) : 
                    ?>
                        <div class="resp-block" style="margin-top: 20px;">
                            <p class="resp-name">
                                <?php echo esc_html( $contact['nom'] ); ?>
                            </p>
                            <?php if( ! empty( $contact['tel'] ) ): ?>
                                <a href="tel:<?php echo str_replace(' ', '', $contact['tel']); ?>" class="phone-link">
                                    <?php echo esc_html( $contact['tel'] ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php 
                        endforeach;
                    else:
                        echo '<p><em>Non renseigné pour le moment.</em></p>';
                    endif; 
                    ?>

                    <div class="sport-btn-container">
                        <a href="<?php the_permalink(); ?>" class="btn-vers-sport">
                            Aller sur la page <?php the_title(); ?> →
                        </a>
                    </div>
                </div>
            </section>

            <?php 
            if ( ($sports_query->current_post + 1) < $sports_query->post_count ) {
                echo '<hr>'; 
            }
            ?>

        <?php 
        endwhile;
        wp_reset_postdata();
    else : 
        ?>
        <p style="text-align:center;">Aucune activité ajoutée.</p>
    <?php endif; ?>

</div>

</div>

<?php get_footer(); ?>