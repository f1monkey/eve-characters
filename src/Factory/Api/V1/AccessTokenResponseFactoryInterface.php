<?php
declare(strict_types=1);

namespace App\Factory\Api\V1;

use App\Dto\Api\V1\Response\AccessToken\AccessTokenResponse;
use App\Dto\Api\V1\Response\AccessToken\GetRedirectUrlResponse;
use App\Entity\CharacterToken;

/**
 * Interface AccessTokenResponseFactoryInterface
 *
 * @package App\Factory\Api\V1
 */
interface AccessTokenResponseFactoryInterface
{
    /**
     * @param string $url
     *
     * @return GetRedirectUrlResponse
     */
    public function createGetRedirectUrlResponse(string $url): GetRedirectUrlResponse;

    /**
     * @param CharacterToken $characterToken
     *
     * @return AccessTokenResponse
     */
    public function createAccessTokenResponse(CharacterToken $characterToken): AccessTokenResponse;
}