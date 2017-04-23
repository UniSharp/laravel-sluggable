<?php

namespace Tests;

use Closure;
use Mockery as m;
use CreatePostsTable;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Capsule\Manager;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected $migrations = [
        CreatePostsTable::class,
    ];

    public function setUp()
    {
        $this->setMocks();

        $this->migrate();
    }

    public function tearDown()
    {
        $this->migrateRollback();

        m::close();
    }

    protected function setMocks()
    {
        $app = m::mock(Container::class);
        $app->shouldReceive('instance');
        $app->shouldReceive('offsetGet')->with('db')->andReturn(
            m::mock('db')->shouldReceive('connection')->andReturn(
                m::mock('connection')->shouldReceive('getSchemaBuilder')->andReturn('schema')->getMock()
            )->getMock()
        );
        $app->shouldReceive('offsetGet');

        Schema::setFacadeApplication($app);
        Schema::swap(Manager::Schema());
    }

    protected function migrate()
    {
        foreach ($this->migrations as $migration) {
            (new $migration)->up();
        }
    }

    protected function migrateRollback()
    {
        foreach (array_reverse($this->migrations) as $migration) {
            (new $migration)->down();
        }
    }
}
