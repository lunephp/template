<?php


namespace Lune\Template\Exception;

use Exception;

class FileNotFoundException extends Exception
{
    private $files;

    public function __construct($files)
    {

        $files = implode(', ', (array)$files);

        $this->files = (array)$files;
        parent::__construct("Unable to locate template ({$files})");
    }

    
    public function getFiles(): array
    {
        return $this->files;
    }

}