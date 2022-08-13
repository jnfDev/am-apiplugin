<?php declare(strict_types=1);

namespace Am\APIPlugin\Admin;

use Exception;
use Am\APIPlugin\APIPlugin;
use Am\APIPlugin\Models\FallbackResponse;
use Am\APIPlugin\Models\RequestThrottle;
use Am\APIPlugin\Models\APIRequest;
use Am\APIPlugin\Singleton;
use Am\APIPlugin\Exceptions\RequestFailedException;

defined( 'ABSPATH' ) || exit;

final class AdminAJAXEndpoints
{
    use Singleton;

    protected function init()
    {
        if ( ! ( defined('DOING_AJAX') && DOING_AJAX ) ) {
            return;
        }

        add_action( 'wp_ajax_am_reset_all_data', [ $this, 'resetAllData' ] );
        add_action( 'wp_ajax_am_get_challenge_data', [ $this, 'getChallengeData' ] );
        add_action( 'wp_ajax_nopriv_am_get_challenge_data', [ $this, 'getChallengeData' ] );
    }

    protected function validateAJAXRequest(): bool
    {
        $nonce      = sanitize_key( $_POST['wpnonce'] );
        $textdomain = APIPlugin::getInstance()->textdomain;
        if ( ! wp_verify_nonce( $nonce, "_wpnonce_{$textdomain}"  ) ) {
            return false;
        }
        
        return true;
    }

    public function resetAllData(): void 
    {
        try {
            if( ! $this->validateAJAXRequest() ) {
                throw new RequestFailedException("Invalid AJAX Request", 1);
            }

            FallbackResponse::reset();
            RequestThrottle::reset();

            wp_send_json_success();

        } catch ( Exception $e ) {
            wp_send_json_error([
                'errorMessage' => $e->getMessage()
            ]);
        } 
    }

    public function getChallengeData(): void
    {
        try {
            if( ! $this->validateAJAXRequest() ) {
                throw new RequestFailedException("Invalid AJAX Request", 1);
            }

            $resourceId = (int) $_POST['challenge_id'];
            if ( empty( $resourceId ) ) {
                throw new RequestFailedException("Missing challenge ID param", 1);
            }

            $apiRequest = new APIRequest();
            $apiData    = $apiRequest->getChallengeById( $resourceId );

            wp_send_json_success($apiData);

        } catch ( Exception $e ) {
            wp_send_json_error([
                'errorMessage' => $e->getMessage()
            ]);
        }
    }
}