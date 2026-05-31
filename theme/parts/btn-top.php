<?php
$couleur_1 = get_theme_mod( 'main_color'); 
$couleur_2 = get_theme_mod( 'secondary_color');
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

<button id="back-to-top">
    <span class="material-symbols-outlined">north</span>
</button>

<style>
    #back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999;
        width: 50px;
        height: 50px;
        border: none;
        background-color: <?php echo esc_attr($couleur_1); ?>;
        color: white;
        
        /* Flexbox pour centrer parfaitement la flèche */
        display: flex;
        justify-content: center;
        align-items: center;
        
        cursor: pointer;
        box-shadow: 0 2px 10px #00000033;
        
        /* CACHÉ PAR DÉFAUT */
        opacity: 0;
        visibility: hidden;
        transform: translateY(20px);
        transition: all 0.3s ease-in-out;
    }

    /* AFFICHÉ (ajouté par le JS) */
    #back-to-top.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    #back-to-top:hover {
        background-color: <?php echo esc_attr($couleur_2); ?>;
        transform: scale(1.1) translateY(0); /* On garde translateY(0) au survol */
    }
    
    /* Style de l'icône elle-même */
    .material-symbols-outlined {
        font-size: 20px; /* Taille de la flèche */
        font-weight: bold;
    }
</style>