<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Press;

use Orchid\Press\Models\Tag;
use Orchid\Press\Models\Post;
use Orchid\Tests\TestUnitCase;
use Orchid\Press\Models\Tagged;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TagTest extends TestUnitCase
{
    /** @test */
    public function testCanDeleteTagAndTaggedRelations()
    {
        $post = factory(Post::class)->create();

        $post->tag('foo, bar');

        $this->assertCount(2, $post->tags);

        $tag = Tag::first();

        $tag->delete();

        $post = $post->fresh();

        $this->assertCount(1, $post->tags);
    }

    /** @test */
    public function testHasTaggableRelationship()
    {
        $tag = new Tag();

        $this->assertInstanceOf(MorphTo::class, $tag->taggable());
    }

    /** @test */
    public function testHasTagRelationship()
    {
        $tag = new Tag();

        $this->assertInstanceOf(HasMany::class, $tag->tagged());
    }

    /** @test */
    public function testHasNameScope()
    {
        Tag::create(['name' => 'Foo', 'slug' => 'foo', 'namespace' => 'foo']);

        $this->assertCount(1, Tag::name('Foo')->get());
    }

    /** @test */
    public function testHasSlugScope()
    {
        Tag::create(['name' => 'Foo', 'slug' => 'foo', 'namespace' => 'foo']);

        $this->assertCount(1, Tag::slug('foo')->get());
    }

    /** @test */
    public function testCanGetAndSetTaggedModel()
    {
        $tag = new Tag();

        $tag->setTaggedModel(Tagged::class);

        $this->assertEquals(Tagged::class, $tag->getTaggedModel());
    }
}
