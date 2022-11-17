<?php
/**
 * Plugin Name: Am API Based Plugin
 * Description: This plugin is an application test (code challenge) for Awesome Motive.
 * Author: jnfdev
 * Domain: am-apiplugin
 * Domain Path: /languages
 */
namespace Am\APIPlugin;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( APIPlugin::class ) && is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__.'/vendor/autoload.php';
}

/**
 * Define consts
 */
define( 'AM_APIPLUGIN_SLUG', 'am-apiplugin' );
define( 'AM_APIPLUGIN_VERSION', '2.0.0' );

function am_apiplugin_init() {
    if ( ! class_exists( APIPlugin::class ) ) {
        error_log('Class APIPlugin not found. Did you forget to run composer install?');
        return;
    }

    APIPlugin::run();
}

am_apiplugin_init();