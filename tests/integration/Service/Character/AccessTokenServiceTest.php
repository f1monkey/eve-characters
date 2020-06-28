<?php
declare(strict_types=1);

namespace App\Tests\integration\Service\Character;

use App\Exception\Entity\EntityNotFoundException;
use App\Service\Character\AccessTokenService;
use App\Tests\integration\AbstractIntegrationTestCase;
use Exception;
use F1monkey\EveEsiBundle\Exception\ApiClient\ApiClientExceptionInterface;
use F1monkey\EveEsiBundle\Exception\ApiClient\RequestValidationException;
use F1monkey\EveEsiBundle\Exception\Esi\EsiRequestException;
use F1monkey\EveEsiBundle\Exception\OAuth\OAuthRequestException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AccessTokenServiceTest
 *
 * @package App\Tests\integration\Service\Character
 */
class AccessTokenServiceTest extends AbstractIntegrationTestCase
{
    /**
     * @throws ApiClientExceptionInterface
     * @throws EsiRequestException
     * @throws OAuthRequestException
     * @throws RequestValidationException
     * @throws Exception
     */
    public function testCanCreateNewCharacterOnVerifyCode()
    {
        $characterId = 1234;
        $response    = $this->verifyTokenService->generateResponse();
        $response->setCharacterId($characterId);
        $this->verifyTokenService->setResponse($response);

        $username = 'user';

        /** @var UserInterface $user */
        $user = $this->makeEmpty(UserInterface::class, ['getUsername' => $username]);

        /** @var AccessTokenService $service */
        $service = $this->tester->grabService('test.access_token_service');
        $service->verifyCode($user, 'code');

        $this->tester->canSeeInDatabase('character_token', ['username' => $username]);
        $this->tester->canSeeInDatabase('character', ['eve_character_id' => $characterId]);
    }

    /**
     * @throws ApiClientExceptionInterface
     * @throws RequestValidationException
     * @throws EsiRequestException
     * @throws OAuthRequestException
     * @throws Exception
     */
    public function testCanUpdateCharacterOnVerifyCode()
    {
        $characterId = 1234;
        $oldName     = 'oldname';
        $newName     = 'newName';

        $character = $this->tester->createCharacter($characterId, $oldName);
        $this->tester->haveInRepository($character);

        $response = $this->verifyTokenService->generateResponse();
        $response->setCharacterId($characterId)
                 ->setCharacterName($newName);
        $this->verifyTokenService->setResponse($response);

        $username = 'user';

        /** @var UserInterface $user */
        $user = $this->makeEmpty(UserInterface::class, ['getUsername' => $username]);

        /** @var AccessTokenService $service */
        $service = $this->tester->grabService('test.access_token_service');
        $service->verifyCode($user, 'code');

        $this->tester->canSeeInDatabase('character_token', ['username' => $username]);
        $this->tester->canSeeInDatabase(
            'character',
            ['eve_character_id' => $characterId, 'eve_character_name' => $newName]
        );
    }

    /**
     * @throws ApiClientExceptionInterface
     * @throws OAuthRequestException
     * @throws RequestValidationException
     * @throws EntityNotFoundException
     */
    public function testCanUpdateRefreshToken()
    {
        $oldAccessToken = 'oldAccessToken';
        $newAccessToken = 'newAccessToken';

        $response = $this->oauthService->generateResponse();
        $response->setAccessToken($newAccessToken);
        $this->oauthService->setResponse($response);

        $username = 'user';
        $character = $this->tester->createCharacter();
        $this->tester->haveInRepository($character);
        $characterToken = $this->tester->createCharacterToken($character, $username, $oldAccessToken);
        $this->tester->haveInRepository($characterToken);
        /** @var UserInterface $user */
        $user = $this->makeEmpty(UserInterface::class, ['getUsername' => $username]);

        /** @var AccessTokenService $service */
        $service = $this->tester->grabService('test.access_token_service');
        $service->refreshToken($user, $character->getId());

        $this->tester->canSeeInDatabase('character_token', [
            'username' => $username,
            'access_token' => $newAccessToken
        ]);
    }
}