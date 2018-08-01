<?php

//This is a re-work of the privacy.php script

if ( ! current_user_can( 'manage_privacy_options' ) ) {
    wp_die( __( 'Sorry, you are not allowed to manage values on this site.' ) );
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['allow-comments-privacy'])){
        update_option('deactivateGdprCommentFieldFeature', FALSE);
    }else{
        update_option('deactivateGdprCommentFieldFeature', TRUE);
    }
}
//$ValuesPhpFormReceiver = new \GdprRollbackFeatures\ValuesPhpFormReceiver;
//->bool_isFormBeingSubmitted();
    
if(isset($_POST['gdpr-comment-opt-in'])){
    if ($_POST['gdpr-comment-opt-in'] == 1){
        update_option('gdpr-comment-opt-in', TRUE);
     }else{
        update_option('gdpr-comment-opt-in', FALSE);
    }
}

$action = isset( $_POST['action'] ) ? $_POST['action'] : '';

if ( ! empty( $action ) ) {
    check_admin_referer( $action );
    
    if ( 'set-privacy-page' === $action ) {
        $privacy_policy_page_id = isset( $_POST['page_for_privacy_policy'] ) ? (int) $_POST['page_for_privacy_policy'] : 0;
        update_option( 'wp_page_for_privacy_policy', $privacy_policy_page_id );
        
        add_settings_error(
            'page_for_privacy_policy',
            'page_for_privacy_policy',
            sprintf(
                /* translators: %s: URL to Customizer -> Menus */
                __( 'Privacy policy page updated successfully. Remember to <a href="%s">update your menus</a>!' ),
                'customize.php?autofocus[panel]=nav_menus'
                ),
            'updated'
            );
    } elseif ( 'create-privacy-page' === $action ) {
        
        if ( ! class_exists( 'WP_Privacy_Policy_Content' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/misc.php' );
        }
        
        $privacy_policy_page_content = WP_Privacy_Policy_Content::get_default_content();
        $privacy_policy_page_id = wp_insert_post(
            array(
                'post_title'   => __( 'Privacy Policy' ),
                'post_status'  => 'draft',
                'post_type'    => 'page',
                'post_content' => $privacy_policy_page_content,
            ),
            true
            );
        
        if ( is_wp_error( $privacy_policy_page_id ) ) {
            add_settings_error(
                'page_for_privacy_policy',
                'page_for_privacy_policy',
                __( 'Unable to create privacy policy page.' ),
                'error'
                );
        } else {
            update_option( 'wp_page_for_privacy_policy', $privacy_policy_page_id );
            
            wp_redirect( admin_url( 'post.php?post=' . $privacy_policy_page_id . '&action=edit' ) );
            exit;
        }
    }
}

// If a privacy policy page ID is available, make sure the page actually exists. If not, display an error.
$privacy_policy_page_exists = false;
$privacy_policy_page_id     = (int) get_option( 'wp_page_for_privacy_policy' );

if ( ! empty( $privacy_policy_page_id ) ) {
    
    $privacy_policy_page = get_post( $privacy_policy_page_id );
    
    if ( ! $privacy_policy_page instanceof WP_Post ) {
        add_settings_error(
            'page_for_privacy_policy',
            'page_for_privacy_policy',
            __( 'The currently selected privacy policy page does not exist. Please create or select new page.' ),
            'error'
            );
    } else {
        if ( 'trash' === $privacy_policy_page->post_status ) {
            add_settings_error(
                'page_for_privacy_policy',
                'page_for_privacy_policy',
                sprintf(
                    /* translators: URL to Pages Trash */
                    __( 'The currently selected privacy policy page is in the trash. Please create or select new privacy policy page or <a href="%s">restore the current page</a>.' ),
                    'edit.php?post_status=trash&post_type=page'
                    ),
                'error'
                );
        } else {
            $privacy_policy_page_exists = true;
        }
    }
}

$title       = __( 'Privacy Settings' );
$parent_file = 'options-general.php';

require_once( ABSPATH . 'wp-admin/admin-header.php' );

?>
<div class="wrap">
<form method = "post" action = "/wp-admin/options-general.php?page=values.php">
	<h1><?php echo $title; ?></h1>
	<table class="form-table tools-privacy-policy-page">
		<tr><th scope="row"><label for="Comments Form"><?php _e('Comments Form') ?></label></th>
			<td>
				<input name="allow-comments-privacy" type="checkbox" id="allow-comments-privacy" value="<yes" class="regular-text"<?php if( get_option('deactivateGdprCommentFieldFeature') == FALSE){echo ("checked");}?> /> 
					Display user cookie consent checkbox in comments
				<ul>
					<li>
						&nbsp;&nbsp;
						<input id = "gdpr-comment-opt-in-true" name="gdpr-comment-opt-in" type="radio" value="1" <?php if (get_option( 'gdpr-comment-opt-in' )){echo ("CHECKED");}?> />
							<label for = "gdpr-comment-opt-in-true">Opt-In</label><br />
					</li>
					<li>
						&nbsp;&nbsp;
						<input id = "gdpr-comment-opt-in-false" name="gdpr-comment-opt-in" type="radio" value="0" <?php if (get_option( 'gdpr-comment-opt-in' )){}else{echo ("CHECKED");}?> />
							<label for = "gdpr-comment-opt-in-false">Opt-Out</label>
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th scope="row">
				<?php
				if ( $privacy_policy_page_exists ) {
					_e( 'Change your Privacy Policy page' );
				} else {
					_e( 'Select a Privacy Policy page' );
				}
				?>
			</th>
			<td>
				<?php
				$has_pages = (bool) get_posts( array(
					'post_type' => 'page',
					'posts_per_page' => 1,
					'post_status' => array(
						'publish',
						'draft',
					),
				) );

				if ( $has_pages ){
				    echo('<label for="page_for_privacy_policy">');
					_e( 'Select an existing page:' );
					echo ('</label>	<input type="hidden" name="action" value="set-privacy-page" />');
					wp_dropdown_pages(
						array(
							'name'              => 'page_for_privacy_policy',
							'show_option_none'  => __( '&mdash; Select &mdash;' ),
							'option_none_value' => '0',
							'selected'          => $privacy_policy_page_id,
							'post_status'       => array( 'draft', 'publish' ),
						)
					);
					wp_nonce_field( 'set-privacy-page' );
				}else{
				    _e('You have not created any pages.');
				}			
				?>
			</td></tr>
			<tr><td><?php submit_button(); ?></td></tr>
	</table>
</form>

<strong>May 26, 2018</strong> - This plugin, Better Privacy, was quick released due to GDPR. If you'd like another feature added to this plugin, please give some feedback.
This message will be removed on the next plugin update. -- <a href = "https://wp-bdd.com/better-privacy/" target = "_blank">John Dee</a>, plugin developer
</div>