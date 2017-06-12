<?php

use Ellipse\Contracts\Templating\EngineInterface;

use Ellipse\Templating\Engine;

describe('Engine', function () {

    beforeEach(function () {

        $this->decorated = Mockery::mock(EngineInterface::class);

        $this->engine = new Engine($this->decorated);

    });

    describe('->setDefault(), ->render()', function () {

        it('should proxy the underlying plates instance render method', function () {

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

    });

});
