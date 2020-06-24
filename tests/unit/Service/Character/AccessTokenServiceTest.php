<?php
declare(strict_types=1);

namespace App\Tests\unit\Service\Character;

use App\Service\Character\AccessTokenService;
use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use F1Monkey\EveEsiBundle\Exception\OAuth\EmptyScopeCollectionException;
use F1Monkey\EveEsiBundle\Exception\OAuth\InvalidScopeCodeException;
use F1Monkey\EveEsiBundle\Service\OAuth\OAuthServiceInterface;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Class AccessTokenServiceTest
 *
 * @package App\Tests\unit\Service\Character
 */
class AccessTokenServiceTest extends Unit
{
    /**
     * @throws EmptyScopeCollectionException
     * @throws InvalidScopeCodeException
     * @throws ExpectationFailedException
     */
    public function testCanGetRedirectUrl()
    {
        $expected = 'url';

        /** @var OAuthServiceInterface $oauthService */
        $oauthService = $this->makeEmpty(OAuthServiceInterface::class, [
            'createRedirectUrl' => $expected
        ]);

        $service = new AccessTokenService($oauthService);
        $result = $service->getRedirectUrl(new ArrayCollection());

        static::assertSame($expected, $result);
    }
}