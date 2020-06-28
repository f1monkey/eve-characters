<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1\characters;

use FunctionalTester;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CharacterDeleteCest
 *
 * @package App\Tests\functional\api\v1\characters
 */
class CharacterDeleteCest
{
    /**
     * @param FunctionalTester $I
     */
    public function cannotDeleteCharacterWithoutAuthentication(FunctionalTester $I)
    {
        $I->sendDELETE(sprintf('/v1/characters/%s', Uuid::uuid4()));
        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param FunctionalTester $I
     */
    public function canDeleteCharacter(FunctionalTester $I)
    {
        $character = $I->createCharacter();
        $I->haveInRepository($character);
        $characterToken = $I->createCharacterToken($character);
        $I->haveInRepository($characterToken);

        $I->amJwtAuthenticated();
        $I->sendDELETE(sprintf('/v1/characters/%s', $character->getId()));
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseMatchesJsonType(
            [
                'id'            => 'string',
                'characterId'   => 'integer',
                'characterName' => 'string',
            ],
        );
    }

    /**
     * @param FunctionalTester $I
     */
    public function cannotDeleteNotExistingCharacter(FunctionalTester $I)
    {
        $character = $I->createCharacter();
        $I->haveInRepository($character);
        $characterToken = $I->createCharacterToken($character);
        $I->haveInRepository($characterToken);

        $I->amJwtAuthenticated();
        $I->sendDELETE(sprintf('/v1/characters/%s', Uuid::uuid4()));
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
    }
}