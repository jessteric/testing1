<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseDto
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public int $product;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(DE|IT|GR|FR)[A-Z0-9]+$/',
        message: 'Invalid tax number'
    )]
    public string $taxNumber;

    #[Assert\Type('string')]
    public ?string $couponCode = null;

    #[Assert\NotBlank]
    #[Assert\Choice(['paypal', 'stripe'])]
    public string $paymentProcessor;
}