<?php declare(strict_types=1);

namespace Am\APIPlugin;

defined( 'ABSPATH' ) || exit;

trait Singleton 
{
    private static $instance;

    private function __construct() 
    {
        $this->init();
    }

    public static function getInstance()
    {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function run()
    {
        self::getInstance();
    }

    abstract public function init();
}