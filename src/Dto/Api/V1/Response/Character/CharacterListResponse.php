<?php
declare(strict_types=1);

namespace App\Dto\Api\V1\Response\Character;

use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

/**
 * Class CharacterListResponse
 *
 * @package App\Dto\Api\V1\Response\Character
 */
class CharacterListResponse
{
    /**
     * @var Collection<int, CharacterResponse>
     *
     * @Serializer\SerializedName("items")
     * @Serializer\Type("ArrayCollection<App\Dto\Api\V1\Response\Character\CharacterResponse>")
     *
     * @SWG\Property(title="Characters", type="array",  @SWG\Items(ref=@Model(type=CharacterResponse::class)))
     */
    protected Collection $items;

    /**
     * CharacterListResponse constructor.
     *
     * @param Collection<int, CharacterResponse> $items
     */
    public function __construct(Collection $items)
    {
        $this->items = $items;
    }

    /**
     * @return Collection<int, CharacterResponse>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }
}