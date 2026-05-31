<?php
/*
Template Name: Page Accueil
*/

get_header();
get_template_part( 'parts/sub-menu' );
get_template_part( 'parts/slider' );
get_template_part( 'parts/btn-top' );

$id_page_accueil = get_option('page_on_front');
$couleur_1 = get_theme_mod( 'main_color'); 
$couleur_2 = get_theme_mod( 'secondary_color');

$args_slider = array(
    'post_type'      => 'sport',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC'
);
$slider_query = new WP_Query($args_slider);
$texte_asso = carbon_get_the_post_meta( 'txt_asso' );

?>

<div class="sub-menu-links">
    <a href="#sports">DÉCOUVRIR NOS ACTIVITÉS</a>
    <a href="#actu">ACTUALITÉS</a>
    <a href="#asso">NOTRE ASSOCIATION</a>
</div>

<main class="homepage-container">
    <style>       
        /* ACTUALITÉS */
        .post h3 { color: <?php echo esc_attr($couleur_2); ?> !important; }
        .post-date { color: <?php echo esc_attr($couleur_1); ?>; }
        .btn-actu { background-color: <?php echo esc_attr($couleur_2); ?> !important; }
        .btn-actu:hover { background-color: <?php echo esc_attr($couleur_1); ?> !important; }
    </style>

    <section id="sports" class="anchor-offset"></section>
        <h2 class="h2-style"> DÉCOUVRIR NOS ACTIVITÉS :</h2>

        <div class="custom-slider">
            <div class="slider-track">
                <?php 
                if ( $slider_query->have_posts() ) :
                    while ( $slider_query->have_posts() ) : $slider_query->the_post(); 
                        $desc = carbon_get_the_post_meta('desc'); 
                        $cf_img_url = carbon_get_the_post_meta('img_carrousel');
                        if ( $cf_img_url ) {
                            $final_img_url = $cf_img_url;
                        } else {
                            $final_img_url = get_template_directory_uri() . '/img/default.jpg';
                        }
                        $link_url = site_url('/sport/') . $post->post_name;
                    ?>
                    
                    <div class="slide" style="background-image: url('<?php echo esc_url($final_img_url); ?>');">
                        
                        <div class="slide-content">
                            <h2 class="slide-title"><?php the_title(); ?></h2>
                            
                            <?php if($desc): ?>
                                <div class="slide-desc"><?php echo nl2br( esc_html($desc) ); ?></div>
                            <?php endif; ?>
                            
                            <a href="<?php echo esc_url($link_url); ?>" class="slide-link">
                                En savoir plus...
                            </a>
                        </div>
                        <div class="slide-overlay"></div>
                    </div>
                <?php 
                    endwhile; 
                else: 
                    echo '<p style="text-align:center; padding:20px;">Aucune activité pour le moment.</p>';
                endif;
                ?>
            </div>

            <button class="slider-arrow prev-arrow"></button>
            <button class="slider-arrow next-arrow"></button>

            <div class="slider-indicators">
                <?php 
                $total_slides = $slider_query->post_count;
                for ($i = 0; $i < $total_slides; $i++) {
                    $active_class = ($i === 0) ? 'active' : '';
                    echo '<div class="indicator-dash ' . $active_class . '" data-slide-to="' . $i . '"></div>';
                }
                wp_reset_postdata(); 
                ?>
            </div>

        </div>
    </section>

    <hr>

    <section id="actu" class="news-section anchor-offset"></section>
        <h2 class="h2-style"> DERNIÈRE ACTUALITÉ :</h2>
        
            <div class="post">
                <?php 
                $last_post = new WP_Query('posts_per_page=1');
                
                if ( $last_post->have_posts() ) : 
                    while ( $last_post->have_posts() ) : $last_post->the_post(); ?>
                        
                        <h3><?php the_title(); ?></h3>
                        
                        <p class="post-date">Publié le <?php echo get_the_date(); ?></p>
                        
                        <div class="post-content">
                            <?php the_content(); ?>
                        </div>

                    <?php endwhile; 
                    wp_reset_postdata(); 
                else : ?>
                    <p>Pas d'actualité pour le moment.</p>
                <?php endif; ?>
            </div>

        <div class="all-news-link">
            <a href="<?php echo site_url('/actualites'); ?>" class="btn-actu">Voir toutes les actualités</a>
        </div>
    </section>

    <hr>

    <section id="asso" class="about-section anchor-offset"></section>
        <h2 class="h2-style">NOTRE ASSOCIATION</h2>
        <div class="about-text">
            <?php
            if( $texte_asso ) {
                echo $texte_asso; 
            } else {
                echo "<p>À remplir.</p>";
            }
            ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>