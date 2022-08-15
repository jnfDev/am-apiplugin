<?php declare(strict_types=1);

namespace Am\APIPlugin;

use Am\APIPlugin\Admin\AdminAJAXEndpoints;

defined( 'ABSPATH' ) || exit;

final class APIBlock
{
    use Singleton;

    public function init(): void
    {
        /**
         * @var APIPlugin
         */
        $plugin       = APIPlugin::getInstance();
        $assetFile    = require_once( $plugin->rootPath . '/build/index.asset.php' );
        $scriptHandle = 'am-apiblock-script';

        wp_register_script(
            $scriptHandle,
            $plugin->rootURL . '/build/index.js',
            array_merge( $assetFile['dependencies'], ['wp-i18n'] ),
            $assetFile['version']
        );

        wp_set_script_translations( $scriptHandle,  'am-apiplugin' );

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