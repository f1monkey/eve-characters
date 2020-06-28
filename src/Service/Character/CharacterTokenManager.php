<?php
declare(strict_types=1);

namespace App\Service\Character;

use App\Entity\CharacterToken;
use App\Exception\Entity\EntityNotFoundException;
use App\Factory\Character\CharacterTokenFactoryInterface;
use App\Repository\CharacterTokenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use F1monkey\EveEsiBundle\Dto\Esi\Response\VerifyAccessTokenResponse;
use F1monkey\EveEsiBundle\Dto\OAuth\Response\TokenResponse;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CharacterTokenManager
 *
 * @package App\Service\Character
 */
class CharacterTokenManager implements CharacterTokenManagerInterface
{
    /**
     * @var CharacterTokenFactoryInterface
     */
    protected CharacterTokenFactoryInterface $characterTokenFactory;

    /**
     * @var CharacterTokenRepository
     */
    protected CharacterTokenRepository $repository;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * CharacterTokenManager constructor.
     *
     * @param CharacterTokenFactoryInterface $characterTokenFactory
     * @param CharacterTokenRepository       $repository
     * @param EntityManagerInterface         $em
     */
    public function __construct(
        CharacterTokenFactoryInterface $characterTokenFactory,
        CharacterTokenRepository $repository,
        EntityManagerInterface $em
    )
    {
        $this->characterTokenFactory = $characterTokenFactory;
        $this->repository            = $repository;
        $this->em                    = $em;
    }

    /**
     * @param UserInterface             $user
     * @param TokenResponse             $tokenResponse
     * @param VerifyAccessTokenResponse $accessTokenResponse
     *
     * @return CharacterToken
     * @throws NonUniqueResultException
     */
    public function createFromEsiData(
        UserInterface $user,
        TokenResponse $tokenResponse,
        VerifyAccessTokenResponse $accessTokenResponse
    ): CharacterToken
    {
        try {
            $characterToken = $this->getByUserAndEveCharacterId(
                $user,
                $accessTokenResponse->getCharacterId()
            );
            $this->characterTokenFactory->fillFromEsiData($characterToken, $tokenResponse, $accessTokenResponse);
        } catch (EntityNotFoundException $e) {
            $characterToken = $this->characterTokenFactory->createFromEsiData(
                $user,
                $tokenResponse,
                $accessTokenResponse
            );
        }

        $this->save($characterToken);

        return $characterToken;
    }

    /**
     * @param UserInterface $user
     *
     * @return Collection<int, CharacterToken>
     */
    public function getByUser(UserInterface $user): Collection
    {
        return new ArrayCollection(
            $this->repository->findByUsername($user->getUsername())
        );
    }

    /**
     * @param UserInterface $user
     * @param string        $characterId
     *
     * @return CharacterToken
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    public function getByUserAndCharacter(UserInterface $user, string $characterId): CharacterToken
    {
        $result = $this->repository->findOneByUsernameAndCharacterId($user->getUsername(), $characterId);
        if ($result === null) {
            throw new EntityNotFoundException(
                sprintf('Tokens not found for user "%s" and character #%s', $user->getUsername(), $characterId)
            );
        }

        return $result;
    }

    /**
     * @param UserInterface $user
     * @param int           $eveCharacterId
     *
     * @return CharacterToken
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    public function getByUserAndEveCharacterId(UserInterface $user, int $eveCharacterId): CharacterToken
    {
        $result = $this->repository->findOneByUsernameAndEveCharacterId($user->getUsername(), $eveCharacterId);
        if ($result === null) {
            throw new EntityNotFoundException(
                sprintf('Tokens not found for user "%s" and character #%s', $user->getUsername(), $eveCharacterId)
            );
        }

        return $result;
    }

    /**
     * @param CharacterToken $characterToken
     */
    public function save(CharacterToken $characterToken): void
    {
        $this->em->persist($characterToken);
        $this->em->flush();
    }

    /**
     * @param CharacterToken $characterToken
     */
    public function delete(CharacterToken $characterToken): void
    {
        $this->em->remove($characterToken);
        $this->em->flush();
    }
}