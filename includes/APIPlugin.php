<?php declare(strict_types=1);

namespace Am\APIPlugin;

use WP_CLI;
use Am\APIPlugin\CLI\RequestThrottleCLI;
use Am\APIPlugin\APIBlock;
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

    /**
     * @var string Plguin's root path
     */
    public $rootPath;

    /**
     * @var string Plugin's root URL
     */
    public $rootURL;

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
        $this->rootPath      = defined('JNFDEV_APIPLUGIN_ROOT_PATH') ? JNFDEV_APIPLUGIN_ROOT_PATH : dirname( dirname( __DIR__ ) );
        $this->rootURL       = defined('JNFDEV_APIPLUGIN_ROOT_URL') ? JNFDEV_APIPLUGIN_ROOT_URL : plugin_dir_url( dirname( dirname( __DIR__ ) ) );
        $this->textdomain    = defined('JNFDEV_APIPLUGIN_TEXTDOMAIN') ? JNFDEV_APIPLUGIN_TEXTDOMAIN : 'jnfdev-apiplugin';
        
        add_action( 'init', [ $this, 'pluginInit' ] );
    }

    protected function pluginSetup()
    {
        // Load plugin textdomain.
        $pluginLangPath = $this->rootPath . '/languages/';
        load_plugin_textdomain( $this->textdomain, false, $pluginLangPath );

        // Load custom block
        APIBlock::run();

        // Register custom CLI commands
        class_exists( WP_CLI::class ) && WP_CLI::add_command( 'request-throttle', RequestThrottleCLI::class );
    }

    protected function admin()
    {
        AdminAJAXEndpoints::run();
    }
}