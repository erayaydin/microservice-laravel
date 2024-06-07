<?php

class DailyLimitException extends Exception
{
    public function __construct($message = "Daily limit exceeded", $code = 429)
    {
        parent::__construct($message, $code);
    }
}
