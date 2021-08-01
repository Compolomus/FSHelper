<?php

declare(strict_types=1);

namespace Compolomus\FSHelper\Exceptions;

use RuntimeException;

class PathNotFoundException extends RuntimeException
{
    public function __construct(string $message = '')
    {
        $notice = 'Provided path does not exists';
        parent::__construct(
            !empty($message)
                ? $notice . ': ' . $message
                : $notice
        );
    }
}
