<?php


namespace Lune\Template\Properties;


use Lune\Template\Exception\UnknownFunctionException;

class Functions
{

    private $functions = [];

    public function __construct(array $functions = [])
    {
        foreach ($functions as $name => $handler) {
            $this->register($name, $handler);
        }
    }

    public function register($name, callable $handler)
    {
        $this->functions[$name] = $handler;
    }

    public function has($name)
    {
        return array_key_exists($name, $this->functions);
    }

    public function get($name)
    {
        if (!$this->has($name)) {
            throw new UnknownFunctionException($name);
        }
        return $this->functions[$name];
    }

}