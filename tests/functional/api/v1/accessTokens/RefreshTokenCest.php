<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1\accessTokens;

use App\Tests\functional\api\v1\AbstractV1Cest;
use Codeception\Example;
use FunctionalTester;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RefreshTokenCest
 *
 * @package App\Tests\functional\api\v1\accessTokens
 */
class RefreshTokenCest extends AbstractV1Cest
{
    /**
     * @param FunctionalTester $I
     */
    public function cannotRefreshTokenWithoutAuthentication(FunctionalTester $I)
    {
        $I->sendPOST('/v1/access-tokens/refresh-token');

        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param FunctionalTester $I
     */
    public function canRefreshToken(FunctionalTester $I)
    {
        $character = $I->createCharacter();
        $I->haveInRepository($character);
        $characterToken = $I->createCharacterToken($character);
        $I->haveInRepository($characterToken);

        $I->amJwtAuthenticated();
        $I->sendPOST(
            '/v1/access-tokens/refresh-token',
            [
                'characterId' => $character->getId(),
            ]
        );

        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseMatchesJsonType(
            [
                'character'   => [
                    'id'            => 'string',
                    'characterId'   => 'integer',
                    'characterName' => 'string',
                ],
                'accessToken' => 'string',
            ]
        );
    }

    /**
     * @param FunctionalTester $I
     */
    public function cannotRefreshTokenWithInvalidCharacterId(FunctionalTester $I)
    {
        $character = $I->createCharacter();
        $I->haveInRepository($character);
        $characterToken = $I->createCharacterToken($character);
        $I->haveInRepository($characterToken);

        $I->amJwtAuthenticated();
        $I->sendPOST('/v1/access-tokens/refresh-token', ['characterId' => Uuid::uuid4()]);

        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
    }

    /**
     * @dataProvider invalidRequestProvider
     *
     * @param FunctionalTester $I
     * @param Example          $example
     */
    public function cannotRefreshTokenWithInvalidRequest(FunctionalTester $I, Example $example)
    {
        $I->amJwtAuthenticated();
        $I->sendPOST('/v1/access-tokens/refresh-token', $example['request']);

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return array
     */
    protected function invalidRequestProvider(): array
    {
        return [
            ['request' => []],
            ['request' => ['characterId' => '']],
            ['request' => ['characterId' => 'qwerty']],
            ['request' => ['characterId' => null]],
        ];
    }
}