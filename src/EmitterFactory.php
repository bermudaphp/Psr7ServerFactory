<?php


namespace Bermuda\RequestHandlerRunner;


final class EmitterFactory
{
    public function __invoke(ContainerInterface $c): EmitterInterface
    {
        $stack = new EmitterStack();
        $stack->push(new SapiEmitter)
        $stack->push(new class(new SapiStreamEmitter($this->getBufferLength($c)) implements EmitterInterface
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
}
