<?php

namespace App\Controller;

use App\Services\PriceService;
use App\Services\Response\ResponseData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends AbstractController
{
    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function calculatePrice(
        Request $request,
        PriceService $priceService
    ): JsonResponse {
        try {
            $result = $priceService->calculatePrice(
                json_decode($request->getContent(), true)
            );
            return ResponseData::createSuccessResponse($result);
        } catch (\InvalidArgumentException $e) {
            return ResponseData::createErrorResponse($e->getMessage());
        }
    }
}