<?php
/**
 * Modèle pour la page d'erreur 404 (Introuvable)
 */

get_header(); 
get_template_part( 'parts/btn-top' );

$couleur_1 = get_theme_mod( 'main_color'); 
$couleur_2 = get_theme_mod( 'secondary_color');
?>

<style>
    .error-404-container .error-code {
        color: <?php echo esc_attr($couleur_2); ?>;
        text-shadow: 4px 4px 0px <?php echo esc_attr($couleur_1); ?>20;
    }

    .btn-retour-accueil {
        background-color: <?php echo esc_attr($couleur_1); ?>;
    }

    .btn-retour-accueil:hover {
        background-color: <?php echo esc_attr($couleur_2); ?>;
    }
</style>

<div class="error-404-container">
    <h1 class="error-code">404</h1>
    <h2 class="error-title">Oups ! Page introuvable</h2>
    <p class="error-text">
        Il semblerait que rien n'ait été trouvé à cette adresse. <br>
        La page que vous recherchez n'existe plus, a été déplacée ou l'URL est incorrecte.
    </p>
    
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-retour-accueil">
        Retourner à l'accueil
    </a>
</div>

<?php get_footer(); ?>