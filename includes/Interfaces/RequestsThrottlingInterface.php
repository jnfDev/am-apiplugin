<?php declare(strict_types=1);

namespace Am\APIPlugin\Interfaces;

interface RequestsThrottlingInterface
{
    /**
     * Check if it's doing throttling.
     * 
     * @return bool
     */
    public function isThrottling(): bool;

     /**
     * Start throttling.
     * 
     * @return bool
     */
    public function throttling(): bool;

    /**
     * Stop the current throttling.
     * 
     * @return bool
     */
    public function stopThrottling(): bool;

    /**
     * Reset or remove all Request Throttles
     * stored in database.
     * 
     * @return void
     */
    public static function reset(): void;
}