<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1\characters;

use App\Tests\functional\api\v1\AbstractV1Cest;
use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CharacterListCest
 *
 * @package App\Tests\functional\api\v1\characters
 */
class CharacterListCest extends AbstractV1Cest
{
    /**
     * @param FunctionalTester $I
     */
    public function cannotGetCharacterListWithoutAuthentication(FunctionalTester $I)
    {
        $I->sendGET('/v1/characters');
        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param FunctionalTester $I
     */
    public function canGetCharacterList(FunctionalTester $I)
    {
        $character = $I->createCharacter();
        $I->haveInRepository($character);
        $characterToken = $I->createCharacterToken($character);
        $I->haveInRepository($characterToken);

        $I->amJwtAuthenticated();
        $I->sendGET('/v1/characters');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseMatchesJsonType(
            [
                'items' => [
                    ['id' => 'string', 'characterId' => 'integer', 'characterName' => 'string'],
                ],
            ]
        );
    }
}