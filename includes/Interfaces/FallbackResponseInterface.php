<?php declare(strict_types=1);

namespace Am\APIPlugin\Interfaces;

interface FallbackResponseInterface
{
    /**
     * Get Fallback Response.
     */
    public function get( string $requestUrl ): array;

    /**
     * Set Fallback Response.
     */
    public function set( string $requestUrl, array $data ): bool;

    /**
     * Delete Fallback Response.
     */
    public function delete( string $requestUrl ): bool;

    /**
     * Delete all Fallbacks Response 
     * stored in the database.
     */
    public static function reset(): void;

}