<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AffiliateException extends HttpException
{
	public function __construct($message = null, \Throwable $previous = null, array $headers = [], $code = 0)
	{
		parent::__construct(403, $message, $previous, $headers, $code);
	}

    public static function tamperedRequest(): static
    {
        return new static(
            'Invalid affiliate request and/or tampered request. Try again later by opening the affiliate URL you were provided.'
        );
    }

    public static function referrerDoesNotExist(): static
    {
        return new static(
            'User who referred you to the system, does not exist.'
        );
    }
}
