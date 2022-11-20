<?php declare(strict_types=1);

namespace Am\APIPlugin\Admin;

use Exception;
use Am\APIPlugin\Singleton;
use Am\APIPlugin\Models\RequestThrottle;
use Am\APIPlugin\Exceptions\EmptyFallbackResponseException;
use Am\APIPlugin\Exceptions\RequestFailedException;

defined( 'ABSPATH' ) || exit;

final class AdminAJAXEndpoints
{
    use Singleton;

    /**
     * @var string
     */
    const NONCE_ACTION = "_wpnonce_am_apiplugin_";

    /**
     * @var string
     */
    const AJAX_DATA_ENDPOINT_ACTION = "am_api_data_endpoint";

    protected function init(): void
    {
        if ( ! ( defined('DOING_AJAX') && DOING_AJAX ) ) {
            return;
        }

        add_action( "wp_ajax_" . self::AJAX_DATA_ENDPOINT_ACTION, [ $this, 'ajaxDataEndpoint' ] );
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

        if ( ! in_array('administrator',  wp_get_current_user()->roles ) ) {
            return false;
        }

        return true;
    }

    /**
     * Get Challenge data from API.
     * AJAX Callback
     * 
     * @return void 
     */
    public function ajaxDataEndpoint(): void
    {
        try {
            if ( ! $this->validateAJAXRequest() ) {
                throw new RequestFailedException( "Invalid AJAX Request", 1 );
            }

            $baseUrl     = 'https://miusage.com';
            $pathURL     = 'v1/challenge/2/static/';
            $apiEndpoint = "{$baseUrl}/{$pathURL}";

            $apiData = ( new RequestThrottle() )->__invoke( 
                $baseUrl, 
                function( $isThrottling ) use ( $apiEndpoint ) {
                    $fallbackResponseKey = 'am_api_data_endpoint';

                    if ( ! $isThrottling ) {
                        $rawResponse = wp_remote_get( $apiEndpoint );

                        if ( 200 !== $rawResponse['response']['code'] ) {
                            throw new RequestFailedException( "Request Failed." );
                        }

                        $response = $rawResponse['body'];

                        update_option( $fallbackResponseKey, $response );
                        return $response;
                    }

                    $fallbackResponse = get_option( 'am_api_data_endpoint' );

                    if ( empty( $fallbackResponse ) ) {
                        throw new EmptyFallbackResponseException();
                    }

                    return $fallbackResponse;
                }
            );

            wp_send_json_success( $apiData );

        } catch ( Exception $e ) {
            wp_send_json_error([
                'error_message' => $e->getMessage()
            ]);
        }
    }
}