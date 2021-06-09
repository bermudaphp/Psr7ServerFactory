<?php

namespace Bermuda\PSR7ServerFactory;

use Laminas\Diactoros\RequestFactory;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\StreamFactory;
use Laminas\Diactoros\UriFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Nyholm\Psr7\Factory\Psr17Factory as NyholmPsr17Factory;

/**
 * Class Psr17Factory
 * @package Bermuda\PSR7ServerFactory
 */
final class Psr17Factory implements ServerRequestFactoryInterface,
    UriFactoryInterface, StreamFactoryInterface, ResponseFactoryInterface,
    RequestFactoryInterface
{
    private ?UriFactoryInterface $uriFactory = null;
    private ?StreamFactoryInterface $streamFactory = null;
    private ?RequestFactoryInterface $requestFactory = null;
    private ?ResponseFactoryInterface $responseFactory = null;
    private ?ServerRequestFactoryInterface $serverRequestFactory = null;

    public function __construct()
    {
        if (class_exists(NyholmPsr17Factory::class))
        {
            $this->serverRequestFactory =
                $this->uriFactory =
                $this->responseFactory =
                $this->requestFactory =
                $this->streamFactory = new NyholmPsr17Factory;
        }

        elseif (class_exists(RequestFactory::class))
        {
            $this->uriFactory = new UriFactory();
            $this->streamFactory = new StreamFactory();
            $this->requestFactory = new RequestFactory();
            $this->responseFactory = new ResponseFactory();
            $this->serverRequestFactory = new ServerRequestFactory();
        }
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        if ($this->responseFactory)
        {
            return $this->responseFactory->createResponse($code, $reasonPhrase);
        }

        throw new \RuntimeException('No available PSR-7 Response implementation');
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        if ($this->serverRequestFactory)
        {
            return $this->serverRequestFactory->createServerRequest($method, $uri, $serverParams);
        }

        throw new \RuntimeException('No available PSR-7 ServerRequest implementation');
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function createStream(string $content = ''): StreamInterface
    {
        if ($this->streamFactory)
        {
            return $this->streamFactory->createStream($content);
        }

        throw new \RuntimeException('No available PSR-7 Stream implementation');
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        if ($this->streamFactory)
        {
            return $this->streamFactory->createStreamFromFile($filename, $mode);
        }

        throw new \RuntimeException('No available PSR-7 Stream implementation');
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        if ($this->streamFactory)
        {
            return $this->streamFactory->createStreamFromResource($resource);
        }

        throw new \RuntimeException('No available PSR-7 Stream implementation');
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function createUri(string $uri = ''): UriInterface
    {
        if ($this->uriFactory)
        {
            return $this->uriFactory->createUri($uri);
        }

        throw new \RuntimeException('No available PSR-7 Uri implementation');
    }

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        if ($this->requestFactory)
        {
            return $this->requestFactory->createRequest($method, $uri);
        }

        throw new \RuntimeException('No available PSR-7 Request implementation');
    }
}
