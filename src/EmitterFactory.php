<?php


namespace Bermuda\RequestHandlerRunner;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\Emitter\EmitterStack;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiStreamEmitter;


/**
 * Class EmitterFactory
 * @package Bermuda\RequestHandlerRunner
 */
final class EmitterFactory
{
    public function __invoke(ContainerInterface $c): EmitterInterface
    {
        $stack = new EmitterStack();
        
        $stack->push(new SapiEmitter);
        $stack->push(new class(new SapiStreamEmitter($this->getMaxBufferLength($c))) implements EmitterInterface
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
    
    private function getMaxBufferLength(ContainerInterface $c): int
    {
        return 8192;
    }
}
