<?php

namespace Bermuda\PSR7ServerFactory;

use Bermuda\HTTP\Emitter;
use Psr\Container\ContainerInterface;

final class EmitterFactory
{
    public function __invoke(ContainerInterface $container): Emitter
    {
        try {
            $length = $config = $container->get('config')['emitter.maxBufferLength'] ?? 8192;
        } catch(\Throwable $e) {
            $length = 8192;
        }
        
        return new Emitter($length);
    }
}
