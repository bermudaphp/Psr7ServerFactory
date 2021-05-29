<?php

namespace Bermuda\RequestHandlerRunner;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\UriFactory;
use Psr\Http\Message\ServerRequestFactory;
use Psr\Http\Message\UploadedFileFactory;
use Psr\Http\Message\StreamFactory;

/**
 * Class ServerRequestCreatorFactory
 * @package Bermuda\RequestHandlerRunner
 */
final class ServerRequestCreatorFactory
{
    public function __invoke(ContainerInterface $container): ServerRequestCreator
    {
        return new ServerRequestCreator($container->get(ServerRequestFactory::class), 
            $container->get(UriFactory::class), $container->get(UploadedFileFactory::class),
            $container->get(StreamFactory::class)
        );
    }
}
