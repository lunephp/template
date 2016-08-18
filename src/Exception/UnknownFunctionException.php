<?php


namespace Lune\Template\Exception;

use Exception;

class UnknownFunctionException extends Exception
{
    public function __construct($name)
    {
        parent::__construct("Unknown function: '{$name}' does not exist");
    }
}