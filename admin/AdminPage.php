<?php declare(strict_types=1);

namespace Am\APIPlugin\Admin;

use Am\APIPlugin\Singleton;
use Am\APIPlugin\APIPlugin;

defined( 'ABSPATH' ) || exit;

final class AdminPage
{
    use Singleton;

    protected APIPlugin $plugin;
    
    protected function init()
    {
        $this->plugin = APIPlugin::getInstance();
    
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAssets' ] );
        add_action( 'admin_menu', [ $this, 'registerMenuPage' ] );
    }
    
    public function registerMenuPage(): void
    {
        add_menu_page( 
            __( 'Am API-Based Plugin', 'am-apiplugin' ), 
            __( 'Am API-Based Plugin', 'am-apiplugin' ), 
            'manage_options', 
            'am-admin-page', 
            [ $this, 'renderMenuPage' ], 
            'dashicons-rest-api' 
        );
    }

    public function renderMenuPage(): void
    {   
        /**
         * View's variables 
         */
        $challengeIds = [1];
        $assetUrl     = $this->plugin->rootURL . '/admin/assets';

        require_once __DIR__ . '/views/admin-page.php';
    }

    public function enqueueAssets(): void
    {
        $screen = get_current_screen();
        if ( 'toplevel_page_am-admin-page' !==  $screen->id ) {
            return;
        }

        $scriptHandle = 'admin-page-script';
        $scriptHandle = 'am-admin-page-script';
        
        wp_enqueue_script( $scriptHandle, $this->plugin->rootURL . '/admin/assets/js/admin-page.js', [ 'jquery', 'wp-i18n' ], $this->plugin->pluginVersion );

        wp_set_script_translations( $scriptHandle,  'am-apiplugin' );
        
        wp_localize_script( 
            $scriptHandle,
            'AmAdminVars', 
            [
                'url'                   => admin_url( 'admin-ajax.php' ),
                'nonce'                 => wp_create_nonce( AdminAJAXEndpoints::NONCE_ACTION ),
                'actions'               => [
                    'get_api_data'   => AdminAJAXEndpoints::AJAX_GET_API_DATA_ACTION,
                    'update_setting' => AdminAJAXEndpoints::AJAX_UPDATE_SETTING_ACTION,
                    'get_settings'   => AdminAJAXEndpoints::AJAX_GET_SETTINGS_ACTION,
                ],
            ]
        );
    }
}