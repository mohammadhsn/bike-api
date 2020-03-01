<?php

namespace Test\Utility;

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithExceptionHandling;

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../../bootstrap/app.php';
    }
}
