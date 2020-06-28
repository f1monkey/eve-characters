<?php
declare(strict_types=1);

namespace App\Factory\Api\V1;

use App\Dto\Api\V1\Response\Character\CharacterListResponse;
use App\Dto\Api\V1\Response\Character\CharacterResponse;
use App\Entity\Character;
use Doctrine\Common\Collections\Collection;

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

    /**
     * @param Collection<int, Character> $characters
     *
     * @return CharacterListResponse
     */
    public function createCharacterListResponse(Collection $characters): CharacterListResponse
    {
        return new CharacterListResponse(
            $characters->map(
                function (Character $character) {
                    return $this->createCharacterResponse($character);
                }
            )
        );
    }
}