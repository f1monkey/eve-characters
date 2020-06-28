<?php
declare(strict_types=1);

namespace App\Controller\V1;

use App\Dto\Api\V1\Request\AccessToken\GetRedirectUrlRequest;
use App\Dto\Api\V1\Request\AccessToken\RefreshTokenRequest;
use App\Dto\Api\V1\Request\AccessToken\VerifyCodeRequest;
use App\Dto\Api\V1\Response\AccessToken\AccessTokenResponse;
use App\Dto\Api\V1\Response\AccessToken\GetRedirectUrlResponse;
use App\Exception\Entity\EntityNotFoundException;
use App\Factory\Api\V1\AccessTokenResponseFactoryInterface;
use App\Service\Character\AccessTokenServiceInterface;
use F1monkey\EveEsiBundle\Exception\ApiClient\ApiClientExceptionInterface;
use F1monkey\EveEsiBundle\Exception\ApiClient\RequestValidationException;
use F1monkey\EveEsiBundle\Exception\Esi\EsiRequestException;
use F1monkey\EveEsiBundle\Exception\OAuth\EmptyScopeCollectionException;
use F1monkey\EveEsiBundle\Exception\OAuth\InvalidScopeCodeException;
use F1monkey\EveEsiBundle\Exception\OAuth\OAuthRequestException;
use F1Monkey\RequestHandleBundle\Dto\ErrorResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CharacterAddController
 *
 * @package App\Controller\V1
 *
 * @Route("access-tokens", name="access_tokens_")
 */
class AccessTokenController
{
    use ResponseSerializeTrait;

    /**
     * @var AccessTokenServiceInterface
     */
    protected AccessTokenServiceInterface $accessTokenService;

    /**
     * @var AccessTokenResponseFactoryInterface
     */
    protected AccessTokenResponseFactoryInterface $responseFactory;

    /**
     * AccessTokenController constructor.
     *
     * @param AccessTokenServiceInterface         $accessTokenService
     * @param AccessTokenResponseFactoryInterface $responseFactory
     */
    public function __construct(
        AccessTokenServiceInterface $accessTokenService,
        AccessTokenResponseFactoryInterface $responseFactory
    )
    {
        $this->accessTokenService = $accessTokenService;
        $this->responseFactory    = $responseFactory;
    }

    /**
     * Get URL to redirect user for authentication
     *
     * @Route("/redirect-url", name="get_redirect_url", methods={Request::METHOD_GET})
     *
     * @SWG\Parameter(
     *     in="header",
     *     name="Authorization",
     *     description="Authorization header",
     *     type="string",
     *     required=true
     * )
     * @SWG\Parameter(
     *     in="query",
     *     type="string",
     *     name="scopes",
     *     required=true,
     *     description="Required scopes, space separated"
     * )
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="URL to redirect user for authentication",
     *     @Model(type=GetRedirectUrlResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_BAD_REQUEST,
     *     description="Bad Request",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_UNAUTHORIZED,
     *     description="Unauthorized",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_INTERNAL_SERVER_ERROR,
     *     description="Internal server error",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Tag(name="access-tokens")
     *
     * @param GetRedirectUrlRequest $request
     *
     * @return JsonResponse
     * @throws EmptyScopeCollectionException
     * @throws InvalidScopeCodeException
     */
    public function getRedirectUrlAction(GetRedirectUrlRequest $request): JsonResponse
    {
        $url = $this->accessTokenService->getRedirectUrl($request->getScopes());

        return $this->createJsonResponse($this->responseFactory->createGetRedirectUrlResponse($url));
    }

    /**
     * Verify authentication code and add new character
     *
     * @Route("/verify-code", name="verify_code", methods={Request::METHOD_POST})
     *
     * @SWG\Parameter(
     *     in="header",
     *     name="Authorization",
     *     description="Authorization header",
     *     type="string",
     *     required=true
     * )
     * @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Auth code",
     *     @Model(type=VerifyCodeRequest::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="Access token",
     *     @Model(type=AccessTokenResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_BAD_REQUEST,
     *     description="Bad Request",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_UNAUTHORIZED,
     *     description="Unauthorized",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_INTERNAL_SERVER_ERROR,
     *     description="Internal server error",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Tag(name="access-tokens")
     *
     * @param UserInterface     $user
     * @param VerifyCodeRequest $request
     *
     * @return JsonResponse
     * @throws EsiRequestException
     * @throws ApiClientExceptionInterface
     * @throws RequestValidationException
     * @throws OAuthRequestException
     */
    public function verifyCodeAction(UserInterface $user, VerifyCodeRequest $request): JsonResponse
    {
        $result   = $this->accessTokenService->verifyCode($user, $request->getCode());
        $response = $this->responseFactory->createAccessTokenResponse($result);

        return $this->createJsonResponse($response);
    }

    /**
     * Refresh access token for character
     *
     * @Route("/refresh-token", name="refresh_token", methods={Request::METHOD_POST})
     *
     * @SWG\Parameter(
     *     in="header",
     *     name="Authorization",
     *     description="Authorization header",
     *     type="string",
     *     required=true
     * )
     * @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Request data",
     *     @Model(type=RefreshTokenRequest::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="Access token",
     *     @Model(type=AccessTokenResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_BAD_REQUEST,
     *     description="Bad Request",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_UNAUTHORIZED,
     *     description="Unauthorized",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_NOT_FOUND,
     *     description="Not found",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Response(
     *     response=Response::HTTP_INTERNAL_SERVER_ERROR,
     *     description="Internal server error",
     *     @Model(type=ErrorResponse::class)
     * )
     * @SWG\Tag(name="access-tokens")
     *
     * @param UserInterface       $user
     * @param RefreshTokenRequest $request
     *
     * @return JsonResponse
     * @throws ApiClientExceptionInterface
     * @throws OAuthRequestException
     * @throws RequestValidationException
     * @throws NotFoundHttpException
     */
    public function refreshTokenAction(UserInterface $user, RefreshTokenRequest $request): JsonResponse
    {
        try {
            $response = $this->accessTokenService->refreshToken($user, $request->getCharacterId());
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException('Character not found');
        }

        return $this->createJsonResponse($this->responseFactory->createAccessTokenResponse($response));
    }
}