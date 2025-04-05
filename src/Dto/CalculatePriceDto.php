<?php
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceDto
{
    #[Assert\NotBlank(message: "Product ID is required")]
    #[Assert\Type(type: 'integer', message: "Product ID must be an integer")]
    #[Assert\Positive(message: "Product ID must be a positive number")]
    public int $product;

    #[Assert\NotBlank(message: "Tax number is required")]
    #[Assert\Regex(
        pattern: '/^(DE\d{9}|IT\d{11}|GR\d{9}|FR[A-Z]{2}\d{9})$/',
        message: "Invalid tax number format. Valid formats: DE123456789, IT12345678900, GR123456789, FRAB123456789"
    )]
    public string $taxNumber;

    #[Assert\Length(max: 20, maxMessage: "Coupon code must be less than {{ limit }}")]
    public ?string $couponCode = null;
}