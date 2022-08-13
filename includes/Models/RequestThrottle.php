<?php declare(strict_types=1);

namespace Am\APIPlugin\Models;

use wpdb;
use Am\APIPlugin\Interfaces\RequestThrottleInterface;
use Am\APIPlugin\Exceptions\InvalidObjectInstanceException;
use Am\APIPlugin\Exceptions\WpdbNotDefinedException;

defined( 'ABSPATH' ) || exit;

class RequestThrottle implements RequestThrottleInterface
{
    /**
     * @var int Throttling duration in seconds.
     */
    protected $throttleTime;

    /**
     * @var string ID for the throtter.
     */
    protected $throttleKey;

    /**
     * Prefix used to save the throttle in database.
     * Note: It will be saved on the option table as 
     * _transient__request_throttle_...
     */
    const PREFIX = '_request_throttle_';

    public function __construct( 
        string $hostURL, 
        int $throttleTime = HOUR_IN_SECONDS
    ) {
        if ( empty( $hostURL ) || false === filter_var( $hostURL, FILTER_VALIDATE_URL ) ) {
            throw new InvalidObjectInstanceException( "Invalid Request's Host URL." );
        }

        $this->throttleKey  = self::PREFIX . preg_replace( '/[^a-zA-Z0-9_]/', '_', parse_url( $hostURL, PHP_URL_HOST ) );
        $this->throttleTime = $throttleTime;
    }

    /**
     * Check if it's doing throttling.
     */
    public function isThrottling(): bool
    {
        return ! empty( get_transient( $this->throttleKey ) );
    }

    /**
     * Start throttling.
     */
    public function throttling(): bool
    {
        return set_transient( $this->throttleKey, '1', $this->throttleTime );
    }

    /**
     * Stop the current throttling.
     */
    public function stopThrottling(): bool
    {
        return delete_transient( $this->throttleKey );
    }

    /**
     * Reset or remove all Request Throttles
     * stored in database.
     */
    public static function reset(): void
    {
        global $wpdb;
        
        if ( is_null( $wpdb ) || !( $wpdb instanceof wpdb ) ) {
            throw new WpdbNotDefinedException();
        }

        $prefix = self::PREFIX;

        $transientsToDelete = $wpdb->get_col(
            "SELECT REPLACE(`option_name`, '_transient_', '') FROM `{$wpdb->options}` WHERE `option_name` LIKE '_transient_{$prefix}%'",
        );

        foreach ( $transientsToDelete as $transient ) {
            delete_transient( $transient );
        }
    }
}