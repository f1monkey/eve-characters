<?php
declare(strict_types=1);

namespace App\Tests\unit\Factory\Api\V1;

use App\Factory\Api\V1\AccessTokenResponseFactory;
use Codeception\Test\Unit;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Class AccessTokenResponseFactoryTest
 *
 * @package App\Tests\unit\Factory\Api\V1
 */
class AccessTokenResponseFactoryTest extends Unit
{
    /**
     * @throws ExpectationFailedException
     */
    public function testCanCreateGetRedirectUrlResponse()
    {
        $expected = 'url';

        $factory = new AccessTokenResponseFactory();
        $result  = $factory->createGetRedirectUrlResponse($expected);

        static::assertSame($expected, $result->getRedirectUrl());
    }
}