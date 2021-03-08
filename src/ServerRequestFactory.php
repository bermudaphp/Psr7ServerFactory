<?php

namespace Bermuda\RequestHandlerRunner;

use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ServerRequestFactory
 * @package Bermuda\RequestHandlerRunner
 */
final class ServerRequestFactory
{
    public function __invoke(ContainerInterface $container): ServerRequestInterface
    {
        try
        {
            return (new ServerRequestCreator(
                $container->get(Psr\Http\Message\ServerRequestFactory::class), 
                $container->get(Psr\Http\Message\UriFactory::class), 
                $container->get(Psr\Http\Message\UploadedFileFactory::class),
                $container->get(Psr\Http\Message\StreamFactory::class)
            ))->fromGlobals();
        }
        
        catch(\Throwable $e)
        {
            return self::fromGlobals();
        }
    }
    
    public static function fromGlobals(): ServerRequestInterface
    {
        return (new ServerRequestCreator(
                $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory(),
                $psr17Factory, $psr17Factory, $psr17Factory
        ))->fromGlobals();
    }
}
