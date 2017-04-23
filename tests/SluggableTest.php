<?php

namespace Tests;

use Tests\Models\Post;
use UniSharp\Sluggable\SlugGenerator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SluggableTest extends TestCase
{
    public function testGetSlugKeyName()
    {
        $post = new Post;

        $this->assertEquals('slug', $post->getSlugKeyName());
    }

    public function testGetSlugKey()
    {
        $post = new Post;

        $post->slug = 'foo';

        $this->assertEquals('foo', $post->getSlugKey());
    }

    public function testGetSlugSeparator()
    {
        $post = new Post;

        $this->assertEquals('-', $post->getSlugSeparator());
    }

    public function testGetSlugSourceName()
    {
        $post = new Post;

        $this->assertEquals('title', $post->getSlugSourceName());
    }

    public function testGetSlugSource()
    {
        $post = new Post(['title' => 'foo']);

        $this->assertEquals('foo', $post->getSlugSource());
    }

    public function testGetSlugGenerator()
    {
        $post = new Post;

        $this->assertInstanceOf(SlugGenerator::class, $post->getSlugGenerator());
    }

    public function testGenerateSlug()
    {
        $post = new Post(['title' => 'foo']);

        $this->assertEquals('foo', $post->generateSlug());
    }

    public function testAppendSlugWhenSave()
    {
        $post = Post::create([
            'title' => 'foo',
            'content' => 'bar',
        ]);

        $this->assertEquals('foo', $post->getSlugKey());
    }

    public function testFindBySlug()
    {
        $post = Post::create([
            'title' => 'foo',
            'content' => 'bar',
        ]);

        $this->assertTrue(Post::findBySlug('foo')->is($post));
    }

    public function testFindBySlugOrFail()
    {
        $this->expectException(ModelNotFoundException::class);

        Post::findBySlugOrFail('foo');
    }
}
