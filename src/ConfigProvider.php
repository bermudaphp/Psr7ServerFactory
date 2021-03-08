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
            EmitterInterface::class => EmitterFactory::class,
            RequestHandlerRunner::class => RequestHandlerRunnerFactory::class,
        ];
    }
    
    protected function getInvokables(): array
    {
        return [
            UriFactoryInterface::class => \Nyholm\Psr7\Factory\Psr17Factory::class,
            ServerRequestFactoryInterface::class => \Nyholm\Psr7\Factory\Psr17Factory::class,
            ResponseFactoryInterface::class => \Nyholm\Psr7\Factory\Psr17Factory::class,
            UploadedFileFactoryInterface::class => \Nyholm\Psr7\Factory\Psr17Factory::class,
            StreamFactoryInterface::class => \Nyholm\Psr7\Factory\Psr17Factory::class,
        ];
    }
}
