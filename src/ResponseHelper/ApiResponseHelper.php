<?php

namespace Bugloos\ResponderBundle\ResponseHelper;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;



/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 *
 * @method json($data, int $status = 200, array $headers = [], array $context = [])
 */
trait ApiResponseHelper
{
    private int $statusCode;

    protected function respondWithSuccessMessage(
        $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respondWithMessage($message, $headers);
    }

    protected function respondWithItem(
        $item,
        array $groups = [],
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond($item, $groups, $headers);
    }

    protected function respondWithCollection(
        $collection,
        array $groups = [],
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond($collection, $groups, $headers);
    }

    protected function respondWithPagination(
        $pagination,
        array $groups = [],
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond($pagination, $groups, $headers);
    }

    protected function respondItemCreated(
        string $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respondWithMessage($message, $headers);
    }

    protected function respondItemUpdated(
        $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respondWithMessage($message, $headers);
    }

    protected function respondItemDeleted(
        string $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respondWithMessage($message, $headers);
    }

    protected function respondNoContent(array $headers = []): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_NO_CONTENT)
            ->respond([], $headers, []);
    }

    protected function respondForbiddenError(
        $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)
            ->respondWithMessage($message, $headers);
    }

    protected function respondNotFoundError(
        $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)
            ->respondWithMessage($message, $headers);
    }

    protected function respondUnauthorizedError(
        $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)
            ->respondWithMessage($message, $headers);
    }

    private function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    private function getStatusCode(): string
    {
        return $this->statusCode;
    }

    private function respond($data, array $groups, array $headers): JsonResponse
    {
        return $this->json(
            $data,
            $this->getStatusCode(),
            $headers,
            ['groups' => $groups]
        );
    }

    private function respondWithMessage(string $message, array $headers = []): JsonResponse
    {
        return $this->respond([
            'message' => $message,
        ], $headers, []);
    }
}
