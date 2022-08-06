<?php declare(strict_types=1);

namespace Am\APIPlugin;

use Am\APIPlugin\Admin\AdminAJAXEndpoints;

defined( 'ABSPATH' ) || exit;

final class APIPlugin 
{
    use Singleton;

    /**
     * @var string Plugin's textdomain.
     */
    public $textdomain;

    /**
     * @var string Plugin's version.
     */
    public $pluginVersion;

    public function pluginInit() {
        $this->pluginSetup();
    
        if ( ! is_admin() ) {
            return;
        }
    
        $this->admin(); 
    }
    
    protected function init()
    {
        // Define settings
        $this->pluginVersion = defined('JNFDEV_APIPLUGIN_VERSION') ? JNFDEV_APIPLUGIN_VERSION : '1.0.0';
        $this->textdomain    = defined('JNFDEV_APIPLUGIN_VERSION') ? JNFDEV_APIPLUGIN_VERSION : 'jnfdev-apiplugin';
        
        add_action( 'init', [ $this, 'pluginInit' ] );
    }

    protected function pluginSetup()
    {
        /**
         * Define global stuff, such as registering custom post-types, 
         * loading the plugin's textdomain, or even registering global hooks.
         */
    }

    protected function admin()
    {
        AdminAJAXEndpoints::run();
    }
}