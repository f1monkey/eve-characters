<?php
declare(strict_types=1);

namespace App\Dto\Api\V1\Request\AccessToken;

use App\Dto\Api\RequestInterface;
use JMS\Serializer\Annotation as Serializer;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class VerifyCodeRequest
 *
 * @package App\Dto\Api\V1\Request\AccessToken
 */
class VerifyCodeRequest implements RequestInterface
{
    /**
     * @var string
     *
     * @Serializer\SerializedName("code")
     * @Serializer\Type("string")
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property(title="Authorization code", example="1N1paSoXHWzTtNBdOKR4cas8S7QurT7v12ODSsRzV7O-PiMji9CHoOkCa9oLCkfb", type="string")
     */
    protected ?string $code = '';

    /**
     * @return string
     */
    public function getCode(): string
    {
        return (string)$this->code;
    }

    /**
     * @param string $code
     *
     * @return VerifyCodeRequest
     */
    public function setCode(string $code): VerifyCodeRequest
    {
        $this->code = $code;

        return $this;
    }
}