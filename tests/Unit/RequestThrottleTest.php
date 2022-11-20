<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Am\APIPlugin\Models\RequestThrottle;

final class RequestThrottleTest extends TestCase
{
    private const OK = 200;

    private const TOO_MANY_REQUESTS = 429;

    protected function setUp(): void
    {
        RequestThrottle::reset();
    }

    public function testCanDoRequestThrottling() 
    {
        $validEndpoint   = 'https://miusage.com/v1/challenge/2/static/';  
        $requestThrottle = new RequestThrottle( 5 );

        for ( $reqNum = 1; $reqNum <= 3; $reqNum++ ) {

            if ( 3 === $reqNum ) {
                sleep(10);
            }

            $response = $requestThrottle->__invoke( $validEndpoint, function( $isThrottling ) {
                if ( $isThrottling ) {
                    // Here you can throw an exception
                    // Return a fallback response or
                    // Return any other suitable response to your client.
                    return [
                        'code'    => self::TOO_MANY_REQUESTS,
                        'data' => 'Too Many Requests' 
                    ];
                }
    
                // Here you must return the 
                // actual http's response.
                return [
                    'code'     => self::OK,
                    'data' => 'My Cool HTTTP response.'
                ];
            } );


            if ( 1 === $reqNum ) {
                $this->assertEquals(self::OK, $response['code']);
            }

            if ( 2 === $reqNum ) {
                $this->assertEquals(self::TOO_MANY_REQUESTS, $response['code']);
            }

            if ( 3 === $reqNum ) {
                $this->assertEquals(self::OK, $response['code']);
            }
        }
    }

}