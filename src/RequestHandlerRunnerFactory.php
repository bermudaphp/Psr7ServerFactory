<?php

namespace Bermuda\RequestHandlerRunner;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Bermuda\Pipeline\PipelineInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Bermuda\ErrorHandler\ErrorResponseGeneratorInterface;

/**
 * Class RequestHandlerRunnerFactory
 * @package Bermuda\RequestHandlerRunner
 */
final class RequestHandlerRunnerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerRunner
    {
       return new RequestHandlerRunner($container->get(PipelineInterface::class), $container->get(EmitterInterface::class),
            static function() use ($container)
            {
                return (new ServerRequestFactory())->__invoke($container);
            }, $this->responseGenerator($container)
       );
    }
    
    private function responseGenerator(ContainerInterface $container): callable
    {
        return static function(\Throwable $e) use ($container): ResponseInterface
        {
            return $container->get(ErrorResponseGeneratorInterface::class)->generate($e, ServerRequestFactory::fromGlobals());
        };
    }
}
