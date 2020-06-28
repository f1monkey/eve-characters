<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1\characters;

use App\Tests\functional\api\v1\AbstractV1Cest;
use FunctionalTester;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class CharacterGetByIdCest extends AbstractV1Cest
{
    /**
     * @param FunctionalTester $I
     */
    public function cannotGetCharacterByIdWithoutAuthentication(FunctionalTester $I)
    {
        $I->sendGET(sprintf('/v1/characters/%s', Uuid::uuid4()));
        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param FunctionalTester $I
     */
    public function canGetCharacterById(FunctionalTester $I)
    {
        $character = $I->createCharacter();
        $I->haveInRepository($character);
        $characterToken = $I->createCharacterToken($character);
        $I->haveInRepository($characterToken);

        $I->amJwtAuthenticated();
        $I->sendGET(sprintf('/v1/characters/%s', $character->getId()));
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
    public function cannotGetNotExistingCharacterById(FunctionalTester $I)
    {
        $character = $I->createCharacter();
        $I->haveInRepository($character);
        $characterToken = $I->createCharacterToken($character);
        $I->haveInRepository($characterToken);

        $I->amJwtAuthenticated();
        $I->sendGET(sprintf('/v1/characters/%s', Uuid::uuid4()));
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
    }
}