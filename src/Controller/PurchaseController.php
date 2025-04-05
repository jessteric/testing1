<?php

namespace App\Controller;

use App\Services\PurchaseService;
use App\Services\Response\ResponseData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    public function purchase(
        Request $request,
        PurchaseService $purchaseService
    ): JsonResponse {
        try {
            $result = $purchaseService->processPurchase(
                json_decode($request->getContent(), true)
            );
            return ResponseData::createSuccessResponse($result);
        } catch (\InvalidArgumentException|\RuntimeException $e) {
            return ResponseData::createErrorResponse($e->getMessage());
        }
    }
}