<?php
/**
 * Plugin Name: Am API Based Plugin
 * Author: jnfdev
 * Domain: am-apiplugin
 * Domain Path: /languages
 */
namespace Am\APIPlugin;

defined( 'ABSPATH' ) || exit;

require_once __DIR__.'/vendor/autoload.php';

/**
 * Define consts
 */
define( 'JNFDEV_APIPLUGIN_VERSION', '1.0.0' );
define( 'JNFDEV_APIPLUGIN_ROOT_PATH', __DIR__ );
define( 'JNFDEV_APIPLUGIN_TEXTDOMAIN', 'jnfdev-apiplugin' );

APIPlugin::run();