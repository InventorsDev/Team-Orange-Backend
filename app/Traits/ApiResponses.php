<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

trait ApiResponses
{
    /**
     * Set the server error response.
     *
     * @param $message
     * @param \Exception|null $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function serverErrorAlert($message, Throwable $exception = null): JsonResponse
    {
        if (null !== $exception) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
        }

        $response = [
            'statusCode' => config('mentalhealth.status_codes.server_error'),
            'statusText' => config('mentalhealth.status_texts.server_error'),
            'message' => $message,
        ];

        if (!is_null($exception)) {
            $response['exception'] = $exception->getMessage();
        }

        return Response::json($response, config('mentalhealth.status_codes.server_error'));
    }

    /**
     * Set the form validation error response.
     *
     * @param $errors
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function formValidationErrorAlert($errors, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.validation_failed'),
            'statusText' => config('mentalhealth.status_texts.validation_failed'),
            'message' => 'Whoops. Validation failed.',
            'validationErrors' => $errors,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.validation_failed'));
    }

    /**
     * Set the "not found" error response.
     *
     * @param $message
     * @param string $statusText
     * @param null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFoundAlert($message, $statusText = 'not_found', $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.not_found'),
            'statusText' => $statusText,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.not_found'));
    }

    /**
     * Set the "validation" error response.
     *
     * @param $message
     * @param null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validationErrorAlert($message, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.validation_failed'),
            'statusText' => config('mentalhealth.status_texts.validation_failed'),
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.validation_failed'));
    }

    /**
     * Set bad request error response.
     *
     * @param $message
     * @param string $statusText
     * @param null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function badRequestAlert($message, $statusText = 'bad_request', $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.bad_request'),
            'statusText' => $statusText,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.bad_request'));
    }

    /**
     * Set the success response alert.
     *
     * @param $message
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($message, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.success'),
            'statusText' => config('mentalhealth.status_texts.success'),
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.success'));
    }

    /**
     * Set the created resource response alert.
     *
     * @param $message
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createdResponse($message, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.created'),
            'statusText' => config('mentalhealth.status_texts.created'),
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.created'));
    }

    /**
     * Set forbidden request error response.
     *
     * @param $message
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbiddenRequestAlert($message, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.forbidden'),
            'statusText' => config('mentalhealth.status_texts.forbidden'),
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.forbidden'));
    }

    /**
     * Set the server error response.
     *
     * @param $message
     * @param HttpException $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function httpErrorAlert($message, HttpException $exception = null): JsonResponse
    {
        if (null !== $exception) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
        }

        $response = [
            'statusCode' => $exception->getStatusCode(),
            'statusText' => 'http_error',
            'message' => $message,
        ];

        if (null !== $exception) {
            $response['exception'] = $exception->getMessage();
        }

        return Response::json($response, $exception->getStatusCode());
    }

    /**
     * Set unauthorised request error response.
     *
     * @param $message
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unauthorisedRequestAlert($message, $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.unauthorised'),
            'statusText' => config('mentalhealth.status_texts.unauthorised'),
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.unauthorised'));
    }

    /**
     * Set the conflicted request response.
     *
     * @param $message
     * @param string $statusText
     * @param null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function conflictedRequestAlert($message, $statusText = 'conflicted', $data = null): JsonResponse
    {
        $response = [
            'statusCode' => config('mentalhealth.status_codes.conflicted'),
            'statusText' => $statusText,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('mentalhealth.status_codes.conflicted'));
    }
}