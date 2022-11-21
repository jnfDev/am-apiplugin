<?php declare(strict_types=1);

namespace Am\APIPlugin\Models;

use Am\APIPlugin\Exceptions\WpdbNotDefinedException;
use Am\APIPlugin\Exceptions\InvalidURLException;

defined( 'ABSPATH' ) || exit;

class RequestThrottle
{
    private string $requestThrottleKey;

    private int $experitation;

    private const PREFIX = 'request_throttle_';

    public function __construct( int $experitation = HOUR_IN_SECONDS ) 
    {
        $this->experitation = $experitation;
    }

    public function __invoke( string $endpointURL, callable $fn)
    {
        if ( empty( $endpointURL ) || false === filter_var( $endpointURL, FILTER_VALIDATE_URL ) ) {
            throw new InvalidURLException();
        }

        $this->requestThrottleKey  = self::PREFIX . sanitize_key( parse_url( $endpointURL, PHP_URL_HOST ) );

        if ( $this->isThrottling() ) {

            return $fn( true );
        }

        $newFallbackResponse = $fn( false );
        $this->throttle();

        return $newFallbackResponse;
    }

    private function throttle(): bool
    {
        return set_transient( $this->requestThrottleKey, '1', $this->experitation );
    }

    private function isThrottling(): bool
    {
        return ! empty( get_transient( $this->requestThrottleKey ) );
    }

    public static function reset(): void
    {
        global $wpdb;
        
        if ( is_null( $wpdb ) || !( $wpdb instanceof \wpdb ) ) {
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