<?php


namespace Bermuda\RequestHandlerRunner;


use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class ServerRequestFactory
 * @package Bermuda\RequestHandlerRunner
 */
final class ServerRequestFactory
{
    public function __invoke(): ServerRequestInterface
    {
        return (new ServerRequestCreator($factory = new Psr17Factory(), $factory, $factory, $factory))->fromGlobals();
    }
}
