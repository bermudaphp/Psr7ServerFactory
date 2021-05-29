<?php

namespace Bermuda\PSR7ServerFactory;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;

final class ConfigProvider extends \Bermuda\Config\ConfigProvider
{
    protected function getFactories(): array
    {
        return [
            EmitterInterface::class => EmitterFactory::class,
            ServerRequestCreatorIntreface::class => ServerRequestCreatorFactory::class,
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
