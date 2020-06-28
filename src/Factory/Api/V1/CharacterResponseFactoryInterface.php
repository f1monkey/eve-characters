<?php
declare(strict_types=1);

namespace App\Factory\Api\V1;

use App\Dto\Api\V1\Response\Character\CharacterListResponse;
use App\Dto\Api\V1\Response\Character\CharacterResponse;
use App\Entity\Character;
use Doctrine\Common\Collections\Collection;

/**
 * Interface CharacterResponseFactoryInterface
 *
 * @package App\Factory\Api\V1
 */
interface CharacterResponseFactoryInterface
{
    /**
     * @param Character $character
     *
     * @return CharacterResponse
     */
    public function createCharacterResponse(Character $character): CharacterResponse;

    /**
     * @param Collection<int, Character> $characters
     *
     * @return CharacterListResponse
     */
    public function createCharacterListResponse(Collection $characters): CharacterListResponse;
}