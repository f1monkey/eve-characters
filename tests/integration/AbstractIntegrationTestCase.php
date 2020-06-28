<?php
declare(strict_types=1);

namespace App\Tests\integration;

use App\Service\Character\AccessTokenService;
use App\Tests\_support\Mocks\OAuthServiceMock;
use App\Tests\_support\Mocks\VerifyTokenServiceMock;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use IntegrationTester;

/**
 * Class AbstractIntegrationTestCase
 *
 * @package App\Tests\integration
 */
abstract class AbstractIntegrationTestCase extends Unit
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var OAuthServiceMock
     */
    protected OAuthServiceMock $oauthService;

    /**
     * @var VerifyTokenServiceMock
     */
    protected VerifyTokenServiceMock $verifyTokenService;

    /**
     * @var IntegrationTester
     */
    protected IntegrationTester $tester;

    final public function _before()
    {
        $this->em = $this->tester->grabService(EntityManagerInterface::class);
        /** @var AccessTokenService $service */
        $service = $this->tester->grabService('test.access_token_service');

        $this->oauthService       = new OAuthServiceMock();
        $this->verifyTokenService = new VerifyTokenServiceMock();

        $service->setOauthService($this->oauthService);
        $service->setVerifyTokenService($this->verifyTokenService);
        $this->doBefore();
    }

    protected function doBefore()
    {

    }
}