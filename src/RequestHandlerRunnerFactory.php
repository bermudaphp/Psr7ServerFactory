<?php


namespace Bermuda\RequestHandlerRunner;


use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;


/**
 * Class RequestHandlerRunnerFactory
 * @package Bermuda\RequestHandlerRunner
 */
final class RequestHandlerRunnerFactory
{
    public function __invoke(ContainerInterface $c): RequestHandlerRunner
    {
       return new RequestHandlerRunner($c->get('requestHandler'), $this->getEmitter($c), 
            $this->getServerRequestFactory($c), $this->getErrorResponseGenerator($c)
       );
    }
    
    private function getEmitter(ContainerInterface $c): EmmiterInterface
    {
        if($c->has(EmitterInterface::class))
        {
            return $c->get(EmitterInterface::class);
        }
        
        return (new EmitterFactory)($c);
    }
    
    private function getServerRequestFactory(ContainerInterface $c): callable
    {
        if($container->has('serverRequestFactory'))
        {
            return $container->get('serverRequestFactory');
        }
        
        return [$this->getServerRequestCreator(), 'fromGlobals'];
    }
    
    private function getErrorResponseGenerator(ContainerInterface $c): callable
    {
        return function(\Throwable $e) use ($generator = $c->get(ErrorResponseGeneratorInterface::class)): ResponseInterface
        {
            return $generator->generate($e, $this->getServerRequestCreator->fromGlobals());
        };
    }
    
    private function getServerRequestCreator(): ServerRequestCreator
    {
        $psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
        return [new ServerRequestCreator($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory), 'fromGlobals'];
    }
}
