<?php

use Ellipse\Contracts\Templating\EngineAdapterFactoryInterface;

use Ellipse\Templating\EngineFactory;
use Ellipse\Templating\Engine;

describe('EngineFactory', function () {

    beforeEach(function () {

        $this->adapter = Mockery::mock(EngineAdapterFactoryInterface::class);

        $this->factory = new EngineFactory($this->adapter);

    });

    describe('->getEngine()', function () {

        it('should return a new Engine', function () {

            $this->adapter->shouldReceive('getEngine')->once()
                ->with('path', ['options']);

            $test = $this->factory->getEngine('path', ['options']);

            expect($test)->to->be->an->instanceof(Engine::class);

        });

    });

});
