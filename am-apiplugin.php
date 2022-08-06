<?php
/**
 * Plugin Name: My Plugin (Boilerplate Plugin)
 * Author: jnfdev
 * 
 */
namespace Jnfdev\APIPlugin;

defined( 'ABSPATH' ) || exit;

require_once __DIR__.'/vendor/autoload.php';

/**
 * Define consts
 */
define( 'JNFDEV_APIPLUGIN_VERSION', '1.0.0' );
define( 'JNFDEV_APIPLUGIN_TEXTDOMAIN', 'jnfdev-apiplugin' );

APIPlugin::run();