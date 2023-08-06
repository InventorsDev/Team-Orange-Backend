<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponses;
use App\Exceptions\NotFoundException;
use Psy\Exception\FatalErrorException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Handler extends ExceptionHandler
{
    use ApiResponses;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        BadRequestException::class,
        NotFoundException::class,
        UnauthorizedException::class,
        RouteNotFoundException::class
    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $exception, $request) {
            return $this->handleException($exception, $request);
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function handleException(Throwable $exception, $request)
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->notFoundAlert('We cannot access this resource you\'re looking for', 'resource_not_found');
        }

        if ($exception instanceof UnauthorizedException) {
            return $this->unauthorisedRequestAlert($exception->getMessage());
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->notFoundAlert('Unable to locate model resource', 'model_not_found');
        }

        if ($exception instanceof NotFoundException) {
            return $this->notFoundAlert($exception->getMessage());
        }

        if ($exception instanceof BadRequestException) {
            return $this->badRequestAlert($exception->getMessage());
        }

        if ($exception instanceof HttpException) {
            return $this->httpErrorAlert($exception->getMessage(), $exception);
        }

        if ($exception instanceof FatalErrorException) {
            return $this->serverErrorAlert('An error occurred processing your request, Try again later... ', $exception);
        }

        if ($exception instanceof ValidationException) {
            return $this->formValidationErrorAlert($exception->errors());
        }

        if ($exception instanceof RouteNotFoundException) {
            return $this->unauthorisedRequestAlert("Unauthenticated");
        }
    }
}
