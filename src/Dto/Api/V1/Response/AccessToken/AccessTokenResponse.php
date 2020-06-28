<?php
declare(strict_types=1);

namespace App\Dto\Api\V1\Response\AccessToken;

use App\Dto\Api\V1\Response\Character\CharacterResponse;
use JMS\Serializer\Annotation as Serializer;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AccessTokenResponse
 *
 * @package App\Dto\Api\V1\Response\AccessToken
 */
class AccessTokenResponse
{
    /**
     * @var CharacterResponse
     *
     * @Serializer\SerializedName("character")
     * @Serializer\Type("App\Dto\Api\V1\Response\Character\CharacterResponse")
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property(title="Character", ref=@Model(type=CharacterResponse::class))
     */
    protected CharacterResponse $character;

    /**
     * @var string
     *
     * @Serializer\SerializedName("accessToken")
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property(title="Access token", type="string", example="1|CfDJ8Hj9X4L/huFJpslTkv3swZO3sAlMs0ZYjxY+2eVp3w/GSnl6w+WNFAFWTj0IkB5Lp38RqoqltPJuiwIS1jKxVWWzi39FDQ/Ym/x3IzyLgm9Nn0RAygwbCKwvuoFxKxXl1epSldF//A86kdqCrJMl2iLHTv0E7c1K6repHwQ2Bu/0")
     */
    protected string $accessToken;

    /**
     * AccessTokenResponse constructor.
     *
     * @param CharacterResponse $character
     * @param string            $accessToken
     */
    public function __construct(CharacterResponse $character, string $accessToken)
    {
        $this->character   = $character;
        $this->accessToken = $accessToken;
    }

    /**
     * @return CharacterResponse
     */
    public function getCharacter(): CharacterResponse
    {
        return $this->character;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}