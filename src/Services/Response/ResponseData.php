<?php

namespace App\Services\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ResponseData
{
    /**
     * @param array $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function createSuccessResponse(array $data = [], int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(array_merge(['success' => true], $data), $statusCode);
    }

    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function createErrorResponse(string $message, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse([
            'success' => false,
            'error' => $message
        ], $statusCode);
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @return JsonResponse
     */
    public static function createValidationErrorResponse(ConstraintViolationListInterface $errors): JsonResponse
    {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[$error->getPropertyPath()] = $error->getMessage();
        }

        return new JsonResponse([
            'success' => false,
            'errors' => $errorMessages
        ], Response::HTTP_BAD_REQUEST);
    }
}