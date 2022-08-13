<?php declare(strict_types=1);

namespace Am\APIPlugin\Models;

use WP_Http;
use Am\APIPlugin\Models\FallbackResponse;
use Am\APIPlugin\Interfaces\RequestInterface;
use Am\APIPlugin\Interfaces\RequestsThrottlingInterface;
use Am\APIPlugin\Interfaces\FallbackResponseInterface;
use Am\APIPlugin\Exceptions\EmptyFallbackResponseException;
use Am\APIPlugin\Exceptions\RequestFailedException;

defined( 'ABSPATH' ) || exit;

class Request extends WP_Http implements RequestInterface
{
    protected $requestThrottle;

    protected $requestFallback;

    protected $throttlePrefix;

    public function __construct(
        RequestsThrottlingInterface $requestThrottle,
        FallbackResponseInterface $fallbackResponse = null
    ) {
        $this->requestThrottle  = $requestThrottle;
        $this->fallbackResponse = ! is_null( $fallbackResponse ) ? $fallbackResponse : new FallbackResponse();
    }

    public function get( $url, $args = [] )
    {
        if ( $this->requestThrottle->isThrottling() ) {
            $fallbackResponse = $this->fallbackResponse->get( $url );

            if ( ! isset( $fallbackResponse['response']['code'] ) ) {
                throw new EmptyFallbackResponseException( "Request {$url} doesn't have any fallback response defined." );
            }

            $fallbackResponse['response']['code']    = self::TOO_MANY_REQUESTS;
            $fallbackResponse['response']['message'] = 'Too many requests, fallback returned.';

            return $fallbackResponse;
        }

        // Do actual request.
        $response = parent::get( $url, $args );

        if ( is_wp_error( $response ) ) {
            /**
             * @var \WP_Error
             */
            $error = $response;
            throw new RequestFailedException( $error->get_error_message() );
        }

        $this->requestThrottle->throttling();
        $this->fallbackResponse->set( $url, $response );

        return $response;
    }

    public function post( $url, $args = [] )
    {
        // Not yet implemented, but maybe in the future 😉
    }

    public function put( $url, $args = [] )
    {
        // Not yet implemented, but maybe in the future 😉
    }

    public function patch( $url, $args = [] )
    {
        // Not yet implemented, but maybe in the future 😉
    }

    public function delete( $url, $args = [] )
    {
        // Not yet implemented, but maybe in the future 😉
    }
}