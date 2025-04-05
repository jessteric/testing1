<?php

namespace App\Services;

use App\Entity\Coupon;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;

class PriceCalculator
{
    private const TAX_RATES = [
        'DE' => 0.19,
        'IT' => 0.22,
        'FR' => 0.20,
        'GR' => 0.24,
    ];

    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly CouponRepository $couponRepository
    ) {
    }

    /**
     * @param int $productId
     * @param string $taxNumber
     * @param string|null $couponCode
     * @return float
     */
    public function calculate(int $productId, string $taxNumber, ?string $couponCode = null): float
    {
        $product = $this->productRepository->find($productId);
        if (!$product) {
            throw new \InvalidArgumentException('Product not found');
        }

        $price = $product->getPrice();

        if ($couponCode) {
            $coupon = $this->couponRepository->findOneBy(['code' => $couponCode]);
            if (!$coupon) {
                throw new \InvalidArgumentException('Invalid coupon code');
            }

            $price = $this->applyCoupon($price, $coupon);
        }

        return $this->applyTax($price, $taxNumber);
    }

    /**
     * @param float $price
     * @param Coupon $coupon
     * @return float
     */
    private function applyCoupon(float $price, Coupon $coupon): float
    {
        return match ($coupon->getType()) {
            'percentage' => $price * (1 - $coupon->getValue() / 100),
            'fixed' => max(0, $price - $coupon->getValue()),
            default => throw new \InvalidArgumentException('Invalid type'),
        };
    }

    /**
     * @param float $price
     * @param string $taxNumber
     * @return float
     */
    private function applyTax(float $price, string $taxNumber): float
    {
        $countryCode = substr($taxNumber, 0, 2);

        if (!isset(self::TAX_RATES[$countryCode])) {
            throw new \InvalidArgumentException('Unsupported rate');
        }

        return round($price * (1 + self::TAX_RATES[$countryCode]), 2);
    }
}