<?php declare(strict_types=1);

namespace Am\APIPlugin\Interfaces;

interface RequestsThrottlingInterface
{
    /**
     * Check if it's doing throttling.
     */
    public function isThrottling(): bool;

     /**
     * Start throttling.
     */
    public function throttling(): bool;

    /**
     * Stop the current throttling.
     */
    public function stopThrottling(): bool;

    /**
     * Reset or remove all Request Throttles
     * stored in database.
     */
    public static function reset(): void;
}