<?php declare(strict_types=1);

namespace Am\APIPlugin\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Am\APIPlugin\Models\Request;
use Am\APIPlugin\Models\RequestThrottle;
use Am\APIPlugin\Models\FallbackResponse;
use Am\APIPlugin\Exceptions\RequestFailedException;

final class RequestTest extends TestCase
{
    const HOST_URL = 'https://miusage.com';

    const VALID_ENDPOINT = '/v1/challenge/1/';

    const INVALID_ENDPOINT = '/v1/non-existing-resource/1/';

    protected $requestThrottle;

    protected $request;

    protected function setUp(): void
    {
        /**
         * We have specific test class for testing the Request Throttle, 
         * check it here: tests/Unit/RequestThrottleTest.php
         */
        $this->requestThrottle = new RequestThrottle( self::HOST_URL );
        $this->request         = new Request( $this->requestThrottle );
    }

    protected function tearDown(): void
    {
        // Let's clean everything up.
        RequestThrottle::reset();
        FallbackResponse::reset();
    }

    public function testCanDoGetRequestWithValidEndpoint(): void
    {
        $validURL     = self::HOST_URL . self::VALID_ENDPOINT;
        $response     = $this->request->get( $validURL );
        $bodyResponse = json_decode( $response['body'], true );

        $this->assertEquals( 'This amazing table', $bodyResponse['title'] );
    }
    
    public function testCannotDoGetRequestWithInvalidEndpoint(): void
    {
        $invalidURL   = self::HOST_URL . self::INVALID_ENDPOINT;
        $response     = $this->request->get( $invalidURL );
        $bodyResponse = json_decode( $response['body'], true );

        $this->assertTrue( $bodyResponse['error'] );
    }

    public function testCannotDoRequestWithInvalidHostURL(): void
    {
        $this->expectException( RequestFailedException::class );
        $this->request->get( 'http//wrong()url_com' );
    }

    public function testCannotDoMoreThanOneRequestPerHour(): void
    {
        $validURL  = self::HOST_URL . self::VALID_ENDPOINT;
        $response1 = $this->request->get( $validURL );
        $response2 = $this->request->get( $validURL );

        $this->assertEquals( $this->request::OK, $response1['response']['code'] );
        $this->assertEquals( $this->request::TOO_MANY_REQUESTS, $response2['response']['code'] );

        $bodyResponse = json_decode( $response2['body'], true );
        $this->assertEquals( 'This amazing table', $bodyResponse['title'] );
    }
}