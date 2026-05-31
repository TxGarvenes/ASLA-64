<?php
get_header();
get_template_part( 'parts/sub-menu' );
get_template_part( 'parts/slider' );
get_template_part( 'parts/btn-top' );


$couleur_1 = get_theme_mod( 'main_color');
$couleur_2 = get_theme_mod( 'secondary_color');
$presentation = carbon_get_the_post_meta('presentation'); 
$horaires = carbon_get_the_post_meta('sport_horaires');
$paiement = carbon_get_the_post_meta('paiement');
$galerie = carbon_get_the_post_meta('sport_galerie');
$contacts = carbon_get_the_post_meta('sport_contacts');
$pdf_inscription = get_theme_mod('global_fiche_inscription');
$pdf_sortie = get_theme_mod('global_auth_sortie');
$valeur_case = carbon_get_the_post_meta('display_sortie');
$afficher_sortie = !empty($valeur_case);
$text_inscription = get_theme_mod('global_fiche_inscription_text');
$text_sortie = get_theme_mod('global_auth_sortie_text');
$valeur_case = carbon_get_the_post_meta('display_sortie');
$afficher_sortie = !empty($valeur_case);
?>

<style>
    h1 {color: <?php echo esc_attr($couleur_2); ?>;}
    thead {background-color: <?php echo esc_attr($couleur_1); ?>}
    .btn-download {
        background-color: <?php echo esc_attr($couleur_2); ?>;
        color: white;}
    .btn-download:hover {background-color: <?php echo esc_attr($couleur_1); ?>;}
    .phone-link {
        background-color: <? echo esc_attr($couleur_1) . '50'; ?>;
        color: <? echo esc_attr($couleur_2); ?>;
        }
</style>

<div class="sub-menu-links">
    <a href="#presentation">PRÉSENTATION</a>
    <?php if( !empty($horaires) ): ?>
        <a href="#horaires">HORAIRES & TARIFS</a>
    <?php endif; ?>
    <?php if( !empty($galerie) ): ?>
        <a href="#sports">GALERIE</a>
    <?php endif; ?>
    <?php if( $pdf_inscription ): ?>
        <a href="#inscription">INSCRIPTION</a>
    <?php endif; ?>
    <?php if( $pdf_sortie && $afficher_sortie ): ?>
        <a href="#sortie">AUTORISATION SORTIE</a>
    <?php endif; ?>
    <?php if( !empty($contacts) ): ?>
        <a href="#contact">CONTACT</a>
    <?php endif; ?>
</div>

<div class="sport-single-container">

    <header class="sport-header">
        <h1><?php the_title(); ?></h1>
    </header>

    <section class="post-content-body anchor-offset" id="presentation">
        <?php echo wpautop($presentation); ?>
    </section>

    <hr>

    <section class="horaires-container anchor-offset"  id="horaires">
       <?php if( !empty($horaires) ): ?>
        <?php 
        $a_des_groupes = false;
        foreach($horaires as $check_ligne) {
            if( !empty($check_ligne['groupe']) ) {
                $a_des_groupes = true;
                break; 
            }
        }
        ?>

            <h2 class="h2-style"><?php echo $a_des_groupes ? 'Groupes, Horaires & Tarifs' : 'Horaires & Tarifs'; ?></h2>
            
            <div class="table-responsive">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            
                            <?php if( $a_des_groupes ): ?>
                                <th>Groupe</th>
                            <?php endif; ?>
                            <th>Créneau</th>
                            <th>Tarifs</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $horaires as $ligne ): ?>
                            <tr>
                                <?php if( $a_des_groupes ): ?>
                                    <td><strong><?php echo esc_html( $ligne['groupe'] ); ?></strong></td>
                                <?php endif; ?>
                                
                                <td><?php echo esc_html( $ligne['horaire'] ); ?></td>

                                <td><?php echo esc_html( $ligne['tarif'] ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if ( !empty($paiement) ): ?>
                    <p id="paiement"><?php echo nl2br( $paiement ); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </section>

    <?php if( !empty($galerie) ): ?>
    <hr>
    
    <section id="sports" class="sport-section anchor-offset">        
        <div class="custom-slider">
            <div class="slider-track">
                <?php 
                $counter = 0;
                foreach( $galerie as $index => $item ): 
                    if( empty($item['photo']) ) continue;
                    
                    $titre_photo = isset($item['titre']) ? $item['titre'] : '';
                    $legende_photo = isset($item['legende']) ? $item['legende'] : '';
                    $active_class = ($counter === 0) ? 'active' : ''; 
                ?>
                    <div class="slide <?php echo $active_class; ?>" style="background-image: url('<?php echo esc_url($item['photo']); ?>');">
                        
                        <div class="slide-overlay"></div>
                        
                        <?php if( !empty($titre_photo) || !empty($legende_photo) ): ?>
                        <div class="slide-content">
                            <?php if( !empty($titre_photo) ): ?>
                                <h2 class="slide-title"><?php echo esc_html($titre_photo); ?></h2>
                            <?php endif; ?>
                            
                            <?php if( !empty($legende_photo) ): ?>
                                <div class="slide-desc"><?php echo esc_html($legende_photo); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                    </div>
                <?php 
                    $counter++;
                endforeach; 
                ?>
            </div>

            <button class="slider-arrow prev-arrow"></button>
            <button class="slider-arrow next-arrow"></button>

            <div class="slider-indicators">
                <?php 
                $indicator_count = 0;
                foreach( $galerie as $item ): 
                    if( empty($item['photo']) ) continue;
                        $active_class = ($indicator_count === 0) ? 'active' : '';
                    ?>
                    
                    <div class="indicator-dash <?php echo $active_class; ?>" data-slide-to="<?php echo $indicator_count; ?>"></div>
                    
                    <?php 
                    $indicator_count++;
                endforeach; 
                ?>
            </div>

        </div>
    </section>
    
    <?php endif; ?>

    <hr>

    <?php if($pdf_inscription): ?>
    <section class="sport-section inscription-section anchor-offset" id="inscription">
        <h2 class="h2-style">Inscription</h2>
        
        <div class="inscription-layout">
            <div class="inscription-action" style="width:100%; text-align:center;">
                
                <p><?php echo esc_html($text_inscription); ?></p>
                
                <a href="<?php echo esc_url($pdf_inscription); ?>" class="btn-download" target="_blank" download>
                    Télécharger la fiche d'inscription (PDF)
                </a>
            </div>
        </div>
    </section>
    <hr>
    <?php endif; ?>


    <?php if($pdf_sortie && $afficher_sortie): ?>
    <section class="sport-section anchor-offset" id="sortie">
        <h2 class="h2-style">Autorisation parentale de sortie</h2>
        <div class="doc-block">
            
            <p><?php echo esc_html($text_sortie); ?></p>
            
            <a href="<?php echo esc_url($pdf_sortie); ?>" class="btn-download" target="_blank" download>
                Télécharger l'autorisation de sortie (PDF)
            </a>
        </div>
    </section>
    <hr>
    <?php endif; ?>


    <?php if( !empty($contacts) ): ?>
    <section class="sport-section contact-section anchor-offset" id="contact">
        <h2 class="h2-style">Contact <?php the_title(); ?></h2>
        
        <div class="contact-grid">
            <?php foreach( $contacts as $contact ): ?>
                <div class="contact-card">
                    
                    <div class="contact-info-inline">
                        <strong class="contact-name"><?php echo esc_html($contact['nom']); ?> : </strong>
                        
                        <?php if( !empty($contact['tel']) ): ?>
                            <a href="tel:<?php echo str_replace(' ','',$contact['tel']); ?>" class="phone-badge">
                                <span class="phone-link"><?php echo esc_html($contact['tel']); ?></span>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

</div>

<?php get_footer(); ?>