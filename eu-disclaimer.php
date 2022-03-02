<?php

/**
 * Plugin Name: eu-disclaimer 
 * Plugin URI: http://URL_de_l_extension 
 * Description: Plugin sur la législation des produits à base de nicotine. 
 * Version: 1.0.0 
 * Author: Arnaud Boisjardin
 * Author URI: http://www.afpa.fr 
 * License: (Lien de la licence)
 */

// Création de la fonction ajouter au menu 
function ajouterAuMenu()
{
    $page = 'eu-disclaimer';
    $menu = 'eu-disclaimer';
    $capability = 'edit_pages';
    $slug = 'eu-disclaimer';
    $function = 'disclaimerFonction';
    $icon = '';
    $position = 80;
    if (is_admin()) {
        add_menu_page($page, $menu, $capability, $slug, $function, $icon, $position);
    }
};
// hook pour réaliser l'action 'admin_menu' <- emplacement / ajouterAuMenu <- fonction à appeler / <- priorité. 
add_action("admin_menu", "ajouterAuMenu", 10);

register_activation_hook(__FILE__, 'ajouter_message');
register_deactivation_hook(__FILE__, 'desactiver_message');
register_uninstall_hook(__FILE__, 'supprimer_message');

function ajouter_message()
{
    add_option('message_disclaimer', 'Avez-vous plus de 18 ans ?');
}
function desactiver_message()
{
}
function supprimer_message()
{
    delete_option('message_disclaimer');
}
// fonction à appeler lorsque l'on clic sur le menu.
function disclaimerFonction()
{
    require_once('view/message-view.php');
}

// Ajout du JS à l'activation du plugin 
add_action('init', 'inserer_js_dans_footer');
function inserer_js_dans_footer()
{
    if (!is_admin()) : wp_register_script('jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js', null, null, true);
        wp_enqueue_script('jQuery');
        wp_register_script('jQuery_modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', null, null, true);
        wp_enqueue_script('jQuery_modal');
        wp_register_script('jQuery_eu', plugins_url('assets/js/eu-disclaimer.js', __FILE__), array('jquery'), '1.1', true);
        wp_enqueue_script('jQuery_eu');
    endif;
}
// Ajout du CSS à l'activation du plugin 
add_action('wp_head', 'ajouter_css', 1);
function ajouter_css()
{
    if (!is_admin()) : wp_register_style('eu-disclaimer-css', plugins_url('assets/css/eu-disclaimer-css.css', __FILE__), null, null, false);
        wp_enqueue_style('eu-disclaimer-css');
        wp_register_style('modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', null, null, false);
        wp_enqueue_style('modal');
    endif;
}
/** 
 * Active le modal sans utilisation du shortcode. 
 * Utilisation : add_action('nom du hook', 'nom de la fonction');  
 */
add_action('wp_body_open', 'afficherModalDansBody');
function afficherModalDansBody()
{
    $message_disclaimer = get_option('message_disclaimer');
    echo
    '<div id="monModal" class="modal"> 
        <center>
            <strong>
                 <h1>Le Vapobar</h1>
                 <p>Vous souhaite la bienvenue !</p>
                 <img src="/wp-content/plugins/eu-disclaimer/assets/img/adult_only.jpg" alt="-18"; width=30%>
                 <p>Au regard de la loi européenne, vous devez nous confirmer que vous avez plus de 18 ans</p>
                 <p>' . $message_disclaimer . '</p>
                 <a href="" type="button" rel="modal:close" class="btn-green" id="actionDisclaimer" >Oui</a> 
                 <a href="https://www.google.com" type="button" class="btn-red">Non</a>
            </strong>
        </center>
    </div>';
}
