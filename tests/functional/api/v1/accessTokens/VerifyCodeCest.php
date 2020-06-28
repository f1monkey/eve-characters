<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1\accessTokens;

use App\Tests\functional\api\v1\AbstractV1Cest;
use Codeception\Example;
use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VerifyCodeCest
 *
 * @package App\Tests\functional\api\v1\accessTokens
 */
class VerifyCodeCest extends AbstractV1Cest
{
    /**
     * @param FunctionalTester $I
     */
    public function cannotVerifyCodeWithoutAuthentication(FunctionalTester $I)
    {
        $I->sendPOST('/v1/access-tokens/verify-code');

        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param FunctionalTester $I
     */
    public function canVerifyAuthorizationCode(FunctionalTester $I)
    {
        $I->amJwtAuthenticated();
        $I->sendPOST(
            '/v1/access-tokens/verify-code',
            [
                'code' => 'code',
            ]
        );

        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseMatchesJsonType(
            [
                'character' => [
                    'id'            => 'string',
                    'characterId'   => 'integer',
                    'characterName' => 'string',
                ],
                'accessToken' => 'string'
            ]
        );
    }

    /**
     * @dataProvider invalidRequestProvider
     *
     * @param FunctionalTester $I
     * @param Example          $example
     */
    public function cannotVerifyAuthorizationCodeWithInvalidRequest(FunctionalTester $I, Example $example)
    {
        $I->amJwtAuthenticated();
        $I->sendPOST('/v1/access-tokens/verify-code', $example['request']);

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @return array
     */
    protected function invalidRequestProvider(): array
    {
        return [
            ['request' => []],
            ['request' => ['code' => '']],
            ['request' => ['code' => null]],
        ];
    }
}