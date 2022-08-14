<?php declare(strict_types=1);

namespace Am\APIPlugin;

use WP_CLI;
use Am\APIPlugin\CLI\RequestThrottleCLI;
use Am\APIPlugin\APIBlock;
use Am\APIPlugin\Admin\AdminAJAXEndpoints;
use Am\APIPlugin\Admin\AdminPage;

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
        $this->pluginVersion = defined('JNFDEV_APIPLUGIN_VERSION') ? JNFDEV_APIPLUGIN_VERSION : '1.0.0';
        $this->rootPath      = defined('JNFDEV_APIPLUGIN_ROOT_PATH') ? JNFDEV_APIPLUGIN_ROOT_PATH : dirname( dirname( __DIR__ ) );
        $this->rootURL       = defined('JNFDEV_APIPLUGIN_ROOT_URL') ? JNFDEV_APIPLUGIN_ROOT_URL : plugin_dir_url( dirname( dirname( __DIR__ ) ) );
        $this->textdomain    = defined('JNFDEV_APIPLUGIN_TEXTDOMAIN') ? JNFDEV_APIPLUGIN_TEXTDOMAIN : 'jnfdev-apiplugin';

        $pluginLangPath = $this->rootPath . '/languages/';
        load_plugin_textdomain( $this->textdomain, false, $pluginLangPath );

        APIBlock::run();

        class_exists( WP_CLI::class ) && WP_CLI::add_command( 'request-throttle', RequestThrottleCLI::class );
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