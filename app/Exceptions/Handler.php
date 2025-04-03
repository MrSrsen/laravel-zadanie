<?php

namespace App\Exceptions;

use Doctrine\DBAL\Exception\ServerException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Exceptions\BackedEnumCaseNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    public function render($request, \Throwable $e): Response
    {
        if ($e instanceof BackedEnumCaseNotFoundException) {
            throw new BadRequestHttpException(message: $e->getMessage(), previous: $e);
        }

        if ($e instanceof ThrottleRequestsException) {
            throw new BadRequestHttpException(message: $e->getMessage(), previous: $e);
        }

        if ($e instanceof AuthorizationException) {
            throw new AccessDeniedHttpException(message: $e->getMessage(), previous: $e);
        }

        if ($e instanceof AuthenticationException) {
            throw new AccessDeniedHttpException(message: $e->getMessage(), previous: $e);
        }

        if ($e instanceof ServerException) {
            throw new HttpException(statusCode: 500, message: $e->getMessage(), previous: $e);
        }

        if (!method_exists($e, 'render')) {
            $handler = new JsonResponseHandler();

            return $handler->handle($e);
        }

        return parent::render($request, $e);
    }
}
