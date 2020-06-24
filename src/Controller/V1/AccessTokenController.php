<?php
declare(strict_types=1);

namespace App\Controller\V1;

use App\Dto\Api\V1\Request\CharacterAdd\GetRedirectUrlRequest;
use App\Dto\Api\V1\Response\CharacterAdd\GetRedirectUrlResponse;
use App\Factory\Api\V1\AccessTokenResponseFactoryInterface;
use App\Service\Character\AccessTokenServiceInterface;
use F1Monkey\EveEsiBundle\Exception\OAuth\EmptyScopeCollectionException;
use F1Monkey\EveEsiBundle\Exception\OAuth\InvalidScopeCodeException;
use F1Monkey\RequestHandleBundle\Dto\ErrorResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function getRedirectUrl(GetRedirectUrlRequest $request): JsonResponse
    {
        $url = $this->accessTokenService->getRedirectUrl($request->getScopes());

        return $this->createJsonResponse($this->responseFactory->createGetRedirectUrlResponse($url));
    }
}