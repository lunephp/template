<?php


namespace Lune\Template;


use Lune\Template\Exception\FileNotFoundException;

class Locator
{
    private $root;

    public function __construct($root)
    {
        $this->root = realpath($root);
    }

    public function locate($path)
    {
        foreach ((array)$path as $sub_path) {
            $real = $this->getFullPath($sub_path);
            if ((bool)$real) {
                return $real;
            }
        }

        throw new FileNotFoundException($path);
    }

    private function getFullPath($path)
    {
        return realpath($this->root . '/' . ltrim($path, '/'));
    }
}