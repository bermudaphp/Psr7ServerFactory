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
        return (new ServerRequestCreator(
            $container->get(Psr\Http\Message\ServerRequestFactory::class), 
            $container->get(Psr\Http\Message\UriFactory::class), 
            $container->get(Psr\Http\Message\UploadedFileFactory::class),
            $container->get(Psr\Http\Message\StreamFactory::class)
        ))->fromGlobals();
    }
}
