<?php


namespace Bermuda\RequestHandlerRunner;


use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;


final class ConfigProvider
{
    public function __invoke(): array
    {
        return ['dependencies' => ['factories' => $this->getFactories()]];
    }

    private function getFactories(): array
    {
        $psr17factory = function()
        {
            return new Psr17Factory();
        };

        return [
            RequestFactoryInterface::class => $psr17factory,
            UriFactoryInterface::class => $psr17factory,
            ServerRequestFactoryInterface::class => $psr17factory,
            ResponseFactoryInterface::class => $psr17factory,
            UploadedFileFactoryInterface::class => $psr17factory,
            StreamFactoryInterface::class => $psr17factory,
            EmitterInterface::class => EmitterFactory::class,
            RequestHandlerRunner::class => RequestHandlerRunnerFactory::class,
        ];
    }
}
