<?php


namespace Lune\Template;

use Closure;
use Lune\Template\Properties\Functions;
use Lune\Variables\HasVariablesTrait;


class Engine implements TemplateCreatorInterface
{
    use HasVariablesTrait;

    private $locator;
    private $functions;

    public function __construct($root, $variables = [])
    {
        $this->locator = new Locator($root);
        $this->setVariables($variables);
        $this->functions = new Functions();
    }

    public function template($filename, $variables = []):Template
    {
        return new Template($filename, $variables, $this);
    }

    public function locate($filename):string
    {
        return $this->locator->locate($filename);
    }

    public function variables():array
    {
        return $this->getVariables()->all();
    }

    public function getFunction($name, $scope = null):callable
    {
        $function = $this->functions->get($name);
        if (!is_null($scope) && ($function instanceof Closure)) {
            return $function->bindTo($scope);
        }
        return $function;
    }

    public function bind($name, $value = null)
    {
        $this->getVariables()->set($name, $value);
    }

    public function unbind($name)
    {
        $this->getVariables()->remove($name);
    }

    public function registerFunction($name, callable $callback)
    {
        $this->functions->register($name, $callback);
    }
}