<?php

class LicenseExpiredException extends Exception
{
    public function __construct($message = "License expired", $code = 403)
    {
        parent::__construct($message, $code);
    }
}
