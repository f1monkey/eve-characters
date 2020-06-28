<?php
declare(strict_types=1);

namespace App\Dto\Api\V1\Response\Character;

use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CharacterResponse
 *
 * @package App\Dto\Api\V1\Response\Character
 */
class CharacterResponse
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property(title="Character uuid", example="65130ef3-262a-4b8a-bbf5-cff9c727e331", type="string")
     */
    protected string $id;

    /**
     * @var int
     *
     * @Serializer\SerializedName("characterId")
     * @Serializer\Type("int")
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property(title="EVE Character id", example=1234567, type="integer")
     */
    protected int $characterId;

    /**
     * @var string
     *
     * @Serializer\SerializedName("characterName")
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property(title="Character name", example="Gallente Citizen 123", type="string")
     */
    protected string $characterName;

    /**
     * CharacterResponse constructor.
     *
     * @param string $id
     * @param int    $characterId
     * @param string $characterName
     */
    public function __construct(string $id, int $characterId, string $characterName)
    {
        $this->id            = $id;
        $this->characterId   = $characterId;
        $this->characterName = $characterName;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCharacterId(): int
    {
        return $this->characterId;
    }

    /**
     * @return string
     */
    public function getCharacterName(): string
    {
        return $this->characterName;
    }
}