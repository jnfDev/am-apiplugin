<?php declare(strict_types=1);

namespace Am\APIPlugin\Interfaces;

interface FallbackResponseInterface
{
    /**
     * Get Fallback Response.
     * 
     * @param string $requestUrl
     * 
     * @return array
     */
    public function get( string $requestUrl ): array;

    /**
     * Set Fallback Response.
     * 
     * @param string $requestUrl
     * 
     * @return bool
     */
    public function set( string $requestUrl, array $data ): bool;

    /**
     * Delete Fallback Response.
     * 
     * @param string $requestUrl
     * 
     * @return bool
     */
    public function delete( string $requestUrl ): bool;

    /**
     * Delete all Fallbacks Response 
     * stored in the database.
     * 
     * @return void
     */
    public static function reset(): void;

}