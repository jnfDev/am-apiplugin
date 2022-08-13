<?php declare(strict_types=1);

namespace Am\APIPlugin\Models;

use wpdb;
use Am\APIPlugin\Interfaces\FallbackResponseInterface;
use Am\APIPlugin\Exceptions\InvalidURLException;
use Am\APIPlugin\Exceptions\WpdbNotDefinedException;

defined( 'ABSPATH' ) || exit;

class FallbackResponse implements FallbackResponseInterface
{
    /**
     * Prefix for Fallback Response Key
     */
    const PREFIX = "_fallback_response_";

    /**
     * Get Fallback Response.
     */
    public function get( string $requestUrl ): array
    {
        $fallbackResponseKey = $this->generateFallbackResponseKey( $requestUrl );
        $response = get_transient( $fallbackResponseKey );

        return ! empty( $response ) ? $response : [];
    }

    /**
     * Set Fallback Response.
     */
    public function set( string $requestUrl, array $data ): bool
    {
        $fallbackResponseKey = $this->generateFallbackResponseKey( $requestUrl );
        return set_transient( $fallbackResponseKey, $data );
    } 

    /**
     * Delete Fallback Response.
     */
    public function delete( string $requestUrl ): bool
    {
        $fallbackResponseKey = $this->generateFallbackResponseKey( $requestUrl );
        return delete_transient( $fallbackResponseKey );
    }

    /**
     * Delete all Fallbacks Response 
     * stored in the database.
     */
    public static function reset(): void
    {
        global $wpdb;
        
        if ( is_null( $wpdb ) || ! ( $wpdb instanceof wpdb ) ) {
            throw new WpdbNotDefinedException();
        }

        $prefix = self::PREFIX;

        $transientsToDelete = $wpdb->get_col(
            "SELECT `option_name` FROM `{$wpdb->options}` WHERE `option_name` LIKE '_transient_{$prefix}%'",
        );

        foreach ( $transientsToDelete as $transient ) {
            delete_transient( $transient );
        }
    }

    /**
     * Generate Fallback Response key based on URL.
     */
    protected function generateFallbackResponseKey( $requestUrl ): string
    {
        if ( empty( $requestUrl ) || false === filter_var( $requestUrl, FILTER_VALIDATE_URL ) ) {
            throw new InvalidURLException( "Invalid Request's URL." );
        }

        return self::PREFIX . sanitize_key( $requestUrl );
    }
}