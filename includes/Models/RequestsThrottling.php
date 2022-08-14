<?php declare(strict_types=1);

namespace Am\APIPlugin\Models;

use wpdb;
use Am\APIPlugin\Interfaces\RequestsThrottlingInterface;
use Am\APIPlugin\Exceptions\InvalidObjectInstanceException;
use Am\APIPlugin\Exceptions\WpdbNotDefinedException;

defined( 'ABSPATH' ) || exit;

class RequestsThrottling implements RequestsThrottlingInterface
{
    /**
     * @var int Throttling duration in seconds.
     */
    protected $throttlingTime;

    /**
     * @var string ID for the throtter.
     */
    protected $throttlingKey;

    /**
     * @var string  
     * 
     * Prefix used to save the Requests Throttling flag in database.
     * Note: It will be saved on the option table as 
     * _transient__request_throttling_...
     * 
     */
    const PREFIX = '_request_throttling_';

    /**
     * @param  string $hostURL Used to generate the throttlingKey.
     * @param  int $throttlingTime The timespan in seconds for the throttling.
     * 
     * @throws InvalidObjectInstanceException if the provided $hostURL 
     *                                        is an invalid URL.
     * @return void
     */
    public function __construct( 
        string $hostURL, 
        int $throttlingTime = HOUR_IN_SECONDS
    ) {
        if ( empty( $hostURL ) || false === filter_var( $hostURL, FILTER_VALIDATE_URL ) ) {
            throw new InvalidObjectInstanceException( "Invalid Request's Host URL." );
        }

        $this->throttlingKey  = self::PREFIX . sanitize_key( parse_url( $hostURL, PHP_URL_HOST ) );
        $this->throttlingTime = $throttlingTime;
    }

    /**
     * Check if it's doing throttling.
     * 
     * @return bool
     */
    public function isThrottling(): bool
    {
        return ! empty( get_transient( $this->throttlingKey ) );
    }

    /**
     * Start throttling.
     * 
     * @return bool
     */
    public function throttling(): bool
    {
        return set_transient( $this->throttlingKey, '1', $this->throttlingTime );
    }

    /**
     * Stop the current throttling.
     * 
     * @return bool
     */
    public function stopThrottling(): bool
    {
        return delete_transient( $this->throttlingKey );
    }

    /**
     * Reset or remove all the Requests Throttling
     * stored in database.
     * 
     * @throws WpdbNotDefinedException if wpdb is not loaded in globals.
     * 
     * @return void
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