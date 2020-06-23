<?php
declare(strict_types=1);

namespace App\Controller\V1;

use App\Dto\Api\V1\Response\CharacterListResponse;
use F1Monkey\RequestHandleBundle\Dto\ErrorResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CharacterController
 *
 * @package App\Controller\V1
 *
 * @Route("/characters", name="characters_")
 */
class CharacterController
{
    /**
     * @Route("", name="list", methods={Request::METHOD_GET})
     *
     * @SWG\Parameter(
     *     in="header",
     *     name="Authorization",
     *     description="Authorization header",
     *     type="string",
     *     required=true
     * )
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="List of user characters",
     *     @Model(type=CharacterListResponse::class)
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
     * @SWG\Tag(name="characters")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function characterListAction(Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}