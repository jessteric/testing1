<?php

namespace App\Services;

use App\Dto\PurchaseDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseService
{
    public function __construct(
        private readonly PriceCalculator    $priceCalculator,
        private readonly PaymentProcessor   $paymentProcessor,
        private readonly ValidatorInterface $validator
    ) {}

    /**
     * @param array $requestData
     * @return array
     */
    public function processPurchase(array $requestData): array
    {
        $dto = new PurchaseDTO();
        $dto->product = $requestData['product'] ?? null;
        $dto->taxNumber = $requestData['taxNumber'] ?? null;
        $dto->couponCode = $requestData['couponCode'] ?? null;
        $dto->paymentProcessor = $requestData['paymentProcessor'] ?? null;

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new \InvalidArgumentException('Validation failed');
        }

        $price = $this->priceCalculator->calculate(
            $dto->product,
            $dto->taxNumber,
            $dto->couponCode
        );

        $this->paymentProcessor->processPayment($price, $dto->paymentProcessor);

        return [
            'price' => $price,
            'product_id' => $dto->product,
            'status' => 'success'
        ];
    }
}