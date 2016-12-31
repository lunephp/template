<?php


namespace Lune\Template;


use Lune\Variables\HasVariablesTrait;

class Template implements TemplateCreatorInterface
{
    use HasVariablesTrait;


    private $filename;
    private $parent;

    public function __construct($filename, $variables, TemplateCreatorInterface $parent)
    {
        $this->setFilename($filename);
        $this->setVariables($variables);
        $this->setParent($parent);

    }

    public function setFilename($filename)
    {
        $this->filename = (array)$filename;
    }


    public function getFilename():array
    {
        return $this->filename;
    }

    public function setParent(TemplateCreatorInterface $parent)
    {
        $this->parent = $parent;
    }


    public function getParent():TemplateCreatorInterface
    {
        return $this->parent;
    }

    public function bind($name, $value = null)
    {
        $this->getVariables()->set($name, $value);
    }

    public function unbind($name)
    {
        $this->getVariables()->remove($name);
    }

    public function template($filename, $variables = []):Template
    {
        return new Template($filename, $variables, $this);
    }

    public function __call($name, $arguments)
    {
        $function = $this->getFunction($name, $this);
        return call_user_func_array($function, $arguments);
    }

    public function __get($name)
    {
        $vars = $this->variables();
        return array_key_exists($name, $vars) ? $vars[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->bind($name, $value);
    }

    public function locate($filename):string
    {
        return $this->getParent()->locate($filename);
    }

    public function variables():array
    {
        return array_merge($this->getParent()->variables(), $this->getVariables()->all());
    }

    public function getFunction($name, $scope = null):callable
    {
        return $this->getParent()->getFunction($name, $scope);
    }



    public function render($variables = [])
    {
        ob_start();
        extract(array_merge($this->variables(), $variables));
        include $this->locate($this->filename);
        return ob_get_clean();
    }
}