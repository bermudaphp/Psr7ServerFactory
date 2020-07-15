<?php


namespace Bermuda\RequestHandlerRunner;


use Psr\Container\ContainerInterface;
use Bermuda\Pipeline\PipelineInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Bermuda\ErrorHandler\ErrorResponseGeneratorInterface;


/**
 * Class RequestHandlerRunnerFactory
 * @package Bermuda\RequestHandlerRunner
 */
final class RequestHandlerRunnerFactory
{
    public function __invoke(ContainerInterface $c): RequestHandlerRunner
    {
       return new RequestHandlerRunner($c->get(PipelineInterface::class), $this->getEmitter($c),
            $this->getServerRequestFactory($c), static function(\Throwable $e) use ($c): ResponseInterface
            {
                return $c->get(ErrorResponseGeneratorInterface::class)->generate($e, (new ServerRequestFactory)());
            }
       );
    }
    
    private function getEmitter(ContainerInterface $c): EmitterInterface
    {
        if($c->has(EmitterInterface::class))
        {
            return $c->get(EmitterInterface::class);
        }
        
        return (new EmitterFactory)($c);
    }
    
    private function getServerRequestFactory(ContainerInterface $c): callable
    {
        if($c->has('serverRequestFactory'))
        {
            return $c->get('serverRequestFactory');
        }
        
        return new ServerRequestFactory;
    }
}
