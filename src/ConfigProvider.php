<?php


namespace Bermuda\RequestHandlerRunner;


use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;


final class ConfigProvider
{
    public function __invoke(): array
    {
        return ['dependencies' => ['factories' => [
                    EmitterInterface::class => EmitterFactory::class, 
                    RequestHandlerRunner::class => RequestHandlerRunnerFactory::class'
                ]]
        ];
    }
}
