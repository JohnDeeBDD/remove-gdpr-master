<?php
/*
 Plugin Name: Better Privacy
 Plugin URI: https://wp-bdd.com/better-privacy/
 Description: Activate or deactivate GDPR / privacy related features.
 Version: 0.1
 Author: John Dee
 Author URI: https://wp-bdd.com
 */

namespace GdprRollbackFeatures;
/*
 * DEVELOPER NOTES: GDPR was recently released, and I am working to fix the issue for American companies who do not need GDPR. If you want a new 
 * feature, please just ask the plugin author!
 */

//This allows unlimited comments for development purposes:
add_filter('comment_flood_filter', '__return_false');


require_once (plugin_dir_path(__FILE__). 'src/GdprRollbackFeatures/autoloader.php');

if(\get_option('deactivateGdprCommentFieldFeature') == TRUE){
    add_filter('comment_form_default_fields', array(new GdprCommentFormFeatureRemover, 'removeCookiesAuthorizationFromDefaultCommentFields'));
}else{
    add_filter('comment_form_default_fields', array(new GdprCommentFormFeatureRemover, 'addOptInToggle'));
}

//if(isset($_POST['wp-comment-cookies-consent'])){
  //  remove_action( 'set_comment_cookies', 'wp_set_comment_cookies' );
//}


add_action( 'admin_menu', 'GdprRollbackFeatures\removeDefaultPrivacySubmenu', 999 );
function removeDefaultPrivacySubmenu() {
    $page = remove_submenu_page( 'options-general.php', 'privacy.php' );
    add_submenu_page( 'options-general.php', 'Privacy', 'Privacy', 'manage_privacy_options', 'values.php', 'GdprRollbackFeatures\requireValuesPage');
}
function requireValuesPage(){
    require_once (plugin_dir_path(__FILE__). 'src/GdprRollbackFeatures/values.php');
}

//ACTIVATION AND DEACTIVATION:
function activatePlugin() {
    update_option('deactivateGdprCommentFieldFeature', FALSE);
    update_option('gdpr-comment-opt-in', TRUE);
}
register_activation_hook( __FILE__, 'GdprRollbackFeatures\activatePlugin' );

function deactivatePlugin() {
    delete_option('deactivateGdprCommentFieldFeature');
    delete_option('gdpr-comment-opt-in');
}
register_deactivation_hook( __FILE__, 'GdprRollbackFeatures\deactivatePlugin' );
if (isset($_POST['wp-comment-cookies-consent'])){
    
    add_action('init', array(new GdprCommentFormFeatureRemover, 'checkBoxWithJS'));
}
