<?php
declare(strict_types=1);

namespace App\Factory\Api\V1;

use App\Dto\Api\V1\Response\Character\CharacterResponse;
use App\Entity\Character;

/**
 * Class CharacterResponseFactory
 *
 * @package App\Factory\Api\V1
 */
class CharacterResponseFactory implements CharacterResponseFactoryInterface
{
    /**
     * @param Character $character
     *
     * @return CharacterResponse
     */
    public function createCharacterResponse(Character $character): CharacterResponse
    {
        return new CharacterResponse(
            (string)$character->getId(),
            $character->getEveCharacterId(),
            $character->getEveCharacterName()
        );
    }
}