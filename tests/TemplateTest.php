<?php


namespace Lune\Template\Tests;

use PHPUnit_Framework_TestCase;

use Lune\Template\Engine;
use Lune\Template\Template;

class TemplateTest extends PHPUnit_Framework_TestCase
{


    /**
     * @test
     */
    public function testVariableInheritance()
    {
        $engine = new Engine(__DIR__ . '/res');
        $engine->bind('test', 'engine_value');

        $template = $engine->template("test.php");

        $this->assertEquals($template->test, 'engine_value');

        $template->bind('test', 'template_value');
        $this->assertEquals($template->test, 'template_value');

        $template->unbind('test');
        $this->assertEquals($template->test, 'engine_value');
    }

    /**
     * @test
     */
    public function testFunctions()
    {
        $engine = new Engine(__DIR__ . '/res');
        $template = $engine->template("test.php");

        $engine->registerFunction('cleanup', function ($input) {
            return strtolower(trim($input));
        });

        $this->assertEquals($template->cleanup(' TEST '), 'test');

        $engine->registerFunction('currentScopeClass', function () {
            return get_class($this);
        });


        $this->assertEquals($template->currentScopeClass(), Template::class);
    }

    /**
     * @test
     */
    public function testLocator()
    {
        $engine = new Engine(__DIR__ . '/res');
        $file = $engine->locate([
            'non_existing.php',
            'test.php'
        ]);
        $this->assertEquals($file, realpath(__DIR__ . '/res/test.php'));
    }
    /**
     * @test
     */
    public function testOutput()
    {
        $engine = new Engine(__DIR__ . '/res');
        $template = $engine->template("test.php");

        $this->assertEquals($template->render(), "template test file");
    }
}