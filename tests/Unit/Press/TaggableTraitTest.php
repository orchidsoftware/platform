<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Press;

use Orchid\Press\Models\Tag;
use Orchid\Press\Models\Post;
use Orchid\Tests\TestUnitCase;

class TaggableTraitTest extends TestUnitCase
{
    /** @test */
    public function testCanAddSingleTag()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();

        $post1->tag('foo');
        $post2->tag(['foo']);

        $this->assertSame(['foo'], $post1->tags->pluck('slug')->toArray());
        $this->assertSame(['foo'], $post2->tags->pluck('slug')->toArray());
    }

    /** @test */
    public function testCanAddMultipleTags()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();
        $post3 = factory(Post::class)->create();

        $post1->tag('foo, bar');
        $post2->tag(['foo', 'bar']);
        $post3->tag(null);

        $this->assertSame(['foo', 'bar'], $post1->tags->pluck('slug')->toArray());
        $this->assertSame(['foo', 'bar'], $post2->tags->pluck('slug')->toArray());
        $this->assertEmpty($post3->tags->pluck('slug')->toArray());
    }

    /** @test */
    public function testCanUntag()
    {
        $post = factory(Post::class)->create();

        $post->tag('foo');

        $this->assertSame(['foo'], $post->tags->pluck('slug')->toArray());

        $post->untag('foo');
        $post->untag('foo');

        $this->assertEmpty($post->tags->pluck('slug')->toArray());
    }

    /** @test */
    public function testCanRemoveAllTags()
    {
        $post = factory(Post::class)->create();

        $post->tag('foo, bar, baz');

        $this->assertCount(3, $post->tags);

        $post->untag();

        $this->assertCount(0, $post->tags);
    }

    /** @test */
    public function testCanSetTags()
    {
        $post = factory(Post::class)->create();

        $post->tag('baz');

        $post->setTags('foo, bar');

        $this->assertSame(['foo', 'bar'], $post->tags->pluck('slug')->toArray());
    }

    /** @test */
    public function testCanRetrieveTags()
    {
        $post = factory(Post::class)->create();

        $post->tag('foo, bar, baz');

        $this->assertCount(3, $post->tags);
    }

    /** @test */
    public function testCanRetrieveAllTags()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();

        $post1->tag('foo, bar, baz');
        $post2->tag('fooo');

        $this->assertCount(4, Post::allTags()->get());
        $this->assertCount(0, $this->getPostAlternativeClass()->allTags()->get());
    }

    private function getPostAlternativeClass()
    {
        return new class() extends Post {
        };
    }

    /** @test */
    public function testCanRetrieveByGivenTags()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();

        $post1->tag('foo, bar, baz');
        $post2->tag('foo, bat');

        $this->assertCount(1, Post::whereTag('foo, bar')->get());

        $this->assertCount(2, Post::withTag('foo')->get());

        $this->assertCount(1, Post::withTag('bat')->get());
    }

    /** @test */
    public function testCanRetrieveWithoutTheGivenTags()
    {
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();

        $post1->tag('foo, bar, baz');
        $post2->tag('foo, bat');

        $this->assertCount(0, Post::withoutTag('foo')->get());

        $this->assertCount(1, Post::withoutTag('bar')->get());

        $this->assertCount(1, Post::withoutTag('bat')->get());
    }

    /** @test */
    public function testCanGetAndSetTagsDelimiter()
    {
        $post = factory(Post::class)->create();

        $post->setTagsDelimiter(',');

        $this->assertSame(',', $post->getTagsDelimiter());
    }

    /** @test */
    public function testCanGetAndSetTagsModel()
    {
        $post = factory(Post::class)->create();

        $post->setTagsModel(Tag::class);

        $this->assertSame(Tag::class, $post->getTagsModel());
    }

    /** @test */
    public function testCanGetAndSetSlugGenerator()
    {
        $post = factory(Post::class)->create();

        $post->setSlugGenerator('Illuminate\Support\Str::slug');

        $this->assertSame('Illuminate\Support\Str::slug', $post->getSlugGenerator());
    }
}
