<?php declare(strict_types=1);

namespace Am\APIPlugin;

use Am\APIPlugin\Admin\AdminAJAXEndpoints;

defined( 'ABSPATH' ) || exit;

final class APIBlock
{
    use Singleton;

    public function init()
    {
        /**
         * @var APIPlugin
         */
        $plugin     = APIPlugin::getInstance();
        $textdomain = $plugin->textdomain;
        $assetFile  = require_once( $plugin->rootPath . '/build/index.asset.php' );

        wp_register_script(
            'am-apiblock-script',
            $plugin->rootURL . '/build/index.js',
            $assetFile['dependencies'],
            $assetFile['version']
        );

        wp_register_style(
            'am-apiblock-style',
            $plugin->rootURL . '/build/index.css'
        );

        register_block_type( 'am-apiplugin/am-apiblock', [
            'api_version'     => 2,
            'title'           => 'Am API-Block',
            'category'        => 'text',
            'icon'            => 'rest-api',
            'script'          => 'am-apiblock-script',
            'style'           => 'am-apiblock-style',
            'attributes'      => [
                'adminVars' => [
                    'type' => 'object',
                    'default' => [
                        'url'    => admin_url( 'admin-ajax.php' ),
                        'nonce'  => wp_create_nonce( AdminAJAXEndpoints::NONCE_ACTION ),
                        'action' => 'am_get_challenge_data'
                    ]
                ],
                'data' => [
                    'type' => 'object',
                ],
                'hiddenColumns' => [
                    'type'    => 'array',
                ],
            ]
        ] );
    }
}