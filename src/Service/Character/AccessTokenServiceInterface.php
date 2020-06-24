<?php
declare(strict_types=1);

namespace App\Service\Character;

use Doctrine\Common\Collections\Collection;
use F1Monkey\EveEsiBundle\Dto\Scope;
use F1Monkey\EveEsiBundle\Exception\OAuth\EmptyScopeCollectionException;
use F1Monkey\EveEsiBundle\Exception\OAuth\InvalidScopeCodeException;

/**
 * Interface AccessTokenServiceInterface
 *
 * @package App\Service\Character
 */
interface AccessTokenServiceInterface
{
    /**
     * @param Collection<int, Scope> $scopes
     *
     * @return string
     * @throws EmptyScopeCollectionException
     * @throws InvalidScopeCodeException
     */
    public function getRedirectUrl(Collection $scopes): string;
}