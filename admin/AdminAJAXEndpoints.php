<?php declare(strict_types=1);

namespace Am\APIPlugin\Admin;

use Exception;
use Am\APIPlugin\Singleton;
use Am\APIPlugin\Models\RequestThrottle;
use Am\APIPlugin\Exceptions\EmptyFallbackResponseException;
use Am\APIPlugin\Exceptions\RequestFailedException;
use Am\APIPlugin\Models\AdminSettings;

defined( 'ABSPATH' ) || exit;

final class AdminAJAXEndpoints
{
    use Singleton;

    /**
     * @var string
     */
    const NONCE_ACTION = '_wpnonce_am_apiplugin_';

    /**
     * @var string
     */
    const AJAX_GET_API_DATA_ACTION = 'am_get_api_data_endpoint';

    /**
     * @var string
     */
    const AJAX_GET_SETTINGS_ACTION = 'am_get_settings_endpoint';

    /**
     * @var string
     */
    const AJAX_UPDATE_SETTING_ACTION = 'am_update_setting_endpoint';

    protected function init(): void
    {
        if ( ! ( defined('DOING_AJAX') && DOING_AJAX ) ) {
            return;
        }

        add_action( 'wp_ajax_' . self::AJAX_GET_API_DATA_ACTION, [ $this, 'ajaxGetApiData' ] );
        add_action( 'wp_ajax_' . self::AJAX_UPDATE_SETTING_ACTION, [ $this, 'ajaxUpdateSetting' ]);
        add_action( 'wp_ajax_' . self::AJAX_GET_SETTINGS_ACTION, [ $this, 'ajaxGetSettings' ] );
    }

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

    public function ajaxGetApiData(): void
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
                            throw new RequestFailedException();
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

    public function ajaxUpdateSetting(): void
    {
        try {
            if ( ! $this->validateAJAXRequest() ) {
                throw new RequestFailedException( "Invalid AJAX Request", 1 );
            }

            // We're letting the responsibility of sanitizing and validating
            // to the AdminSettings class, so we don't need to do nothing more here.
            $settingName  = $_POST['name'];
            $settingValue = $_POST['value'];

            AdminSettings::getInstance()->set( $settingName, $settingValue );
            wp_send_json_success();

        } catch ( Exception $e ) {
            wp_send_json_error([
                'error_message' => $e->getMessage()
            ]);
        }
    }

    public function ajaxGetSettings(): void
    {
        try {
            if ( ! $this->validateAJAXRequest() ) {
                throw new RequestFailedException( "Invalid AJAX Request", 1 );
            }

            $settings = AdminSettings::getInstance()->get();
            wp_send_json_success( $settings );

        } catch ( Exception $e ) {
            wp_send_json_error([
                'error_message' => $e->getMessage()
            ]);
        }
    }
}