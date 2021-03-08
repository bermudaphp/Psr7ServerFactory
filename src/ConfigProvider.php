<?php

namespace Bermuda\RequestHandlerRunner;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;

final class ConfigProvider extends \Bermuda\Config\ConfigProvider
{
    protected function getFactories(): array
    {
        return [
            RequestFactoryInterface::class => Psr17Factory::class,
            UriFactoryInterface::class => Psr17Factory::class,
            ServerRequestFactoryInterface::class => Psr17Factory::class,
            ResponseFactoryInterface::class => Psr17Factory::class,
            UploadedFileFactoryInterface::class => Psr17Factory::class,
            StreamFactoryInterface::class => Psr17Factory::class,
            EmitterInterface::class => EmitterFactory::class,
            RequestHandlerRunner::class => RequestHandlerRunnerFactory::class,
        ];
    }
}
