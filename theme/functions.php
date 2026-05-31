<?php
// ====================================== FONCTIONNEMENT BASIQUE THEME ASLA 64 ======================================
function mon_theme_setup() {
    add_theme_support( 'title-tag' );

    //LOGO
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    //GESTION MENUS
    register_nav_menus( array(
        'menu-principal' => 'Entête',
        'footer-link'    => 'Pied de Page Lien',
        'footer-plan'    => 'Pied de Page Plan',
    ) );
    
}
add_action( 'after_setup_theme', 'mon_theme_setup' );

/* ====================================== ACTIVATION CARBON FIELDS ====================================== */
use Carbon_Fields\Carbon_Fields;
add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( get_template_directory() . '/inc/carbon-fields/vendor/autoload.php' );
    Carbon_Fields::boot();
}
require_once get_template_directory() . '/inc/custom-fields.php';

/* ====================================== RÉGLAGES DE COULEURS ====================================== */
function mon_theme_customizer( $wp_customize ) {
    //COULEUR PRINCIPALE
    $wp_customize->add_setting( 'main_color', array(
        'default'           => '#d49c25',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( 
        $wp_customize, 
        'main_color_control',
        array(
            'label'    => __( 'Couleur Principale', 'mon-theme' ),
            'section'  => 'colors',
            'settings' => 'main_color',
        ) 
    ) );
    //COULEUR SECONDAIRE
    $wp_customize->add_setting( 'secondary_color', array(
        'default'           => '#56982a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( 
        $wp_customize, 
        'secondary_color_control',
        array(
            'label'    => __( 'Couleur Secondaire', 'mon-theme' ),
            'section'  => 'colors',
            'settings' => 'secondary_color',
        ) 
    ) );
}
add_action( 'customize_register', 'mon_theme_customizer' );

/* ====================================== MENU WP "SPORTS" ====================================== */
function create_post_type_sports() {
    register_post_type('sport',
        array(
            'labels' => array(
                'name' => __('Sports'),
                'singular_name' => __('Sport'),
                'add_new_item' => __('Ajouter un nouveau sport'),
                'edit_item' => __('Modifier le sport'),
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-groups',
            'supports' => array('title'),
        )
    );
}
add_action('init', 'create_post_type_sports');


/* ====================================== COORDONNÉES (MENU WP CONTACT) ====================================== */
//"Coordonnées ASLA" DANS "Contact"
function create_cpt_coordonnees_final() {
    register_post_type('coordonnees',
        array(
            'labels' => array(
                'name' => 'Coordonnées',
                'singular_name' => 'Fiche Coordonnées',
                'all_items' => 'Coordonnées ASLA',
                'edit_item' => 'Modifier les coordonnées',
            ),
            'public' => false,      
            'show_ui' => true,      
            'show_in_menu' => 'wpcf7',
            'supports' => array('title'),
            'map_meta_cap' => true,
        )
    );
}
add_action('init', 'create_cpt_coordonnees_final');


//REDIRECTION DIRECT VERS CHAMP CARBON FIELDS
function force_redirect_single_coordonnees() {
    global $pagenow;
    if ( $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'coordonnees' ) {
        $existing_posts = get_posts(array(
            'post_type' => 'coordonnees',
            'posts_per_page' => 1,
            'post_status' => 'any'
        ));
        if ( !empty($existing_posts) ) {
            $id_fiche = $existing_posts[0]->ID;
            $url_edition = admin_url('post.php?post=' . $id_fiche . '&action=edit');
            
            wp_redirect($url_edition);
            exit;
        } else {
            wp_redirect(admin_url('post-new.php?post_type=coordonnees'));
            exit;
        }
    }
}
add_action('admin_init', 'force_redirect_single_coordonnees');


//SUPPRIMER BOUTON "AJOUTER"
function remove_add_new_coordonnees() {
    remove_submenu_page('wpcf7', 'post-new.php?post_type=coordonnees');
    global $typenow;
    if ($typenow == 'coordonnees') {
        echo '<style>.page-title-action { display: none !important; }</style>';
    }
}
add_action('admin_menu', 'remove_add_new_coordonnees', 999);
add_action('admin_head', 'remove_add_new_coordonnees');

// ====================================== CHARGE SCRIPT.JS ======================================
function charger_scripts_du_theme() {
    wp_enqueue_style( 'style-principal', get_stylesheet_uri() );
    wp_enqueue_script( 
        'mon-script-perso',
        get_template_directory_uri() . '/script.js',
        array(),
        '1.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'charger_scripts_du_theme' );

/* ====================================== SUPPRESSION MENU COMMENTAIRE WP ====================================== */
function remove_admin_menus() {
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_admin_menus' );

/* ====================================== SUPPRESSION SOUS-MENU ====================================== */
function nettoyer_menu_apparence_brutal() {
    global $submenu;
    //APPARAENCE
    if ( isset( $submenu['themes.php'] ) ) {
        foreach ( $submenu['themes.php'] as $index => $item ) {
            //SUPPRIME COMPOSITION
            if ( strpos( $item[0], 'Compositions' ) !== false || strpos( $item[0], 'Patterns' ) !== false ) {
                unset( $submenu['themes.php'][$index] );
            }
            //SUPPRIME ÉDITEUR DE FICHIERS
            if ( strpos( $item[0], 'Éditeur de fichiers' ) !== false || strpos( $item[0], 'Theme File Editor' ) !== false ) {
                unset( $submenu['themes.php'][$index] );
            }
        }
    }
    remove_submenu_page( 'wpcf7', 'wpcf7-new' );
}
add_action( 'admin_menu', 'nettoyer_menu_apparence_brutal', 999 );

/* ====================================== SÉPARATEUR APPARENCE/EXTENSIONS ====================================== */
function ajouter_separateur_admin() {
    global $menu;
    $menu[62] = array(
        '',
        'read',
        'separator-perso',
        '',
        'wp-menu-separator'
    );
}
add_action( 'admin_menu', 'ajouter_separateur_admin' );

/* ====================================== SPORTS AUTOMATIQUE MENU ENTÊTE ====================================== */
function injecter_sports_menu_plat( $items, $args ) {
    if ( ! in_array( $args->theme_location, array( 'menu-principal', 'footer-plan' ) ) ) {
        return $items;
    }

    $new_items = array();
    global $post;
    $current_page_id = ( $post ) ? $post->ID : 0;

    // On récupère TOUS les sports (pas de limite)
    $sports = get_posts( array( 
        'post_type'   => 'sport', 
        'numberposts' => -1, 
        'orderby'     => 'title', 
        'order'       => 'ASC' 
    ) );

    foreach ( $items as $item ) {
        if ( $item->url == '#auto-sports' ) {
            foreach ( $sports as $sport ) {
                $sport_item = clone $item;
                $sport_item->ID = $sport->ID + 100000;
                $sport_item->db_id = $sport_item->ID;
                $sport_item->title = $sport->post_title;
                $sport_item->url = get_permalink($sport->ID); 
                $sport_item->classes = array( 'menu-item', 'menu-item-type-custom', 'sport-dynamique' );

                if ( is_singular('sport') && $sport->ID == $current_page_id ) {
                    $sport_item->classes[] = 'current-menu-item';
                }
                $new_items[] = $sport_item;
            }
        } else {
            $new_items[] = $item;
        }
    }
    return $new_items;
}
add_filter( 'wp_nav_menu_objects', 'injecter_sports_menu_plat', 10, 2 );

/* ====================================== SECTION DOCUMENTS - CUSTOMIZER ====================================== */
//SEPARATEUR
if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Mon_Theme_Separator_Control' ) ) {
    class Mon_Theme_Separator_Control extends WP_Customize_Control {
        public function render_content() {
            echo '<hr style="border: 0; border-top: 1px solid #ccc; margin: 30px 0 15px;">';
            if( !empty($this->label) ) {
                echo '<h3 style="margin: 0 0 10px; font-size: 14px; color: #23282d; font-weight: 600;">' . esc_html($this->label) . '</h3>';
            }
        }
    }
}
function mon_theme_customizer_docs($wp_customize) {
    $wp_customize->add_section('docs_asso_section', array(
        'title'       => 'Documents ASLA',
        'description' => 'Gérez ici les fichiers et les textes associés.',
        'priority'    => 30,
    ));
    //INSCRIPTION PDF
    $wp_customize->add_setting('global_fiche_inscription', array('default' => '', 'transport' => 'refresh'));
    $wp_customize->add_control( new WP_Customize_Upload_Control( 
        $wp_customize, 'global_fiche_inscription', 
        array(
            'label'      => 'Fiche d\'inscription (PDF)',
            'section'    => 'docs_asso_section',
        ) 
    ));
        //TEXTE
    $wp_customize->add_setting('global_fiche_inscription_text', array(
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('global_fiche_inscription_text', array(
        'label'       => 'Phrase d\'accompagnement',
        'section'     => 'docs_asso_section',
        'type'        => 'textarea',
    ));
    
//AUTO SORTIE (PDF)
    $wp_customize->add_setting('separateur_docs_2', array('sanitize_callback' => '__return_false'));
    $wp_customize->add_control( new Mon_Theme_Separator_Control( 
        $wp_customize, 
        'separateur_docs_2', 
        array(
            'section' => 'docs_asso_section',
        ) 
    ));
    $wp_customize->add_setting('global_auth_sortie', array('default' => '', 'transport' => 'refresh'));
    $wp_customize->add_control( new WP_Customize_Upload_Control( 
        $wp_customize, 'global_auth_sortie', 
        array(
            'label'      => 'Autorisation Sortie (PDF)',
            'section'    => 'docs_asso_section',
        ) 
    ));
        //TEXTE
    $wp_customize->add_setting('global_auth_sortie_text', array(
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('global_auth_sortie_text', array(
        'label'       => 'Phrase d\'accompagnement',
        'section'     => 'docs_asso_section',
        'type'        => 'textarea',
    ));

    //PLAQUETTE ACTIVITÉS (PDF)
    $wp_customize->add_setting('separateur_docs_3', array('sanitize_callback' => '__return_false'));
    $wp_customize->add_control( new Mon_Theme_Separator_Control( 
        $wp_customize, 
        'separateur_docs_3', 
        array(
            'section' => 'docs_asso_section',
        ) 
    ));
    $wp_customize->add_setting('global_activites', array('default' => '', 'transport' => 'refresh'));
    $wp_customize->add_control( new WP_Customize_Upload_Control( 
        $wp_customize, 'global_activites', 
        array(
            'label'      => 'Planning des Activités (PDF)',
            'section'    => 'docs_asso_section',
        ) 
    ));
}
add_action('customize_register', 'mon_theme_customizer_docs');

function nettoyer_mon_customizer( $wp_customize ) {
    //"Réglages de la page d'accueil"
    $wp_customize->remove_section( 'static_front_page' );
    //Supprimer "Menus"
    $wp_customize->remove_panel( 'nav_menus' );
}
add_action( 'customize_register', 'nettoyer_mon_customizer', 50 );

?>