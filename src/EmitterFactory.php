<?php

namespace Bermuda\PSR7ServerFactory;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\Emitter\EmitterStack;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter;

/**
 * Class EmitterFactory
 * @package Bermuda\PSR7ServerFactory
 */
final class EmitterFactory
{
    public function __invoke(ContainerInterface $container): EmitterInterface
    {
        $stack = new EmitterStack();
        
        $stack->push(new SapiEmitter);
        $stack->push(new class(new SapiStreamEmitter($this->getMaxBufferLength($container))) implements EmitterInterface
        {
            private $emitter;

            public function __construct(EmitterInterface $emitter)
            {
                $this->emitter = $emitter;
            }

            public function emit(ResponseInterface $response): bool
            {
                if (!$response->hasHeader('Content-Disposition') && !$response->hasHeader('Content-Range'))
                {
                    return false;
                }
                
                return $this->emitter->emit($response);
            }
        });
        
        return $stack;
    }
    
    private function getMaxBufferLength(ContainerInterface $container): int
    {
        try {
            return $container->get('config')['emitter.maxBufferLength'] ?? 8192;
        }
        
        catch(\Throwable $e)
        {
            return 8192;
        }
    }
}
