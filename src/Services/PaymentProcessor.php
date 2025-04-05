<?php

namespace App\Services;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentProcessor
{
    public function processPayment(float $amount, string $processor): bool
    {
        try {
            switch ($processor) {
                case 'paypal':
                    (new PaypalPaymentProcessor())->pay($amount);
                    break;
                case 'stripe':
                    (new StripePaymentProcessor())->processPayment($amount);
                    break;
                default:
                    throw new \InvalidArgumentException('Unsupported payment processor');
            }
            return true;
        } catch (\Exception $e) {
            throw new \RuntimeException('Payment processing failed: ' . $e->getMessage());
        }
    }
}