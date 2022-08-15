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
    /**
     * @var RequestsThrottlingInterface
     */
    protected $requestsThrottling;

    /**
     * @var FallbackResponseInterface
     */
    protected $requestFallback;

    /**
     * @param RequestsThrottlingInterface $requestsThrottling
     * @param FallbackResponseInterface|null $fallbackResponse
     * 
     * @return void
     */
    public function __construct(
        RequestsThrottlingInterface $requestsThrottling,
        FallbackResponseInterface $fallbackResponse = null
    ) {
        $this->requestsThrottling  = $requestsThrottling;
        $this->fallbackResponse    = ! is_null( $fallbackResponse ) ? $fallbackResponse : new FallbackResponse();
    }

    /**
     * Parent's method but with Requests Throttling 
     * implementation on top.
     * 
     * @throws RequestFailedException If the request got an error.
     * 
     * @return array
     */
    public function get( $url, $args = [] ): array
    {
        if ( $this->requestsThrottling->isThrottling() ) {
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

        $this->requestsThrottling->throttling();
        $this->fallbackResponse->set( $url, $response );

        return $response;
    }

    public function post( $url, $args = [] ): array
    {
        // Not yet implemented, but maybe in the future 😉
        return [];
    }

    public function put( $url, $args = [] ): array
    {
        // Not yet implemented, but maybe in the future 😉
        return [];
    }

    public function patch( $url, $args = [] ): array
    {
        // Not yet implemented, but maybe in the future 😉
        return [];
    }

    public function delete( $url, $args = [] ): array
    {
        // Not yet implemented, but maybe in the future 😉
        return [];
    }
}