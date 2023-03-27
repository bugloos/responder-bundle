<?php

namespace Bugloos\ResponderBundle\ResponseHelper;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mojtaba Gheytasi <mjgheytasi@gmail.com>
 */
trait ApiResponseHelper
{
    private int $statusCode;

    protected function respondDeleted(
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
        string $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)
            ->respondWithMessage($message, $headers);
    }

    protected function respondNotFoundError(
        string $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)
            ->respondWithMessage($message, $headers);
    }

    protected function respondUnauthorizedError(
        string $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)
            ->respondWithMessage($message, $headers);
    }

    protected function respondWithSuccessMessage(
        string $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respondWithMessage($message, $headers);
    }

    /** new functions - start */

    protected function respondWithSucess(
        array|object $data,
        array $groups= [],
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_OK)
            ->respond($data, $groups, $headers);
    }

    protected function respondCreated(
        array|object $data,
        array $groups= [],
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respond($data, $groups, $headers);
    }

    protected function respondCreatedMessage(
        string $message,
        array $headers = []
    ): JsonResponse {
        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respondWithMessage($message, $headers);
    }

    /**
     * @deprecated since Responder Bundle v1.0.0, use respondWithSucess() instead
     */
    protected function respondWithItem(
        $item,
        array $groups = [],
        array $headers = []
    ): JsonResponse {

        trigger_deprecation('bugloos/responder-bundle', '1.0.0', 'The "%s()" method is deprecated, use "respondWithSucess()" instead.', __METHOD__);

        return $this->setStatusCode(Response::HTTP_OK)
            ->respond($item, $groups, $headers);
    }

    /**
     * @deprecated since Responder Bundle v1.0.0, use respondWithSucess() instead
     */
    protected function respondWithCollection(
        $collection,
        array $groups = [],
        array $headers = []
    ): JsonResponse {

        trigger_deprecation('bugloos/responder-bundle', '1.0.0', 'The "%s()" method is deprecated, use "respondWithSucess()" instead.', __METHOD__);

        return $this->setStatusCode(Response::HTTP_OK)
            ->respond($collection, $groups, $headers);
    }

    /**
     * @deprecated since Responder Bundle v1.0.0, use respondWithSucess() instead
     */
    protected function respondWithPagination(
        $pagination,
        array $groups = [],
        array $headers = []
    ): JsonResponse {

        trigger_deprecation('bugloos/responder-bundle', '1.0.0', 'The "%s()" method is deprecated, use "respondWithSucess()" instead.', __METHOD__);

        return $this->setStatusCode(Response::HTTP_OK)
            ->respond($pagination, $groups, $headers);
    }

    /**
     * @deprecated since Responder Bundle v1.0.0, use respondWithSucessMessage() instead
     */
    protected function respondItemUpdated(
        $message,
        array $headers = []
    ): JsonResponse {

        trigger_deprecation('bugloos/responder-bundle', '1.0.0', 'The "%s()" method is deprecated, use "respondWithSucessMessage()" instead.', __METHOD__);

        return $this->setStatusCode(Response::HTTP_OK)
            ->respondWithMessage($message, $headers);
    }


    /**
     * @deprecated since Responder Bundle v1.0.0, use respondCreated() OR respondCreatedMessage() instead
     */
    protected function respondItemCreated(
        string $message,
        array $headers = []
    ): JsonResponse {

        trigger_deprecation('bugloos/responder-bundle', '1.0.0', 'The "%s()" method is deprecated, use "respondCreated()" OR "respondCreatedMessage()" instead.', __METHOD__);

        return $this->setStatusCode(Response::HTTP_CREATED)
            ->respondWithMessage($message, $headers);
    }

    /**
     * @deprecated since Responder Bundle v1.0.0, use respondDeleted() instead
     */
    protected function respondItemDeleted(
        string $message,
        array $headers = []
    ): JsonResponse {

        trigger_deprecation('bugloos/responder-bundle', '1.0.0', 'The "%s()" method is deprecated, use "respondDeleted()" instead.', __METHOD__);

        return $this->setStatusCode(Response::HTTP_OK)
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
