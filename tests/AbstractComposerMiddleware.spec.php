<?php

use Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

use Ellipse\Container\ReflectionContainer;

use Ellipse\Templating\Engine;
use Ellipse\Templating\AbstractComposerMiddleware;

describe('AbstractComposerMiddleware', function () {

    beforeEach(function () {

        $this->container = Mockery::mock(ReflectionContainer::class);
        $this->engine = Mockery::mock(Engine::class);

        $this->middleware = Mockery::mock(AbstractComposerMiddleware::class . '[getComposer]', [
            $this->container,
            $this->engine,
        ]);

    });

    describe('->process()', function () {

        it('should append the default values retrieved from the composer callable to the template engine by running it through the container', function () {

            $cb = function () {};
            $data = ['key1' => 'value1', 'key2' => 'value2'];

            $request = Mockery::mock(ServerRequestInterface::class);
            $response = Mockery::mock(ResponseInterface::class);
            $delegate = Mockery::mock(DelegateInterface::class);

            $overrides = [ServerRequestInterface::class => $request];

            $this->container->shouldReceive('call')->once()
                ->with($cb, $overrides)
                ->andReturn($data);

            $this->engine->shouldReceive('setDefault')->once()
                ->with('key1', 'value1');

            $this->engine->shouldReceive('setDefault')->once()
                ->with('key2', 'value2');

            $this->middleware->shouldReceive('getComposer')->once()
                ->andReturn($cb);

            $delegate->shouldReceive('process')->once()
                ->with($request)
                ->andReturn($response);

            $test = $this->middleware->process($request, $delegate);

            expect($test)->to->be->equal($response);

        });

    });

});
