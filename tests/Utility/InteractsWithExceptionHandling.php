<?php

namespace Test\Utility;

use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait InteractsWithExceptionHandling
{
    /**
     * The original exception handler.
     *
     * @var ExceptionHandler|null
     */
    protected $originalExceptionHandler;

    /**
     * Restore exception handling.
     *
     * @return $this
     */
    protected function withExceptionHandling()
    {
        if ($this->originalExceptionHandler) {
            $this->app->instance(ExceptionHandler::class, $this->originalExceptionHandler);
        }

        return $this;
    }

    /**
     * Only handle the given exceptions via the exception handler.
     *
     * @param  array  $exceptions
     *
     * @return $this
     */
    protected function handleExceptions(array $exceptions)
    {
        return $this->withoutExceptionHandling($exceptions);
    }

    /**
     * Only handle validation exceptions via the exception handler.
     *
     * @return $this
     */
    protected function handleValidationExceptions()
    {
        return $this->handleExceptions([ValidationException::class]);
    }

    /**
     * Disable exception handling for the test.
     *
     * @param  array  $except
     *
     * @return $this
     */
    protected function withoutExceptionHandling(array $except = [])
    {
        if ($this->originalExceptionHandler == null) {
            $this->originalExceptionHandler = app(ExceptionHandler::class);
        }

        $this->app->instance(ExceptionHandler::class, new class($this->originalExceptionHandler, $except) implements ExceptionHandler {
            protected $except;
            protected $originalHandler;

            /**
             * Create a new class instance.
             *
             * @param ExceptionHandler $originalHandler
             * @param  array  $except
             *
             * @return void
             */
            public function __construct($originalHandler, $except = [])
            {
                $this->except = $except;
                $this->originalHandler = $originalHandler;
            }

            /**
             * Report or log an exception.
             *
             * @param Exception $e
             *
             *@throws Exception
             *
             * @return void
             */
            public function report(Exception $e)
            {
                //
            }

            /**
             * Determine if the exception should be reported.
             *
             * @param Exception $e
             *
             * @return bool
             */
            public function shouldReport(Exception $e)
            {
                return false;
            }

            /**
             * Render an exception into an HTTP response.
             *
             * @param  Request  $request
             * @param Exception $e
             *
             *@throws Exception
             *
             * @return \Symfony\Component\HttpFoundation\Response
             */
            public function render($request, Exception $e)
            {
                foreach ($this->except as $class) {
                    if ($e instanceof $class) {
                        return $this->originalHandler->render($request, $e);
                    }
                }

                if ($e instanceof NotFoundHttpException) {
                    throw new NotFoundHttpException(
                        "{$request->method()} {$request->url()}",
                        null,
                        $e->getCode()
                    );
                }

                throw $e;
            }

            /**
             * Render an exception to the console.
             *
             * @param  OutputInterface  $output
             * @param  Exception $e
             *
             * @return void
             */
            public function renderForConsole($output, Exception $e)
            {
                (new ConsoleApplication)->renderException($e, $output);
            }
        });

        return $this;
    }
}
