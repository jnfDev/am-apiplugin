<?php declare(strict_types=1);

namespace Am\APIPlugin\Admin;

use Exception;
use Am\APIPlugin\Models\FallbackResponse;
use Am\APIPlugin\Models\RequestsThrottling;
use Am\APIPlugin\Models\APIRequest;
use Am\APIPlugin\Singleton;
use Am\APIPlugin\Exceptions\RequestFailedException;

defined( 'ABSPATH' ) || exit;

final class AdminAJAXEndpoints
{
    use Singleton;

    /**
     * @var string
     */
    const NONCE_ACTION = "_wpnonce_am_apiplugin_";

    protected function init(): void
    {
        if ( ! ( defined('DOING_AJAX') && DOING_AJAX ) ) {
            return;
        }

        add_action( 'wp_ajax_am_reset_all_data', [ $this, 'resetAllData' ] );
        add_action( 'wp_ajax_am_get_challenge_data', [ $this, 'getChallengeData' ] );
        add_action( 'wp_ajax_nopriv_am_get_challenge_data', [ $this, 'getChallengeData' ] );
    }

    /**
     * Validate AJAX request.
     * 
     * @return bool
     */
    protected function validateAJAXRequest(): bool
    {
        $nonce = sanitize_key( $_POST['wpnonce'] );
        if ( ! wp_verify_nonce( $nonce, self::NONCE_ACTION  ) ) {
            return false;
        }
        
        return true;
    }

    /**
     * Reset all data stored in database.
     * AJAX Callback
     * 
     * @return void
     */
    public function resetAllData(): void 
    {
        try {
            if ( ! $this->validateAJAXRequest() ) {
                throw new RequestFailedException( "Invalid AJAX Request", 1 );
            }

            if ( ! current_user_can( 'manage_options' ) ) {
                throw new RequestFailedException( "The current user is not allowed to perform this action.", 1 );
            }

            FallbackResponse::reset();
            RequestsThrottling::reset();

            wp_send_json_success();

        } catch ( Exception $e ) {
            wp_send_json_error([
                'error_message' => $e->getMessage()
            ]);
        } 
    }

    /**
     * Get Challenge data from API.
     * AJAX Callback
     * 
     * @return void 
     */
    public function getChallengeData(): void
    {
        try {
            if ( ! $this->validateAJAXRequest() ) {
                throw new RequestFailedException( "Invalid AJAX Request", 1 );
            }

            $resourceId = (int) $_POST['challenge_id'];
            if ( empty( $resourceId ) ) {
                throw new RequestFailedException( "Missing challenge ID param", 1 );
            }

            $apiRequest = new APIRequest();
            $apiData    = $apiRequest->getChallengeById( $resourceId );

            wp_send_json_success( $apiData );

        } catch ( Exception $e ) {
            wp_send_json_error([
                'error_message' => $e->getMessage()
            ]);
        }
    }
}