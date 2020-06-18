<?php


namespace Lobster;


use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;


/**
 * Class RequestHandlerRunner
 * @package Lobster\Http
 */
class RequestHandlerRunner
{
    private EmitterInterface $emitter;
    private RequestHandlerInterface $handler;
    private ServerRequestCreator $creator;
    private Contracts\ErrorResponseGenerator $generator;

    /**
     * RequestHandlerRunner constructor.
     * @param RequestHandlerInterface $handler
     * @param EmitterInterface $emitter
     * @param ServerRequestCreator $creator
     * @param Contracts\ErrorResponseGenerator $generator
     */
    public function __construct(RequestHandlerInterface $handler, EmitterInterface $emitter,
        ServerRequestCreator $creator, Contracts\ErrorResponseGenerator $generator)
    {
        $this->handler   = $handler;
        $this->emitter   = $emitter;
        $this->creator   = $creator;
        $this->generator = $generator;
    }

    /**
     * Handle request and emit response
     */
    public function run() : void
    {
        try
        {
            $request = $this->creator->fromGlobals();
            $response = $this->handler->handle($request);
        }

        catch (\Throwable $e)
        {
            $response = ($this->generator)($e, $request);
        }

        $this->emitter->emit($response);
    }
}
