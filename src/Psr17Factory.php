<?php

namespace Bermuda\PSR7ServerFactory;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class Psr17Factory
 * @package Bermuda\PSR7ServerFactory
 */
final class Psr17Factory implements ServerRequestFactoryInterface,
    UriFactoryInterface, StreamFactoryInterface, ResponseFactoryInterface,
    RequestFactoryInterface, UploadedFileFactoryInterface
{
    private ?UriFactoryInterface $uriFactory = null;
    private ?StreamFactoryInterface $streamFactory = null;
    private ?RequestFactoryInterface $requestFactory = null;
    private ?ResponseFactoryInterface $responseFactory = null;
    private ?UploadedFileFactoryInterface $uploadedFileFactory;
    private ?ServerRequestFactoryInterface $serverRequestFactory = null;

    public function __construct()
    {
        if (class_exists('Nyholm\Psr7\Factory\Psr17Factory'))
        {
            $this->serverRequestFactory =
                $this->uriFactory =
                $this->responseFactory =
                $this->requestFactory =
                $this->uploadedFileFactory =
                $this->streamFactory = new \Nyholm\Psr7\Factory\Psr17Factory;
        }

        elseif (class_exists('\Laminas\Diactoros\RequestFactory'))
        {
            $this->uriFactory = new \Laminas\Diactoros\UriFactory;
            $this->streamFactory = new \Laminas\Diactoros\StreamFactory;
            $this->requestFactory = new \Laminas\Diactoros\RequestFactory;
            $this->responseFactory = new \Laminas\Diactoros\ResponseFactory;
            $this->uploadedFileFactory = new \Laminas\Diactoros\UploadedFileFactory;
            $this->serverRequestFactory = new \Laminas\Diactoros\ServerRequestFactory;
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

    /**
     * @inheritDoc
     * @throws \RuntimeException
     */
    public function createUploadedFile(StreamInterface $stream, int $size = null, int $error = \UPLOAD_ERR_OK, string $clientFilename = null, string $clientMediaType = null): UploadedFileInterface
    {
       if ($this->uploadedFileFactory)
       {
           return $this->uploadedFileFactory->createUploadedFile($stream, $size, $error, $clientFilename, $clientMediaType);
       }

       throw new \RuntimeException('No available PSR-7 Uploaded file implementation');
   }
}
