<?php declare(strict_types=1);

namespace Am\APIPlugin;

use Am\APIPlugin\Admin\AdminAJAXEndpoints;
use Am\APIPlugin\Admin\AdminPage;

defined( 'ABSPATH' ) || exit;

final class APIPlugin 
{
    use Singleton;

    public string $pluginSlug;

    public string $pluginVersion;

    public string $rootPath;

    public string $rootURL;

    protected function init(): void
    {        
        add_action( 'init', [ $this, 'pluginInit' ] );
    }

    public function pluginInit(): void
    {
        $this->pluginSetup();
    
        if ( ! is_admin() ) {
            return;
        }
    
        $this->admin(); 
    }

    protected function pluginSetup(): void
    {
        $this->pluginVersion = defined('AM_APIPLUGIN_VERSION') ? AM_APIPLUGIN_VERSION : '1.0.0';
        $this->pluginSlug    = defined('AM_APIPLUGIN_SLUG') ? AM_APIPLUGIN_SLUG : 'am-apiplugin';
        $this->rootPath      = dirname( __DIR__ );
        $this->rootURL       = plugin_dir_url( $this->rootPath . "/{$this->pluginSlug}.php" );

        $pluginLangPath = "{$this->pluginSlug}/languages/";
        load_plugin_textdomain( $this->pluginSlug, false, $pluginLangPath );
    }

    protected function admin(): void
    {
        AdminAJAXEndpoints::run();
        AdminPage::run();
    }
}