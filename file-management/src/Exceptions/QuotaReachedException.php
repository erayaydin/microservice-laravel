<?php

class QuotaReachedException extends Exception
{
    public function __construct($message = "Quota reached", $code = 413)
    {
        parent::__construct($message, $code);
    }
}
