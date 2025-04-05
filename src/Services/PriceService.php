<?php

namespace App\Services;

use App\DTO\CalculatePriceDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PriceService
{
    /**
     * @param PriceCalculator $priceCalculator
     * @param ValidatorInterface $validator
     */
    public function __construct(
        private readonly PriceCalculator $priceCalculator,
        private readonly ValidatorInterface $validator
    ) {}

    /**
     * @param array $requestData
     * @return array
     */
    public function calculatePrice(array $requestData): array
    {
        $dto = new CalculatePriceDTO();
        $dto->product = $requestData['product'] ?? null;
        $dto->taxNumber = $requestData['taxNumber'] ?? null;
        $dto->couponCode = $requestData['couponCode'] ?? null;

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException('Validation failed');
        }

        $price = $this->priceCalculator->calculate(
            $dto->product,
            $dto->taxNumber,
            $dto->couponCode
        );

        return [
            'price' => $price
        ];
    }
}