<?php
declare(strict_types=1);

namespace App\Dto\Api\V1\Response\CharacterAdd;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class GetRedirectUrlResponse
 *
 * @package App\Dto\Api\V1\Response\CharacterAdd
 */
class GetRedirectUrlResponse
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("redirectUrl")
     * @Serializer\Type("string")
     */
    protected string $redirectUrl;

    /**
     * GetRedirectUrlResponse constructor.
     *
     * @param string $redirectUrl
     */
    public function __construct(string $redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }
}