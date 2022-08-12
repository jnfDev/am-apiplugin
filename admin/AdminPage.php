<?php declare(strict_types=1);

namespace Am\APIPlugin\Admin;

use Am\APIPlugin\Singleton;
use Am\APIPlugin\APIPlugin;

defined( 'ABSPATH' ) || exit;

final class AdminPage
{
    use Singleton;

    /**
     * @var APIPlugin
     */
    protected $plugin;
    
    protected function init()
    {
        $this->plugin = APIPlugin::getInstance();
    
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAssets' ] );
        add_action( 'admin_menu', [ $this, 'registerMenuPage' ] );
    }
    
    public function registerMenuPage()
    {
        add_menu_page( 
            __( 'Am API-Based Plugin', $this->plugin->textdomain ), 
            __( 'Am API-Based Plugin', $this->plugin->textdomain ), 
            'manage_options', 
            'am-admin-page', 
            [ $this, 'renderMenuPage' ], 
            'dashicons-rest-api' 
        );
    }

    public function renderMenuPage(): void
    {   
        /**
         * Views variables 
         */
        $assetUrl = $this->plugin->rootURL . '/admin/assets';

        require_once __DIR__ . '/views/admin-page.php';
    }

    public function enqueueAssets(): void
    {
        $screen = get_current_screen();
        if ( 'toplevel_page_am-admin-page' !==  $screen->id ) {
            return;
        }

        wp_enqueue_script( 'admin-page-script', $this->plugin->rootURL . '/admin/assets/js/admin-page.js', [ 'jquery' ], $this->plugin->pluginVersion );
        wp_enqueue_style( 'admin-page-styles', $this->plugin->rootURL . '/admin/assets/css/admin-page.css', [], $this->plugin->pluginVersion );

        wp_localize_script( 'admin-page-script', 'adminVars', array(
            'url'    => admin_url( 'admin-ajax.php' ),
            'nonce'  => wp_create_nonce( "_wpnonce_{$this->plugin->textdomain}" ),
            'action' => 'am_get_challenge_data'
        ) );
    }
}