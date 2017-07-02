<?php

use Ellipse\Contracts\Templating\EngineAdapterInterface;

use Ellipse\Templating\Engine;
use Ellipse\Templating\Exceptions\TemplatingException;

describe('Engine', function () {

    beforeEach(function () {

        $this->decorated = Mockery::mock(EngineAdapterInterface::class);

        $this->engine = new Engine($this->decorated);

    });

    describe('->registerNamespace()', function () {

        it('should proxy the underlying template engine registerNamespace method', function () {

            $namespace = 'namespace';
            $path = 'path';

            $this->decorated->shouldReceive('registerNamespace')->once()
                ->with($namespace, $path);

            $this->engine->registerNamespace($namespace, $path);

        });

    });

    describe('->registerFunction()', function () {

        it('should proxy the underlying template engine registerFunction method', function () {

            $name = 'name';
            $cb = function () {};

            $this->decorated->shouldReceive('registerFunction')->once()
                ->with($name, $cb);

            $this->engine->registerFunction($name, $cb);

        });

    });

    describe('->setDefault(), ->render()', function () {

        it('should proxy the underlying template engine render method', function () {

            $name = 'name';
            $data = ['data' => 'value3'];
            $merged = ['merged1' => 'value1', 'merged2' => 'value2', 'data' => 'value3'];
            $expected = 'expected';

            $this->decorated->shouldReceive('render')->once()
                ->with($name, $merged)
                ->andReturn($expected);

            $this->engine->setDefault('merged1', 'value1');
            $this->engine->setDefault('merged2', 'value2');

            $test = $this->engine->render($name, $data);

            expect($test)->to->be->equal($expected);

        });

        it('should catch exceptions from the underlying template engine and throw its own exceptions', function () {

            $name = 'name';
            $data = ['data' => 'value'];

            $this->decorated->shouldReceive('render')->once()
                ->with($name, $data)
                ->andThrow(new Exception);

            expect([$this->engine, 'render'])->with($name, $data)->to->throw(TemplatingException::class);

        });

    });

});
