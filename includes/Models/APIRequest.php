<?php declare(strict_types=1);

namespace Am\APIPlugin\Models;

use Am\APIPlugin\Interfaces\RequestInterface;
use Am\APIPlugin\Models\Request;
use Am\APIPlugin\Models\RequestThrottle;
use Am\APIPlugin\Exceptions\APIRequestErrorException;

defined( 'ABSPATH' ) || exit;

class APIRequest
{
    const HOST_URL = 'https://miusage.com';

    const VERSION = 'v1';

    protected $request;

    public function __construct( RequestInterface $requestHandler = null ) {
        
        if ( is_null( $requestHandler ) ) {
            $requestThrottle = new RequestThrottle( self::HOST_URL );
            $requestHandler  = new Request( $requestThrottle );
        }

        $this->request = $requestHandler;
    }

    public function getChallengeById( int $id ): array
    {
        $endpoint = $this->getBaseUrl() . "/challenge/{$id}";
        $response = $this->request->get( $endpoint );
        $bodyResp = json_decode( $response['body'], true );

        if ( isset( $bodyResp['error'] ) && true === $bodyResp['error'] ) {
            throw new APIRequestErrorException( $bodyResp['message'] );
        }

        return $bodyResp;
    }

    protected function getBaseUrl(): string
    {
        return self::HOST_URL . '/' . self::VERSION; 
    }
}