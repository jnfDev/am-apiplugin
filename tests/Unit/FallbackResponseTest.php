<?php declare(strict_types=1);

namespace Jnfdev\APIPlugin\Tests\Unit;

use ReflectionMethod;
use PHPUnit\Framework\TestCase;
use Am\APIPlugin\Models\FallbackResponse;
use Am\APIPlugin\Exceptions\InvalidURLException;

final class FallbackResponseTest extends TestCase
{
    const VALID_URL = 'https://www.myvalidendpoint.com';

    const INVALID_URL = 'https:://<p>Invalid URL</p>';
    

    protected function tearDown(): void
    {
        FallbackResponse::reset();
    }

    public function testCanGenerateThrottleKeyWithValidURL(): void
    {
        $fallbackResp = new FallbackResponse();

        $reflectionMethod = new ReflectionMethod( FallbackResponse::class, 'generateFallbackResponseKey' );
        $reflectionMethod->setAccessible(true);
        $fallbackRespKey = $reflectionMethod->invoke( $fallbackResp, self::VALID_URL );

        $this->assertEquals( '_fallback_response_https___www_myvalidendpoint_com', $fallbackRespKey );
    }

    public function testCannotGenerateThrottleKeyWithInvalidURL(): void
    {
        $this->expectException( InvalidURLException::class );

        $fallbackResp     = new FallbackResponse();
        $reflectionMethod = new ReflectionMethod( FallbackResponse::class, 'generateFallbackResponseKey' );

        $reflectionMethod->setAccessible(true);
        $fallbackRespKey = $reflectionMethod->invoke( $fallbackResp, self::INVALID_URL );
    }

    public function testCanBeCreated(): void
    {
        $fallbackResp = new FallbackResponse();
        $fallbackResp->set( self::VALID_URL, [ 'mydata' => 'My Data' ] );

        $data = $fallbackResp->get( self::VALID_URL );
        $this->assertEquals( 'My Data', $data['mydata'] );
    }

    public function testCanBeUpdated(): void
    {
        $fallbackResp1 = new FallbackResponse();
        $fallbackResp1->set( self::VALID_URL, [ 'mydata' => 'My Data' ] );
        $fallbackResp1->set( self::VALID_URL, [ 'mydata' => 'My Data UPDATED' ] );

        $fallbackResp2 = new FallbackResponse();
        $data = $fallbackResp2->get( self::VALID_URL );

        $this->assertEquals( 'My Data UPDATED', $data['mydata'] );
    }

    public function testCanBeDeleted(): void
    {
        $fallbackResp = new FallbackResponse();
        $fallbackResp->set( self::VALID_URL, [ 'mydata' => 'My Data' ] );

        $data = $fallbackResp->get( self::VALID_URL );
        $this->assertEquals( 'My Data', $data['mydata'] );

        $fallbackResp->delete( self::VALID_URL );
        $this->assertEmpty( $fallbackResp->get( self::VALID_URL ) );
    }
} 