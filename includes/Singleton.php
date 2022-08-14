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

    /**
     * Get singleton's instance.
     * @return self
     */
    public static function getInstance(): self
    {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Shorthand for getInstance.
     * @return void
     */
    public static function run(): void
    {
        self::getInstance();
    }

    /**
     * Singleton's init.
     * @return void
     */
    abstract public function init(): void;
}