<?php
declare(strict_types=1);

namespace App\Dto\Api\V1\Request\AccessToken;

use App\Dto\Api\RequestInterface;
use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RefreshTokenRequest
 *
 * @package App\Dto\Api\V1\Request\AccessToken
 */
class RefreshTokenRequest implements RequestInterface
{
    /**
     * @var string
     *
     *
     * @Serializer\SerializedName("characterId")
     * @Serializer\Type("string")
     *
     * @Assert\Uuid()
     * @Assert\NotBlank()
     *
     * @SWG\Property(type="string", title="Character ID", example="5d543645-4e35-4643-a0c1-6646859d21c5")
     */
    protected ?string $characterId;

    /**
     * @return string
     */
    public function getCharacterId(): string
    {
        return (string)$this->characterId;
    }

    /**
     * @param string $characterId
     *
     * @return RefreshTokenRequest
     */
    public function setCharacterId(string $characterId): RefreshTokenRequest
    {
        $this->characterId = $characterId;

        return $this;
    }
}