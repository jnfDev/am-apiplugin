<?php declare(strict_types=1);

namespace Am\APIPlugin\Admin;

use Dotenv;
use Am\APIPlugin\Singleton;
use Am\APIPlugin\APIPlugin;

defined( 'ABSPATH' ) || exit;

final class AdminPage
{
    use Singleton;

    protected APIPlugin $plugin;

    protected string $scriptHandle = 'am-admin-page-script';
    
    protected function init()
    {
        $this->plugin = APIPlugin::getInstance();
    
        add_filter( 'script_loader_tag', [ $this, 'addModuleToScript' ], 10, 3 );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAssets' ] );
        add_action( 'admin_menu', [ $this, 'registerMenuPage' ] );
    }

    public function addModuleToScript($tag, $handle, $src)
    {
        if ( $handle === $this->scriptHandle ) {
            $tag = '<script type="module" id="WPWVT-script-boot" src="' . esc_url( $src ) . '"></script>';
        }

        return $tag;
    }

    public function enqueueAssets(): void
    {
        $screen = get_current_screen();
        if ( 'toplevel_page_am-admin-page' !==  $screen->id ) {
            return;
        }

        $dotenv = Dotenv\Dotenv::createImmutable( $this->plugin->rootPath );
        $dotenv->load();

        if ( isset( $_ENV['AM_MODE'] ) && 'DEV' === strtoupper( $_ENV['AM_MODE'] ) ) {  
            wp_register_script( $this->scriptHandle, esc_url( $_ENV['AM_DEV_SERVER'] ) . 'src/main.js', [ 'jquery', 'wp-i18n' ], $this->plugin->pluginVersion, false );
        } else {
            wp_register_script( $this->scriptHandle, $this->plugin->rootURL . 'dist/main.js', [ 'jquery', 'wp-i18n' ], $this->plugin->pluginVersion, false );
            wp_enqueue_style( 'am-admin-page-css', $this->plugin->rootURL . 'dist/main.css' , [], $this->plugin->pluginVersion );
        } 

        wp_localize_script( $this->scriptHandle, 'AmAdminVars', [
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'nonce'     => wp_create_nonce( AdminAJAXEndpoints::NONCE_ACTION ),
            'assetsUrl' => $this->plugin->rootURL . 'admin/assets',
            'actions' => [
                'getAPIData'   => AdminAJAXEndpoints::AJAX_GET_API_DATA_ACTION,
                'updateSetting' => AdminAJAXEndpoints::AJAX_UPDATE_SETTING_ACTION,
                'getSettings'   => AdminAJAXEndpoints::AJAX_GET_SETTINGS_ACTION,
            ],
            'i18n' => [
                'Am Test Plugin' => esc_html__( 'Am Test Plugin', 'am-apiplugin' ),
                'Table'  => esc_html__( 'Table', 'am-apiplugin' ),
                'Graph'  => esc_html__( 'Graph', 'am-apiplugin' ),
                'Settings'  => esc_html__( 'Settings', 'am-apiplugin' ),
                'Am Graph'  => esc_html__( 'Am Graph', 'am-apiplugin' ),
                'Loading...'  => esc_html__( 'Loading...', 'am-apiplugin' ),
                'Refresh'  => esc_html__( 'Refresh', 'am-apiplugin' ),
                'Table Settings'  => esc_html__( 'Table Settings', 'am-apiplugin' ),
                'Rows Number'  => esc_html__( 'Rows Number', 'am-apiplugin' ),
                'Humandate'  => esc_html__( 'Humandate', 'am-apiplugin' ),
                'Emails'  => esc_html__( 'Emails', 'am-apiplugin' ),
            ]
        ]);
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

        wp_enqueue_script( $this->scriptHandle );

        require_once __DIR__ . '/views/admin-page.php';
    }
}