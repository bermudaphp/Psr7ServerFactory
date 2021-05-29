<?php

namespace Bermuda\PSR7ServerFactory;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * Class ServerRequestCreatorFactory
 * @package Bermuda\PSR7ServerFactory
 */
final class ServerRequestCreatorFactory
{
    public function __invoke(ContainerInterface $container): ServerRequestCreator
    {
        return new ServerRequestCreator($container->get(ServerRequestFactoryInterface::class),
            $container->get(UriFactoryInterface::class), $container->get(UploadedFileFactoryInterface::class),
            $container->get(StreamFactoryInterface::class)
        );
    }
}
