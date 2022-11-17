<?php declare(strict_types=1);

namespace Am\APIPlugin;

use Am\APIPlugin\Admin\AdminAJAXEndpoints;
use Am\APIPlugin\Admin\AdminPage;

defined( 'ABSPATH' ) || exit;

final class APIPlugin 
{
    use Singleton;

    /**
     * @var string Plugin's slug.
     */
    public $pluginSlug;

    /**
     * @var string Plugin's version.
     */
    public $pluginVersion;

    /**
     * @var string Plguin's root path
     */
    public $rootPath;

    /**
     * @var string Plugin's root URL
     */
    public $rootURL;

    public function pluginInit(): void
    {
        $this->pluginSetup();
    
        if ( ! is_admin() ) {
            return;
        }
    
        $this->admin(); 
    }
    
    protected function init(): void
    {        
        add_action( 'init', [ $this, 'pluginInit' ] );
    }

    /**
     * Register, init or set site-wide components.
     * 
     * @return void
     */
    protected function pluginSetup(): void
    {
        $this->pluginVersion = defined('AM_APIPLUGIN_VERSION') ? AM_APIPLUGIN_VERSION : '1.0.0';
        $this->pluginSlug    = defined('AM_APIPLUGIN_SLUG') ? AM_APIPLUGIN_SLUG : 'am-apiplugin';
        $this->rootPath      = dirname( __DIR__ );
        $this->rootURL       = plugin_dir_url( $this->rootPath . "/{$this->pluginSlug}.php" );

        $pluginLangPath = $this->rootPath . '/languages/';
        load_plugin_textdomain( $this->pluginSlug, false, $pluginLangPath );
    }

    /**
     * Register, init, or set admin components.
     * 
     * @return void
     */
    protected function admin(): void
    {
        AdminAJAXEndpoints::run();
        AdminPage::run();
    }
}