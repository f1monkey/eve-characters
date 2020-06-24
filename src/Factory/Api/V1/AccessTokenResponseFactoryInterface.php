<?php
declare(strict_types=1);

namespace App\Factory\Api\V1;

use App\Dto\Api\V1\Response\CharacterAdd\GetRedirectUrlResponse;

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
}