<?php declare(strict_types=1);

namespace Am\APIPlugin\CLI;

use WP_CLI;
use Exception;
use Am\APIPlugin\Models\RequestsThrottling;

defined( 'ABSPATH' ) || exit;

final class RequestThrottleCLI
{

    /**
     * Reset specifict (Host URL) Request Throttle.
     */
    public function reset( $args )
    {
        try {
            $hostURL = $args[0];
            (new RequestsThrottling( $hostURL ))->stopThrottling();
            WP_CLI::line( 'Request Throttlers was reset.' );

        } catch ( Exception $e ) {
            WP_CLI::error( $e->getMessage() );
        }
    }

    /**
     * Reset or remove all Request Throttles 
     * stored in database.
     */
    public function resetAll()
    {        
        try {
            RequestsThrottling::reset();
            WP_CLI::line( 'All Request Throttlers were reset.' );

        } catch ( Exception $e ) {
            WP_CLI::error( $e->getMessage() );
        }
    }
}