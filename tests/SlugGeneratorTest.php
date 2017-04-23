<?php

namespace Tests;

use UniSharp\Sluggable\SlugGenerator;

class SlugGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $generator = new SlugGenerator('-');

        $this->assertEquals('foo', $generator->generate('foo'));
        $this->assertEquals('foo', $generator->generate('Foo'));
        $this->assertEquals('foo-bar', $generator->generate('Foo Bar'));
        $this->assertEquals('foo-bar', $generator->generate("Foo'Bar"));
        $this->assertEquals('foo-bar', $generator->generate('Foo    Bar'));
    }
}
