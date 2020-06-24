<?php
declare(strict_types=1);

namespace App\Factory\Api\V1;

use App\Dto\Api\V1\Response\CharacterAdd\GetRedirectUrlResponse;

/**
 * Class AccessTokenResponseFactory
 *
 * @package App\Factory\Api\V1
 */
class AccessTokenResponseFactory implements AccessTokenResponseFactoryInterface
{
    /**
     * @param string $url
     *
     * @return GetRedirectUrlResponse
     */
    public function createGetRedirectUrlResponse(string $url): GetRedirectUrlResponse
    {
        return new GetRedirectUrlResponse($url);
    }
}