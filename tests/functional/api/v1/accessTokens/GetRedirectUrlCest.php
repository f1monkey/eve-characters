<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1\accessTokens;

use App\Tests\_support\Mocks\OAuthServiceMock;
use App\Tests\functional\api\v1\AbstractV1Cest;
use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetRedirectUrlCest
 *
 * @package App\Tests\functional\api\v1\accessTokens
 */
class GetRedirectUrlCest extends AbstractV1Cest
{
    /**
     * @param FunctionalTester $I
     */
    public function cannotGetRedirectUrlWithoutAuthentication(FunctionalTester $I)
    {
        $I->sendGET('/v1/access-tokens/redirect-url');
        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param FunctionalTester $I
     */
    public function canGetRedirectUrlWithValidScopes(FunctionalTester $I)
    {
        $I->amJwtAuthenticated();
        $I->sendGET(sprintf('/v1/access-tokens/redirect-url?scopes=%s', 'publicData esi-skills.read_skills.v1'));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseMatchesJsonType(
            [
                'redirectUrl' => 'string',
            ]
        );
    }

    /**
     * @param FunctionalTester $I
     */
    public function cannotGetRedirectUrlWithoutScopes(FunctionalTester $I)
    {
        $I->amJwtAuthenticated();
        $I->sendGET('/v1/access-tokens/redirect-url');
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param FunctionalTester $I
     */
    public function cannotGetRedirectUrlWithInvalidScopes(FunctionalTester $I)
    {
        $I->amJwtAuthenticated();
        $I->sendGET(sprintf('/v1/access-tokens/redirect-url?scopes=%s', OAuthServiceMock::INVALID_SCOPE));
        $I->seeResponseCodeIs(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}