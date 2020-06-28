<?php
declare(strict_types=1);

namespace App\Controller\V1;

use App\Dto\Api\V1\Response\Character\CharacterListResponse;
use App\Dto\Api\V1\Response\Character\CharacterResponse;
use App\Entity\CharacterToken;
use App\Enum\RegexEnum;
use App\Exception\Entity\EntityNotFoundException;
use App\Factory\Api\V1\CharacterResponseFactoryInterface;
use App\Service\Character\CharacterTokenManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
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
 * Class CharacterController
 *
 * @package App\Controller\V1
 *
 * @Route("/characters", name="characters_")
 */
class CharacterController
{
    use ResponseSerializeTrait;

    /**
     * @var CharacterTokenManagerInterface
     */
    protected CharacterTokenManagerInterface $characterTokenManager;

    /**
     * @var CharacterResponseFactoryInterface
     */
    protected CharacterResponseFactoryInterface $characterResponseFactory;

    /**
     * CharacterController constructor.
     *
     * @param CharacterTokenManagerInterface    $characterTokenManager
     * @param CharacterResponseFactoryInterface $characterResponseFactory
     */
    public function __construct(
        CharacterTokenManagerInterface $characterTokenManager,
        CharacterResponseFactoryInterface $characterResponseFactory
    )
    {
        $this->characterTokenManager    = $characterTokenManager;
        $this->characterResponseFactory = $characterResponseFactory;
    }

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
     * @param UserInterface $user
     *
     * @return JsonResponse
     */
    public function characterListAction(UserInterface $user): JsonResponse
    {
        $characters = new ArrayCollection();
        /** @var CharacterToken $characterToken */
        foreach ($this->characterTokenManager->getByUser($user) as $characterToken) {
            $characters->add($characterToken->getCharacter());
        }

        return $this->createJsonResponse(
            $this->characterResponseFactory->createCharacterListResponse($characters)
        );
    }

    /**
     * @Route("/{characterId}", name="get_by_id", methods={Request::METHOD_GET}, requirements={"id":RegexEnum::UUID_V4})
     *
     * @SWG\Parameter(
     *     in="header",
     *     name="Authorization",
     *     description="Authorization header",
     *     type="string",
     *     required=true
     * )
     * @SWG\Parameter(
     *     in="path",
     *     name="characterId",
     *     description="Character ID",
     *     type="string",
     *     required=true
     * )
     * @SWG\Response(
     *     response=Response::HTTP_OK,
     *     description="Character info",
     *     @Model(type=CharacterResponse::class)
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
     *
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
     * @SWG\Tag(name="characters")
     *
     * @param UserInterface $user
     * @param string        $characterId
     *
     * @return JsonResponse
     * @throws NotFoundHttpException
     */
    public function characterGetAction(UserInterface $user, string $characterId): JsonResponse
    {
        try {
            $characterToken = $this->characterTokenManager->getByUserAndCharacter($user, $characterId);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException(sprintf('Character #%s not found', $characterId));
        }

        return $this->createJsonResponse(
            $this->characterResponseFactory->createCharacterResponse($characterToken->getCharacter())
        );
    }
}