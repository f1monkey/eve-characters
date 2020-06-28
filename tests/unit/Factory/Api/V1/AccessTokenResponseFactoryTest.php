<?php
declare(strict_types=1);

namespace App\Tests\unit\Factory\Api\V1;

use App\Dto\Api\V1\Response\Character\CharacterResponse;
use App\Entity\CharacterToken;
use App\Factory\Api\V1\AccessTokenResponseFactory;
use App\Factory\Api\V1\CharacterResponseFactory;
use App\Factory\Api\V1\CharacterResponseFactoryInterface;
use Codeception\Test\Unit;
use Exception;
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
     * @throws Exception
     */
    public function testCanCreateGetRedirectUrlResponse()
    {
        $expected = 'url';

        /** @var CharacterResponseFactoryInterface $characterFactory */
        $characterFactory = $this->makeEmpty(CharacterResponseFactory::class);
        $factory          = new AccessTokenResponseFactory($characterFactory);
        $result           = $factory->createGetRedirectUrlResponse($expected);

        static::assertSame($expected, $result->getRedirectUrl());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanCreateAccessTokenResponse()
    {
        $character   = $this->makeEmpty(CharacterResponse::class);
        $accessToken = 'token';

        /** @var CharacterToken $characterToken */
        $characterToken = $this->makeEmpty(
            CharacterToken::class,
            [
                'getAccessToken' => $accessToken,
            ]
        );

        /** @var CharacterResponseFactoryInterface $characterFactory */
        $characterFactory = $this->makeEmpty(
            CharacterResponseFactory::class,
            [
                'createCharacterResponse' => $character,
            ]
        );

        $factory = new AccessTokenResponseFactory($characterFactory);
        $result  = $factory->createAccessTokenResponse($characterToken);

        static::assertSame($character, $result->getCharacter());
        static::assertSame($accessToken, $result->getAccessToken());
    }
}