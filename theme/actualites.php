<?php
/*
Template Name: Page Actualités
*/

get_header();
get_template_part( 'parts/btn-top' );
$id_page_accueil = get_option('page_on_front');
$couleur_1 = get_theme_mod( 'main_color'); 
$couleur_2 = get_theme_mod( 'secondary_color');
?>

<div class="category-page-container">
    <style>
        h3 {color: <?php echo esc_attr($couleur_2); ?> !important;}
        .post-date {color: <?php echo esc_attr($couleur_1); ?>;}
        .page-numbers.current {
            background-color: <?php echo esc_attr($couleur_2); ?>;
            border-color: <?php echo esc_attr($couleur_2); ?>;
        }
        .page-numbers:hover:not(.current) {
            color: <?php echo esc_attr($couleur_1); ?>;
            border-color: <?php echo esc_attr($couleur_1); ?>;
        }
    </style>
    

    <header class="category-header">
        <h2 class="h2-style">NOS ACTUALITÉS</h2>
    </header>

    <div class="news-section">
        <?php 
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 10,
            'paged'          => $paged,
        );
        $actu_query = new WP_Query($args);
        ?>
        <?php if ( $actu_query->have_posts() ) : ?>
            
            <?php while ( $actu_query->have_posts() ) : $actu_query->the_post(); ?>
                
                <article class="post">
                    
                    <h3><?php the_title(); ?></h3>

                    <div class="post-date">
                        Publié le <?php echo get_the_date(); ?>
                    </div>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="post-content-body">
                        <?php the_content(); ?>
                    </div>
                    
                </article>
                
                <hr>

            <?php endwhile; ?>

        <?php else : ?>
            <p>Aucune actualité pour le moment.</p>
        <?php endif; ?>

    </div>

    <div class="pagination-area" id="fin">
        <?php
        echo paginate_links( array(
            'total'        => $actu_query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_text'    => '❮ Précédent',
            'next_text'    => 'Suivant ❯',
        ) );
        ?>
    </div>
    
    <?php wp_reset_postdata(); ?>

</div>

<?php get_footer(); ?>