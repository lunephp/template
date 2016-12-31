<?php


namespace Lune\Template;


interface TemplateCreatorInterface
{
    public function template($filename, $variables = []):Template;

    public function locate($filename):string;

    public function variables():array;

    public function getFunction($name, $scope = null):callable;
}