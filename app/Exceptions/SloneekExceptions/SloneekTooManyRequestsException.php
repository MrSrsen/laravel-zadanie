<?php

namespace App\Exceptions\SloneekExceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SloneekTooManyRequestsException extends HttpException
{
    public function __construct(?string $message = null, ?\Throwable $previous = null)
    {
        parent::__construct(
            Response::HTTP_TOO_MANY_REQUESTS,
            $message ?? __('be.responses.tooManyRequests'),
            $previous
        );
    }
}
