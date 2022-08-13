<?php declare(strict_types=1);

namespace Jnfdev\APIPlugin\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Am\APIPlugin\Models\RequestsThrottling;
use Am\APIPlugin\Exceptions\InvalidObjectInstanceException;

final class RequestThrottleTest extends TestCase
{
    const VALID_HOST_URL = 'https://www.myvalidendpoint.com';

    const INVALID_HOST_URL = 'https:://<p>Invalid URL</p>';
    
    protected function tearDown(): void
    {
        RequestsThrottling::reset();
    }

    public function testCanBeCreatedWithValidEndpoint(): void
    {
        $reqThrottle = new RequestsThrottling( self::VALID_HOST_URL );
        $this->assertInstanceOf( RequestsThrottling::class, $reqThrottle );
    }

    public function testCannotBeCreatedWithInvalidEndpoint(): void
    {
        $this->expectException( InvalidObjectInstanceException::class );
        $reqThrottle = new RequestsThrottling( self::INVALID_HOST_URL );
    }

    public function testCanStartThrottling()
    {
        $reqThrottle = new RequestsThrottling( self::VALID_HOST_URL );
        $reqThrottle->throttling();

        $this->assertTrue( $reqThrottle->isThrottling() );
    }

    public function testCanResetThrottling()
    {
        $reqThrottle = new RequestsThrottling( self::VALID_HOST_URL );
        $reqThrottle->throttling();

        $reqThrottle->reset();
        $this->assertFalse( $reqThrottle->isThrottling() );
    }

    public function testDoesThrottlingDisappearAfterFiveSeconds()
    {
        ( new RequestsThrottling( self::VALID_HOST_URL, 5 ) )->throttling();

        $req1 = new RequestsThrottling( self::VALID_HOST_URL );
        $this->assertTrue( $req1->isThrottling() );

        sleep( 10 );

        $req2 = new RequestsThrottling( self::VALID_HOST_URL );
        $this->assertFalse( $req2->isThrottling() );
    }

    public function testDoesnotThrottlingDisappearBeforeFiveSeconds()
    {
        ( new RequestsThrottling( self::VALID_HOST_URL, 5 ) )->throttling();

        $req1 = new RequestsThrottling( self::VALID_HOST_URL );
        $this->assertTrue( $req1->isThrottling() );

        sleep( 3 );

        $req2 = new RequestsThrottling( self::VALID_HOST_URL );
        $this->assertTrue( $req2->isThrottling() );
    }
}