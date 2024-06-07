<?php

class EntityTooLargeException extends Exception
{
    public function __construct($message = "File is too large", $code = 413)
    {
        parent::__construct($message, $code);
    }
}
