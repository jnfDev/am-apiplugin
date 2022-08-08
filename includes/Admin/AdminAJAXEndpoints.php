<?php declare(strict_types=1);

namespace Am\APIPlugin\Admin;

use Exception;
use Am\APIPlugin\Models\APIRequest;
use Am\APIPlugin\Singleton;
use Am\APIPlugin\Exceptions\RequestFailedException;

defined( 'ABSPATH' ) || exit;

final class AdminAJAXEndpoints
{
    use Singleton;

    const _WPNONCE = 'am-api-plugin-admin-ajax-endpoints';

    protected function init()
    {
        if ( ! ( defined('DOING_AJAX') && DOING_AJAX ) ) {
            return;
        }

        add_action( 'wp_ajax_am_get_challenge_data', [ $this, 'getChallengeData' ] );
        add_action( 'wp_ajax_nopriv_am_get_challenge_data', [ $this, 'getChallengeData' ] );
    }

    protected function validateAJAXRequest(): bool
    {
        $nonce = $_POST['_wpnonce'];
        if ( ! wp_verify_nonce( $nonce, self::_WPNONCE ) ) {
            return false;
        }
        
        return true;
    }

    public function getChallengeData(): void
    {
        try {
            if( ! $this->validateAJAXRequest() ) {
                throw new RequestFailedException("Invalid AJAX Request", 1);
            }

            // Do actual request here..
            $resourceId = 1;
            $apiRequest = new APIRequest();
            $apiData    = $apiRequest->getChallengeById( $resourceId );

            wp_send_json_success([
                'error' => false,
                'data' => $apiData
            ]);

        } catch (Exception $e) {
            wp_send_json_error([
                'error'         => true,
                'error_message' => $e->getMessage()
            ]);
        }
    }
}