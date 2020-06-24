<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1\accessTokens;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetRedirectUrlCest
 *
 * @package App\Tests\functional\api\v1\accessTokens
 */
class GetRedirectUrlCest
{
    /**
     * @param FunctionalTester $I
     */
    public function canGetRedirectUrlWithValidScopes(FunctionalTester $I)
    {
        $I->amJwtAuthorized();
        $I->sendGET('/v1/access-tokens/redirect-url?scopes=publicData esi-skills.read_skills.v1');
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
        $I->amJwtAuthorized();
        $I->sendGET('/v1/access-tokens/redirect-url');
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }
}