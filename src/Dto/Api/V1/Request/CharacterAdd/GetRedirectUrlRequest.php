<?php
declare(strict_types=1);

namespace App\Dto\Api\V1\Request\CharacterAdd;

use App\Dto\Api\RequestInterface;
use Doctrine\Common\Collections\Collection;
use F1Monkey\EveEsiBundle\Dto\Scope;
use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class GetRedirectUrlRequest
 *
 * @package App\Dto\Api\V1\Request\CharacterAdd
 */
class GetRedirectUrlRequest implements RequestInterface
{
    /**
     * @var Collection<int, Scope>
     *
     * @Serializer\SerializedName("scopes")
     * @Serializer\Type("eve_esi_scopes")
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property(type="string", required="true", example="publicData esi-skills.read_skills.v1", title="Required scopes")
     */
    protected Collection $scopes;

    /**
     * @return Collection<int, Scope>
     */
    public function getScopes(): Collection
    {
        return $this->scopes;
    }

    /**
     * @param Collection<int, Scope> $scopes
     *
     * @return GetRedirectUrlRequest
     */
    public function setScopes(Collection $scopes): GetRedirectUrlRequest
    {
        $this->scopes = $scopes;

        return $this;
    }
}