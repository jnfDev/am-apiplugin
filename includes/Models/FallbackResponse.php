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
     * @var string
     * 
     * Prefix for Fallback Response Key
     * Note: It will be saved on the option table as 
     * _transient___fallback_response_...
     */
    const PREFIX = "_fallback_response_";

    /**
     * Get Fallback Response.
     * 
     * @param string $requestUrl Use to generate key. 
     * 
     * @return array
     */
    public function get( string $requestUrl ): array
    {
        $fallbackResponseKey = $this->generateFallbackResponseKey( $requestUrl );
        $response = get_transient( $fallbackResponseKey );

        return ! empty( $response ) ? $response : [];
    }

    /**
     * Set Fallback Response.
     * 
     * @param string $requestUrl Use to generate key. 
     * @param array  $data Response data to be stored.
     * 
     * @return bool
     */
    public function set( string $requestUrl, array $data ): bool
    {
        $fallbackResponseKey = $this->generateFallbackResponseKey( $requestUrl );
        return set_transient( $fallbackResponseKey, $data );
    } 

    /**
     * Delete Fallback Response.
     * 
     * @param string $requestUrl Use to generate key. 
     * 
     * @return bool
     */
    public function delete( string $requestUrl ): bool
    {
        $fallbackResponseKey = $this->generateFallbackResponseKey( $requestUrl );
        return delete_transient( $fallbackResponseKey );
    }

    /**
     * Delete all Fallbacks Response 
     * stored in the database.
     * 
     * @throws WpdbNotDefinedException if wpdb is not loaded in globals.
     * 
     * @return void 
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
     * 
     * @param string $requestUrl Use to generate key.
     * 
     * @throws InvalidURLException if given $requestUrl is invalid or empty.
     * 
     * @return string
     */
    protected function generateFallbackResponseKey( string $requestUrl ): string
    {
        if ( empty( $requestUrl ) || false === filter_var( $requestUrl, FILTER_VALIDATE_URL ) ) {
            throw new InvalidURLException( "Invalid Request's URL." );
        }

        return self::PREFIX . sanitize_key( $requestUrl );
    }
}