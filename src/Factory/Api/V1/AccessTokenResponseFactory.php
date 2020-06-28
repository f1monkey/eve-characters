<?php
declare(strict_types=1);

namespace App\Factory\Api\V1;

use App\Dto\Api\V1\Response\AccessToken\AccessTokenResponse;
use App\Dto\Api\V1\Response\AccessToken\GetRedirectUrlResponse;
use App\Entity\CharacterToken;

/**
 * Class AccessTokenResponseFactory
 *
 * @package App\Factory\Api\V1
 */
class AccessTokenResponseFactory implements AccessTokenResponseFactoryInterface
{
    /**
     * @var CharacterResponseFactoryInterface
     */
    protected CharacterResponseFactoryInterface $characterResponseFactory;

    /**
     * AccessTokenResponseFactory constructor.
     *
     * @param CharacterResponseFactoryInterface $characterResponseFactory
     */
    public function __construct(CharacterResponseFactoryInterface $characterResponseFactory)
    {
        $this->characterResponseFactory = $characterResponseFactory;
    }

    /**
     * @param string $url
     *
     * @return GetRedirectUrlResponse
     */
    public function createGetRedirectUrlResponse(string $url): GetRedirectUrlResponse
    {
        return new GetRedirectUrlResponse($url);
    }

    /**
     * @param CharacterToken $characterToken
     *
     * @return AccessTokenResponse
     */
    public function createAccessTokenResponse(CharacterToken $characterToken): AccessTokenResponse
    {
        $character = $this->characterResponseFactory->createCharacterResponse(
            $characterToken->getCharacter()
        );

        return new AccessTokenResponse($character, $characterToken->getAccessToken());
    }
}