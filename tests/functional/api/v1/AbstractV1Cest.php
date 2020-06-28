<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1;

use App\Service\Character\AccessTokenService;
use App\Tests\_support\Mocks\OAuthServiceMock;
use App\Tests\_support\Mocks\VerifyTokenServiceMock;

abstract class AbstractV1Cest
{
    public function _before(\FunctionalTester $I)
    {
        /** @var AccessTokenService $service */
        $service = $I->grabService('test.access_token_service');
        $service->setOauthService(new OAuthServiceMock());
        $service->setVerifyTokenService(new VerifyTokenServiceMock());
    }
}