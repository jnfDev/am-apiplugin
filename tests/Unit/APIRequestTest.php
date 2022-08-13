<?php declare(strict_types=1);

namespace Am\APIPlugin\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Am\APIPlugin\Models\APIRequest;
use Am\APIPlugin\Models\RequestsThrottling;
use Am\APIPlugin\Models\FallbackResponse;
use Am\APIPlugin\Exceptions\APIRequestErrorException;

final class APIRequestTest extends TestCase
{
    protected function tearDown(): void
    {
        // Let's clean everything up.
        RequestsThrottling::reset();
        FallbackResponse::reset();
    }

    public function testCanGetChallengeWithValidId(): void
    {
        $resourceId = 1;
        $apiRequest = new APIRequest();
        $apiData    = $apiRequest->getChallengeById( $resourceId );

        $this->assertEquals( 'This amazing table', $apiData['title'] );
    }

    public function testCannotGetChallengeWithInvalidId(): void
    {
        $resourceId = -99;
        $apiRequest = new APIRequest();
        
        $this->expectException( APIRequestErrorException::class );
        $apiRequest->getChallengeById( $resourceId );
    }
}