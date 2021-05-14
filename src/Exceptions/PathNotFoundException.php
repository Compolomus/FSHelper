<?php

namespace Compolomus\FSHelper\Exceptions;

use RuntimeException;

class PathNotFoundException extends RuntimeException
{
    protected $message = 'Provided path does not exists';

    public function __construct($message = "")
    {
        $message =
            !empty($message)
                ? $this->message . ': ' . $message
                : $this->message;

        parent::__construct($message);
    }
}
